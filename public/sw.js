var CACHE_NAME = "pwa-cache";
var ROOT = "/PWA/how-to-pwa/public";
var urlsToCache = [
  "https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css",
  "https://fonts.googleapis.com/css?family=Lato|Open+Sans|PT+Serif|Roboto:300,400,500,700|Material+Icons|Ubuntu|Vollkorn",
  "https://code.jquery.com/jquery-3.3.1.slim.min.js",
  "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js",
  "https://cdn.rawgit.com/FezVrasta/snackbarjs/1.1.0/dist/snackbar.min.js",
  "https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js",
  ROOT + "/",
  ROOT + "/css/style.css",
  ROOT + "/css/prism.css",
  ROOT + "/js/prism.js",
  ROOT + "/js/scripts.js"
];

self.addEventListener("install", function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      console.log("Opened cache");
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("fetch", function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      // Cache hit - return response
      if (response) {
        return response;
      }
      return fetch(event.request);
    })
  );
});
