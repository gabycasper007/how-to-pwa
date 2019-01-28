const ROOT = "/PWA/how-to-pwa/public/";
const installBtn = document.querySelector("#InstallPWA");
const cards = document.querySelector("#cards");
const FORM = document.querySelector("#syncForm");
const TITLE_INPUT = document.querySelector("#title");
const LOCATION_INPUT = document.querySelector("#location");
const enableNotificationsButton = document.querySelector(
  "#enableNotifications"
);
var networkDataReceived = false;
let deferredPrompt;

// Load Material Bootstrap
$(document).ready(function() {
  $("body").bootstrapMaterialDesign();
});

// Promise Polyfill
if (!window.Promise) {
  window.Promise = Promise;
}

// Show Enable Notifications button
if ("Notification" in window && enableNotificationsButton) {
  enableNotificationsButton.style.display = "block";
  enableNotificationsButton.addEventListener("click", function() {
    Notification.requestPermission(function(result) {
      console.log("User choice for notifications", result);
      if (result !== "default") {
        enableNotificationsButton.style.display = "none";
      }
      if (result === "granted") {
        if ("serviceWorker" in navigator) {
          let options = {
            body: "You successfully subscribed to our notification service!",
            icon: ROOT + "img/icons/icon-96x96.png",
            image: ROOT + "img/pwa.png",
            dir: "ltr",
            lang: "en-US",
            vibrate: [100, 50, 200],
            badge: ROOT + "img/icons/icon-96x96.png"
          };
          navigator.serviceWorker.ready.then(function(sw) {
            sw.showNotification("Successfully subscribed (from SW)!", options);
          });
        }
      }
    });
  });
}

// Register ServiceWorker
if ("serviceWorker" in navigator) {
  window.addEventListener("load", function() {
    navigator.serviceWorker.register(ROOT + "sw.js").then(
      function(reg) {
        // console.log("SW Registed", reg.scope);
      },
      function(err) {
        console.log("SW failed: ", err);
      }
    );
  });
}

// Defer App's Install Banner
window.addEventListener("beforeinstallprompt", function(event) {
  console.log("beforeinstallprompt fired");
  installBtn.style.display = "block";
  event.preventDefault();
  deferredPrompt = event;
  return false;
});

// Show the App's Install Banner on click
installBtn.addEventListener("click", function() {
  if (deferredPrompt) {
    deferredPrompt.prompt();

    deferredPrompt.userChoice.then(function(choiceResult) {
      console.log(choiceResult.outcome);

      if (choiceResult.outcome === "dismissed") {
        console.log("User cancelled installation");
      } else {
        installBtn.style.display = "none";
        console.log("User added to home screen");
      }
    });

    deferredPrompt = null;
  }
});

if (cards) {
  fetch(POSTS_URL)
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      networkDataReceived = true;
      showcards(data);
    });

  localforage.iterate(function(value, key) {
    if (!networkDataReceived) {
      createCard(value);
    }
  });

  function clearCards() {
    while (cards.hasChildNodes()) {
      cards.removeChild(cards.lastChild);
    }
  }
  // Show all the cards
  function showcards(data) {
    clearCards();
    for (key in data) {
      if (networkDataReceived) {
        addWithLocalForage(key, data[key]);
      }
      createCard(data[key]);
    }
  }

  // Create a single card
  function createCard(data) {
    var card = document.createElement("div");
    var img = document.createElement("img");
    var cardBody = document.createElement("div");
    var cardTitle = document.createElement("h5");
    var cardText = document.createElement("p");

    card.className = "card";

    img.className = "card-img-top";
    img.setAttribute("src", data.image);
    img.setAttribute("alt", data.location);

    cardBody.className = "card-body";
    cardTitle.className = "card-title";
    cardTitle.textContent = data.location;
    cardText.className = "card-text";
    cardText.textContent = data.title;

    cards.appendChild(card).appendChild(img);
    card.appendChild(cardBody).appendChild(cardTitle);
    cardBody.appendChild(cardText);
  }
}

if (FORM) {
  FORM.addEventListener("submit", function(event) {
    event.preventDefault();

    if (TITLE_INPUT.value.trim() === "" || LOCATION_INPUT.value.trim() === "") {
      alert("Please enter valid data!");
      return;
    }

    if ("serviceWorker" in navigator && "SyncManager" in window) {
      navigator.serviceWorker.ready.then(function(sw) {
        let post = {
          id: new Date().toISOString(),
          title: TITLE_INPUT.value,
          location: LOCATION_INPUT.value,
          image: "xxx"
        };

        localForageSync
          .setItem(post.id, post)
          .then(function(value) {
            sw.sync.register("sync-new-posts");
          })
          .then(function() {
            $.snackbar({ content: "Your post was saved for syncing!" });
          })
          .catch(function(err) {
            console.log("Sync Error:", err);
          });
      });
    } else {
      sendData();
    }
  });
}

function sendData() {
  fetch(FIREBASE_STORE_POST_DATA_URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json"
    },
    body: JSON.stringify({
      id: new Date().toISOString(),
      title: TITLE_INPUT.value,
      location: LOCATION_INPUT.value,
      image: "xxx"
    })
  }).then(function(response) {
    console.log("Sent data to Firebase"), response;
    //TODO: createCard()
  });
}
