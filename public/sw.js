var CACHE_NAME = "static-pwa";
var DYNAMIC_CACHE_NAME = "dynamic-pwa";
var ROOT = "/PWA/how-to-pwa/public";
var urlsToCache = [
  "https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css",
  "https://fonts.googleapis.com/css?family=Lato|Open+Sans|PT+Serif|Roboto:300,400,500,700|Material+Icons|Ubuntu|Vollkorn",
  "https://code.jquery.com/jquery-3.3.1.slim.min.js",
  "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js",
  "https://cdn.rawgit.com/FezVrasta/snackbarjs/1.1.0/dist/snackbar.min.js",
  "https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js",
  ROOT + "/",
  ROOT + "/offline.php",
  ROOT + "/css/style.css",
  ROOT + "/css/prism.css",
  ROOT + "/js/prism.js"
];

function trimCache(cacheName, maxItems) {
  caches.open(cacheName).then(function(cache) {
    return cache.keys().then(function(keys) {
      if (keys.length > maxItems) {
        cache.delete(keys[0]).then(trimCache(cacheName, maxItems));
      }
    });
  });
}

self.addEventListener("install", function(event) {
  // Add to static cache
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      console.log("[SW] Opened cache");
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("activate", function(event) {
  console.log("[SW] Activated");
  // Remove old Caches
  event.waitUntil(
    caches.keys().then(function(keys) {
      return Promise.all(
        keys.map(function(key) {
          if (![CACHE_NAME, DYNAMIC_CACHE_NAME].includes(key)) {
            console.log("[SW] Removing old cache", key);
            return caches.delete(key);
          }
        })
      );
    })
  );
  return self.clients.claim();
});

self.addEventListener("fetch", function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      // Cache hit - return response
      if (response) {
        return response;
      }

      // Dynamic Caching
      return fetch(event.request)
        .then(function(response) {
          // Check if we received a valid response
          if (
            !response ||
            response.status !== 200 ||
            response.type === "error"
          ) {
            return response;
          }

          // IMPORTANT: Clone the response. A response is a stream
          // and because we want the browser to consume the response
          // as well as the cache consuming the response, we need
          // to clone it so we have two streams.
          var responseToCache = response.clone();

          caches.open(DYNAMIC_CACHE_NAME).then(function(cache) {
            console.log("[SW] Cache PUT", event.request.url);
            trimCache(DYNAMIC_CACHE_NAME, 30);
            cache.put(event.request, responseToCache);
          });

          return response;
        })
        .catch(function(err) {
          return caches.open(CACHE_NAME).then(function(cache) {
            if (event.request.headers.get("accept").includes("text/html")) {
              return cache.match(ROOT + "/offline.php");
            }
          });
        });
    })
  );
});
