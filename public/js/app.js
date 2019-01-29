const ROOT = "/PWA/how-to-pwa/public/";
const installBtn = document.querySelector("#InstallPWA");
const cards = document.querySelector("#cards");
const FORM = document.querySelector("#syncForm");
const TITLE_INPUT = document.querySelector("#title");
const LOCATION_INPUT = document.querySelector("#location");
const videoPlayer = document.querySelector("#player");
const canvasEl = document.querySelector("#canvas");
const captureBtn = document.querySelector("#capture-btn");
const imagePicker = document.querySelector("#image-picker");
const imagePickerArea = document.querySelector("#pick-image");
const enableNotificationsButton = document.querySelector(
  "#enableNotifications"
);

let networkDataReceived = false;
let deferredPrompt;

// Load Material Bootstrap
$(document).ready(function() {
  $("body").bootstrapMaterialDesign();
});

// Promise Polyfill
if (!window.Promise) {
  window.Promise = Promise;
}

// Show the actual Notification
function displayNotification() {
  let options = {
    body: "You successfully subscribed to our notification service!",
    icon: ROOT + "img/icons/icon-96x96.png",
    image: ROOT + "img/pwa.png",
    dir: "ltr",
    lang: "en-US",
    vibrate: [100, 50, 200],
    badge: ROOT + "img/icons/icon-96x96.png",
    tag: "confirm-notification",
    renotify: true
  };
  navigator.serviceWorker.ready.then(function(sw) {
    sw.showNotification("Successfully subscribed", options);
  });
}

function configurePushSubscription() {
  let reg;
  navigator.serviceWorker.ready
    .then(function(sw) {
      reg = sw;
      return sw.pushManager.getSubscription();
    })
    .then(function(sub) {
      if (sub === null) {
        // Authentification
        // We use Vapid to make sure nobody is allowed to send notifications on our behalf
        let vapidPublicKey = urlBase64ToUint8Array(
          "BBe9Nffr35gtlfpKIQ0VhzaVVM7L-t1lfD3inWM4ItY0aWy8IPFrPLO8MCPYTF4YAoXBGNMmegzYuvFY58Ty9ts"
        );
        // Create new subscription
        return reg.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: vapidPublicKey
        });
      } else {
        // We have a subscription
      }
    })
    .then(function(newSub) {
      return fetch(SUBSCRIPTIONS_URL, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json"
        },
        body: JSON.stringify(newSub)
      });
    })
    .then(function(response) {
      if (response.ok) {
        displayNotification();
      }
    })
    .catch(function(err) {
      console.log("Subscription error", err);
    });
}

// Show Enable Notifications button
if (
  "Notification" in window &&
  "serviceWorker" in navigator &&
  enableNotificationsButton &&
  Notification.permission === "default"
) {
  enableNotificationsButton.style.display = "block";
  enableNotificationsButton.addEventListener("click", function() {
    Notification.requestPermission(function(result) {
      console.log("User choice for notifications", result);
      if (result !== "default") {
        enableNotificationsButton.style.display = "none";
      }
      if (result === "granted") {
        configurePushSubscription();
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
  // Cache then Network Stragegy for  Cards
  fetch(POSTS_URL)
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      networkDataReceived = true;
      showcards(data);
    });

  localforage.iterate(function(value) {
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
    let card = document.createElement("div");
    let img = document.createElement("img");
    let cardBody = document.createElement("div");
    let cardTitle = document.createElement("h5");
    let cardText = document.createElement("p");

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

// Sync Data added in the Form
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

// Send data to Firebase
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
  });
}

initializeMedia();

// Polyfill for Chrome and Mozilla for using Media Devices
function initializeMedia() {
  if (!("mediaDevices" in navigator)) {
    navigator.mediaDevices = {};
  }

  if (!"getUserMedia" in navigator.mediaDevices) {
    navigator.mediaDevices.getUserMedia = function(constraints) {
      let getUserMedia =
        navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
      if (!getUserMedia) {
        return Promise.reject(new Error("Get user media is not implemented!"));
      }
      return new Promise(function(resolve, reject) {
        getUserMedia.call(navigator, constraints, resolve, reject);
      });
    };
  }

  navigator.mediaDevices
    .getUserMedia({
      video: true
    })
    .then(function(stream) {
      videoPlayer.srcObject = stream;
      imagePickerArea.style.display = "none";
      videoPlayer.style.display = "block";
    })
    .catch(function(err) {
      imagePickerArea.style.display = "block";
      videoPlayer.style.display = "none";
      canvasEl.style.display = "none";
    });
}

// Capture Photo from Video Stream
captureBtn.addEventListener("click", function(event) {
  let context = canvasEl.getContext("2d");

  canvasEl.style.display = "block";
  videoPlayer.style.display = "none";
  captureBtn.style.display = "none";

  context.drawImage(
    videoPlayer,
    0,
    0,
    canvas.width,
    videoPlayer.videoHeight / (videoPlayer.videoWidth / canvas.width)
  );

  videoPlayer.srcObject.getVideoTracks().forEach(function(track) {
    track.stop();
  });
});
