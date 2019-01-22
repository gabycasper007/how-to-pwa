var CACHE_NAME = "pwa-cache";
var ROOT = "/PWA/how-to-pwa/public";
var urlsToCache = [
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