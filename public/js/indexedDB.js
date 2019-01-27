// This file uses indexedDB through localforage.js
// https://localforage.github.io/localForage

// Firebase url
const POSTS_URL = "https://how-to-pwa.firebaseio.com/posts.json";
const FIREBASE_STORE_POST_DATA_URL =
  "https://us-central1-how-to-pwa.cloudfunctions.net/storePostData";

// Set and persist localForage options.
// This must be called before any other calls to localForage are made,
localforage.config({
  name: "How to PWA",
  storeName: "pwa_cards"
});

var localForageSync = localforage.createInstance({
  name: "How to PWA",
  storeName: "sync_cards"
});

// Add to IndexedDB Storage
function addWithLocalForage(key, data) {
  return localforage
    .setItem(key, data)
    .then(function(value) {
      //   console.log("LocalForage adding: ", value);
    })
    .catch(function(err) {
      console.log(err);
    });
}

// Get from IndexedDB Storage
function getFromLocalForage(key) {
  return localforage
    .getItem(key)
    .then(function(value) {
      //   console.log("LocalForage getting: ", value);
      return value;
    })
    .catch(function(err) {
      console.log("LocalForage ERROR: ", err);
    });
}
