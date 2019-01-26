// This file uses indexedDB through localforage.js
// https://localforage.github.io/localForage

// Firebase url
const POSTS_URL = "https://how-to-pwa.firebaseio.com/posts.json";

// Set and persist localForage options.
// This must be called before any other calls to localForage are made,
localforage.config({
  name: "How to PWA",
  storeName: "pwa-cards",
  version: "1.0"
});

// Add to IndexedDB Storage
function addWithLocalForage(key, data) {
  localforage
    .setItem(key, data)
    .then(function(value) {
      console.log(value);
    })
    .catch(function(err) {
      console.log(err);
    });
}
