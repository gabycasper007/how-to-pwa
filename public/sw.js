const ROOT = "/PWA/how-to-pwa/public";
const CACHE_NAME = "static-pwa";
const DYNAMIC_CACHE_NAME = "dynamic-pwa";

importScripts(ROOT + "/js/localforage.min.js");
importScripts(ROOT + "/js/indexedDB.js");

// We will add these assets to our static Cache Storage.
let urlsToCache = [
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
  ROOT + "/js/prism.js",
  ROOT + "/js/localforage.min.js",
  ROOT + "/js/indexedDB.js",
  ROOT + "/js/scripts.js"
];

// Prevent the Cache from using too much memory
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
  // Add assets to static Cache Storage
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then(function(cache) {
        console.log("[SW] Opened cache");
        return cache.addAll(urlsToCache);
      })
      .then(function() {
        // Activate the Service Worker
        return self.skipWaiting();
      })
  );
});

self.addEventListener("activate", function(event) {
  console.log("[SW] Activated");
  // Remove old Caches using Versioning
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
  // Claim Activation for current Service Worker in current opened browser tabs
  return self.clients.claim();
});

self.addEventListener("fetch", function(event) {
  // we return the assets from Cache if they exist
  // If they're not found in the cache, we fallback
  // to make a network request
  event.respondWith(
    caches.match(event.request).then(function(response) {
      // Cache hit - return response
      if (response) {
        return response;
      }

      // Request from network
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
          let responseToCache = response.clone();

          // Dynamic Caching
          caches.open(DYNAMIC_CACHE_NAME).then(function(cache) {
            console.log("[SW] Cache PUT", event.request.url);
            // Keep maximum 30 items in the Dynamic Cache Storage
            trimCache(DYNAMIC_CACHE_NAME, 30);

            // Add to Dynamic Cache Storage
            cache.put(event.request, responseToCache);
          });

          return response;
        })
        .catch(function(err) {
          // Resource not found in cache and network request
          // Fallback to show an offline page
          return caches.open(CACHE_NAME).then(function(cache) {
            if (event.request.headers.get("accept").includes("text/html")) {
              return cache.match(ROOT + "/offline.php");
            }
          });
        });
    })
  );
});
