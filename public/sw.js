const ROOT = "/PWA/how-to-pwa/public/";
const CACHE_NAME = "static-pwa-2";
const DYNAMIC_CACHE_NAME = "dynamic-pwa-2";

importScripts(ROOT + "js/localforage.min.js");
importScripts(ROOT + "js/utility.js");

// Fisiere statice - CSS, JS si HTML
let urlsToCache = [
  "https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css",
  "https://fonts.googleapis.com/css?family=Lato|Open+Sans|PT+Serif|Roboto:300,400,500,700|Material+Icons|Ubuntu|Vollkorn",
  "https://code.jquery.com/jquery-3.3.1.slim.min.js",
  "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js",
  "https://cdn.rawgit.com/FezVrasta/snackbarjs/1.1.0/dist/snackbar.min.js",
  "https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js",
  ROOT + "",
  ROOT + "web-app-manifest/",
  ROOT + "service-workers/",
  ROOT + "caching/",
  ROOT + "indexed-db/",
  ROOT + "background-sync/",
  ROOT + "push-notifications/",
  ROOT + "native-device-features/",
  ROOT + "testing-area/",
  ROOT + "offline.php",
  ROOT + "css/style.css",
  ROOT + "css/prism.css",
  ROOT + "js/prism.js",
  ROOT + "js/localforage.min.js",
  ROOT + "js/utility.js",
  ROOT + "js/app.js"
];

self.addEventListener("install", function(event) {
  // Adauga fisierele statice in Cache Storage
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then(function(cache) {
        // console.log("[SW] Am deschis cache");
        return cache.addAll(urlsToCache);
      })
      .then(function() {
        // Activeaza Service Worker
        return self.skipWaiting();
      })
  );
});

self.addEventListener("activate", function(event) {
  // Sterge Cache-uri vechi
  event.waitUntil(
    caches.keys().then(function(keys) {
      return Promise.all(
        keys.map(function(key) {
          if (![CACHE_NAME, DYNAMIC_CACHE_NAME].includes(key)) {
            console.log("[SW] Sterge cache vechi", key);
            return caches.delete(key);
          }
        })
      );
    })
  );
  // Activeaza Service Worker in toate taburile deschise in browserul curent
  return self.clients.claim();
});

self.addEventListener("fetch", function(event) {
  if (event.request.url.indexOf(POSTS_URL) > -1) {
    // Pentru imaginile din Testing Area
    // descarca-le din baza de date Firebase
    // apoi adauga-le in IndexedDB
    event.respondWith(
      fetch(event.request)
        .then(function(response) {
          let clonedRes = response.clone();

          localforage
            .clear()
            .then(function() {
              return clonedRes.json();
            })
            .then(function(data) {
              for (let key in data) {
                addWithLocalForage(key, data[key]);
              }
            });
          return response;
        })
        .catch(function() {})
    );
  } else {
    // Pentru restul fisierelor, le cautam mai intai in Cache
    // Le servim din cache daca le gasim, altfel incercam sa le accesam online
    event.respondWith(
      caches.match(event.request).then(function(response) {
        // Am gasit fisierul in cache, il servesc de acolo
        if (response) {
          return response;
        }

        // Nu am gasit fisierul, incerc sa il accesez online
        return fetch(event.request)
          .then(function(response) {
            // Verificam daca raspunsul este valid
            if (
              !response ||
              response.type === "error" ||
              event.request.url.indexOf("chrome-extension://") > -1
            ) {
              return response;
            }

            // IMPORTANT: Clonam raspunsul deoarece dorim
            // ca si cacheul si browserul sa il foloseasca
            let responseToCache = response.clone();

            // Cache Dinamic pt orice alte resurse care nu sunt deja in cache
            caches.open(DYNAMIC_CACHE_NAME).then(function(cache) {
              // console.log("[SW] Cache PUT", event.request.url);
              // Tinem maxim 30 de fisiere in cache-ul dinamic
              trimCache(DYNAMIC_CACHE_NAME, 30);

              // Adauga in cache dinamic
              if (event.request.url.indexOf(SUBSCRIPTIONS_URL) === -1) {
                cache.put(event.request, responseToCache);
              }
            });

            return response;
          })
          .catch(function(err) {
            // Fisierul nu a fost gasit nici in cache, nici online
            // Daca fisierul este de tip HTML, afisam pagina de rezerva "offline"
            // astfel incat aplicatia sa functioneze mai departe, dar sa atentioneze utilizatorul
            // ca nu are acces la internet iar pagina curenta nu se gaseste in cache
            return caches.open(CACHE_NAME).then(function(cache) {
              if (event.request.headers.get("accept").includes("text/html")) {
                return cache.match(ROOT + "offline.php");
              }
            });
          });
      })
    );
  }
});

// Sincronizeaza pe fundal, trimite catre Firebase
self.addEventListener("sync", function(event) {
  console.log("[SW] Sincronizare pe fundal", event);
  if (event.tag === "sync-new-posts") {
    event.waitUntil(
      localForageSync.iterate(sendDataToFirebase).catch(function(err) {
        console.log("Eroare din LocalForage: ", err);
      })
    );
  }
});

function sendDataToFirebase(value, key) {
  let postData = new FormData();
  postData.append("id", key);
  postData.append("title", value.title);
  postData.append("location", value.location);
  postData.append("rawLocationLat", value.rawLocation.lat);
  postData.append("rawLocationLng", value.rawLocation.lng);
  postData.append("file", value.image, key + ".png");

  fetch(FIREBASE_STORE_POST_DATA_URL, {
    method: "POST",
    body: postData
  })
    .then(function(response) {
      console.log("Am trimis datele catre Firebase", response);
      if (response.ok) {
        console.log("Sterg din IndexedDB elementul sincronizat", key);
        localForageSync.removeItem(key);
      }
    })
    .catch(function(err) {
      console.log("Eroare la sincronizare", err);
    });
}

// Redirectioneaza la Testing Area cand notificarea este apasata
self.addEventListener("notificationclick", function(event) {
  let notification = event.notification;

  event.waitUntil(
    clients.matchAll().then(function(clients) {
      let client = clients.find(function(client) {
        return (client.visibilityState = "visible");
      });
      if (client !== undefined) {
        client.navigate(ROOT + "testing-area/");
        client.focus();
      } else {
        clients.openWindow(ROOT + "testing-area/");
      }
      notification.close();
    })
  );
});

// Inregistreaza faptul ca notificarea a fost inchisa (swiped away)
self.addEventListener("notificationclose", function(event) {
  console.log("Notificarea a fost inchisa", event);
});

// Afiseaza notificarea Push
self.addEventListener("push", function(event) {
  console.log("Am primit o notificare push", event);
  let data = {
    title: "De ultima ora!",
    content: "Ceva nou s-a intamplat!"
  };
  if (event.data) {
    data = JSON.parse(event.data.text());
  }
  let options = {
    body: data.content,
    icon: ROOT + "img/icons/icon-96x96.png",
    badge: ROOT + "img/icons/icon-96x96.png",
    vibrate: [300, 100, 400],
    image: data.image
  };
  event.waitUntil(self.registration.showNotification(data.title, options));
});

// Previne Cache API de la a folosi prea multa memorie,
// tinand in cache doar pana la maxItems elemente
function trimCache(cacheName, maxItems) {
  caches.open(cacheName).then(function(cache) {
    return cache.keys().then(function(keys) {
      if (keys.length > maxItems) {
        cache.delete(keys[0]).then(trimCache(cacheName, maxItems));
      }
    });
  });
}
