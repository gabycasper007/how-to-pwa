const cards = document.querySelector("#cards");
const FORM = document.querySelector("#syncForm");
const titleInput = document.querySelector("#title");
const locationInput = document.querySelector("#location");
const videoPlayer = document.querySelector("#player");
const canvasEl = document.querySelector("#canvas");
const captureBtn = document.querySelector("#capture-btn");
const imagePicker = document.querySelector("#image-picker");
const imagePickerArea = document.querySelector("#pick-image");
const locationBtn = document.querySelector("#location-btn");
const locationLoader = document.querySelector("#location-loader");
const mapImg = document.querySelector("#customMap");
const createPostArea = document.querySelector("#create-post");
const shareImageButton = document.querySelector("#share-image-button");
const closeModalButton = document.querySelector("#close-modal-btn");
const gcAPIkey = "AIzaSyDCAVfl78QdNtzJwiv9LrveBNssezJIWWw";

let networkDataReceived = false;
let deferredPrompt;
let image;
let fetchedLocation = { lat: 0, lng: 0 };

// Incarca Material Bootstrap
$(document).ready(function() {
  $("body").bootstrapMaterialDesign();
});

// Open Modal
function openCreatePostModal() {
  setTimeout(function() {
    createPostArea.style.transform = "translateY(0)";
  }, 1);
  askUserToInstallPWA();
  initializePushNotifications();
  initializeMedia();
  initializeLocation();
}

function askUserToInstallPWA() {
  if (deferredPrompt) {
    deferredPrompt.prompt();

    deferredPrompt.userChoice.then(function(choiceResult) {
      console.log(choiceResult.outcome);

      if (choiceResult.outcome === "dismissed") {
        console.log("User cancelled installation");
      } else {
        console.log("User added to home screen");
      }
    });
    deferredPrompt = null;
  }
}

// Close Modal
function closeCreatePostModal() {
  imagePickerArea.style.display = "none";
  videoPlayer.style.display = "none";
  canvasEl.style.display = "none";
  locationBtn.style.display = "inline";
  locationLoader.style.display = "none";
  captureBtn.style.display = "inline";
  titleInput.value = "";
  locationInput.value = "";
  mapImg.style.display = "none";
  mapImg.innerHTML = "";
  if (videoPlayer.srcObject) {
    videoPlayer.srcObject.getVideoTracks().forEach(function(track) {
      track.stop();
    });
  }
  setTimeout(function() {
    createPostArea.style.transform = "translateY(100vh)";
  }, 1);
}
shareImageButton.addEventListener("click", openCreatePostModal);
closeModalButton.addEventListener("click", closeCreatePostModal);

// Use passive listeners to improve scrolling performance
$.event.special.touchstart = {
  setup: function(_, ns, handle) {
    if (ns.includes("noPreventDefault")) {
      this.addEventListener("touchstart", handle, { passive: false });
    } else {
      this.addEventListener("touchstart", handle, { passive: true });
    }
  }
};

// Promise Polyfill
if (!window.Promise) {
  window.Promise = Promise;
}

// Afiseaza notificare
function displayNotification() {
  let options = {
    body: "Te-ai abonat la serviciul de notificari!",
    icon: ROOT + "img/icons/icon-96x96.png",
    image: ROOT + "img/pwa.png",
    dir: "ltr",
    lang: "ro-RO",
    vibrate: [100, 50, 200],
    badge: ROOT + "img/icons/icon-96x96.png",
    tag: "confirm-notification",
    renotify: true
  };
  navigator.serviceWorker.ready.then(function(sw) {
    sw.showNotification("Abonare cu succes", options);
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
        // Autentificare
        // Folosim Vapid pentru a limita accesul la notificari persoanelor neautorizate
        let vapidPublicKey = urlBase64ToUint8Array(
          "BIfl1Prv850KN3sFkYEQZXqjUDD_PaABmUVHeAQoioxv99KbAb7tmRukk-rxxg_rJ7bJvUxNLd4tKUBrnvIMcLw"
        );
        // Creaza noua abonare
        return reg.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: vapidPublicKey
        });
      } else {
        // Este deja abonat
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
      console.log("Eroare la abonare", err);
    });
}

// Inregistreaza Service Worker
if ("serviceWorker" in navigator) {
  window.addEventListener("load", function() {
    navigator.serviceWorker.register(ROOT + "sw.js").then(
      function(reg) {
        console.log("SW Inregistrat", reg.scope);
      },
      function(err) {
        console.log("SW a dat eroare: ", err);
      }
    );
  });
}

// Amana bannerul pentru instalarea aplicatiei
window.addEventListener("beforeinstallprompt", function(event) {
  console.log("beforeinstallprompt fired");
  event.preventDefault();
  deferredPrompt = event;
  return false;
});

if (cards) {
  // Pentru imaginile din zona de testare
  // Incarcam rapid din cache imaginile
  // Dupa care actualizam imaginile afisate cu cele descarcate de pe internet
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
  // Afisaza toate imaginile
  function showcards(data) {
    clearCards();
    for (key in data) {
      if (networkDataReceived) {
        addWithLocalForage(key, data[key]);
      }
      createCard(data[key]);
    }
  }

  // Afiseaza o imagine
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
    cardTitle.textContent = data.title;
    cardText.className = "card-text";
    cardText.textContent = data.location;

    cards.appendChild(card).appendChild(img);
    card.appendChild(cardBody).appendChild(cardTitle);
    cardBody.appendChild(cardText);
  }
}

// Sincronizeaza datele adaugate in formular
if (FORM) {
  FORM.addEventListener("submit", function(event) {
    event.preventDefault();

    let postData = new FormData();
    let id = new Date().toISOString();

    postData.append("id", id);
    postData.append("title", titleInput.value);
    postData.append("location", locationInput.value);
    postData.append("rawLocationLat", fetchedLocation.lat);
    postData.append("rawLocationLng", fetchedLocation.lng);
    postData.append("file", image, id + ".png");

    if (titleInput.value.trim() === "" || locationInput.value.trim() === "") {
      alert("Completeaza toate campurile!");
      return;
    }

    // Sincronizeaza datele in IndexedDB
    // pentru a le putea trimite atunci cand utilizatorul este online
    if ("serviceWorker" in navigator && "SyncManager" in window) {
      navigator.serviceWorker.ready.then(function(sw) {
        let post = {
          id: id,
          title: titleInput.value,
          location: locationInput.value,
          image: image,
          rawLocation: fetchedLocation
        };

        localForageSync
          .setItem(post.id, post)
          .then(function(value) {
            sw.sync.register("sync-new-posts");
          })
          .then(function() {
            $.snackbar({
              content: "Postarea ta a fost salvata si va fi incarcata ulterior!"
            });
          })
          .catch(function(err) {
            console.log("Eroare sincronizare:", err);
          });
      });
    } else {
      sendData(postData);
    }

    closeCreatePostModal();
  });
}

// Trimite date la baza de date din Firebase
function sendData(postData) {
  fetch(FIREBASE_STORE_POST_DATA_URL, {
    method: "POST",
    body: postData
  }).then(function(response) {
    console.log("Am trimis datele la Firebase"), response;
  });
}

// Polyfill pentru Chrome si Mozilla pentru a folosi instrumente media
function initializeMedia() {
  if (!("mediaDevices" in navigator)) {
    navigator.mediaDevices = {};
  }

  if (!"getUserMedia" in navigator.mediaDevices) {
    navigator.mediaDevices.getUserMedia = function(constraints) {
      let getUserMedia =
        navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
      if (!getUserMedia) {
        return Promise.reject(
          new Error(
            "Browserul folosit nu permite accesul la instrumente media!"
          )
        );
      }
      return new Promise(function(resolve, reject) {
        getUserMedia.call(navigator, constraints, resolve, reject);
      });
    };
  }

  navigator.mediaDevices
    .getUserMedia({
      video: true,
      width: 320,
      height: 240
    })
    .then(function(stream) {
      videoPlayer.srcObject = stream;
      imagePickerArea.style.display = "none";
      videoPlayer.style.display = "block";
      captureBtn.style.display = "inline-block";
    })
    .catch(function(err) {
      imagePickerArea.style.display = "block";
      videoPlayer.style.display = "none";
      canvasEl.style.display = "none";
      captureBtn.style.display = "none";
    });
}

// Capteaza fotografie din flux video
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
  image = dataURItoBlob(canvasEl.toDataURL());
});

// Raspunde la selectorul de imagini
if (imagePicker) {
  imagePicker.addEventListener("change", function(event) {
    image = event.target.files[0];
  });
}

if (locationBtn) {
  locationBtn.addEventListener("click", function(event) {
    if (!"geolocation" in navigator) {
      return;
    }
    let sawAlert = false;

    locationBtn.style.display = "none";
    locationLoader.style.display = "inline-block";

    navigator.geolocation.getCurrentPosition(
      function(postition) {
        fetchedLocation = {
          lat: postition.coords.latitude,
          lng: postition.coords.latitude
        };
        locationInput.value = "Bucuresti";
        document.querySelector("#manual-location").classList.add("is-focused");

        var img = new Image();
        img.src =
          "https://maps.googleapis.com/maps/api/staticmap?center=" +
          postition.coords.latitude +
          "," +
          postition.coords.longitude +
          "&zoom=13&size=600x400&sensor=false&key=" +
          gcAPIkey;

        mapImg.appendChild(img);
        locationLoader.style.display = "none";
        locationBtn.style.display = "none";
        mapImg.style.display = "block";
      },
      function(err) {
        locationBtn.style.display = "inline-block";
        locationLoader.style.display = "none";
        mapImg.style.display = "none";
        if (!sawAlert) {
          alert("Browserul nu a putut obtine locatia, adaug-o manual");
          sawAlert = true;
        }
        fetchedLocation = { lat: 0, lng: 0 };
        console.log(err);
      },
      {
        enableHighAccuracy: true,
        maximumAge: 30000,
        timeout: 27000
      }
    );
  });
}

function initializeLocation() {
  if (!"geolocation" in navigator) {
    locationBtn.style.display = "none";
    mapImg.style.display = "none";
  }
}

function initializePushNotifications() {
  if (
    "Notification" in window &&
    "serviceWorker" in navigator &&
    Notification.permission === "default"
  ) {
    // Cere permisiunea de a afisa notificari push
    Notification.requestPermission(function(result) {
      if (result === "granted") {
        configurePushSubscription();
      }
    });
  }
}
