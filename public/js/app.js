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

let sawAlert = false;
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
  if (deferredPrompt && isOpenedInBrowser()) {
    deferredPrompt.prompt();

    deferredPrompt.userChoice.then(function(choiceResult) {
      console.log(choiceResult.outcome);

      if (choiceResult.outcome === "dismissed") {
        console.log("Utilizatorul a anulat instalarea");
      } else {
        console.log("Utilizatorul a instalat aplicatia");
      }
    });
    deferredPrompt = null;
  }
}

function isOpenedInBrowser() {
  let isPWAinBrowser = true;
  // replace standalone with fullscreen or minimal-ui according to your manifest
  if (matchMedia("(display-mode: standalone)").matches) {
    // Android and iOS 11.3+
    isPWAinBrowser = false;
  } else if ("standalone" in navigator) {
    // useful for iOS < 11.3
    isPWAinBrowser = !navigator.standalone;
  }
  return isPWAinBrowser;
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

// Confirma abonare printr-o notificare
function displayConfirmNotification(response) {
  if (response.ok) {
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
}

function configurePushSubscription(permission) {
  if (permission === "granted") {
    let reg;
    navigator.serviceWorker.ready
      .then(function(sw) {
        reg = sw;
        return sw.pushManager.getSubscription();
      })
      .then(function(subscription) {
        if (subscription === null) {
          // Autentificare
          // Folosim Vapid pentru a limita accesul la notificari persoanelor neautorizate
          let vapidPublicKey = urlBase64ToUint8Array(
            "BJFd3NAen-MmLhyeiWfdqJdbJJqN0uIiLf8qb97NjSRwcAlBk_BWR2DjY_4IDs3kSOKpZzQO5L-PrJ8g3WPZZC4"
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
      .then(storeSubscriptionToServer)
      .then(displayConfirmNotification)
      .catch(function(err) {
        console.log("Eroare la abonare", err);
      });
  }
}

function storeSubscriptionToServer(subscription) {
  return fetch(SUBSCRIPTIONS_URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json"
    },
    body: JSON.stringify(subscription)
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
  console.log("Browserul a incercat afisarea bannerului de instalare");
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
    })
    .catch(function(error) {
      console.log("Nu am putut obtine datele din Firebase", error);
    });

  localforage.iterate(function(value) {
    if (!networkDataReceived) {
      createCard(value);
    }
  });

  // Afisaza toate imaginile
  function showcards(data) {
    let reversed = Object.values(data).reverse();
    clearCards();
    for (key in reversed) {
      if (networkDataReceived) {
        addWithLocalForage(reversed[key].id, reversed[key]);
      }
      createCard(reversed[key]);
    }
  }

  // Sterge toate imaginile
  function clearCards() {
    while (cards.hasChildNodes()) {
      cards.removeChild(cards.lastChild);
    }
  }

  // Afiseaza o imagine
  function createCard(data) {
    let card = document.createElement("div");
    let img = document.createElement("img");
    let cardBody = document.createElement("div");
    let cardTitle = document.createElement("h5");
    let cardText = document.createElement("p");
    let cardWrap = document.createElement("div");

    card.className = "card";
    cardWrap.className = "cardWrap";

    img.className = "card-img-top";
    img.setAttribute("src", data.image);
    img.setAttribute("alt", data.location);

    cardBody.className = "card-body";
    cardTitle.className = "card-title";
    cardTitle.textContent = data.title;
    cardText.className = "card-text";
    cardText.textContent = data.location;

    cardWrap.appendChild(card).appendChild(img);
    cards.appendChild(cardWrap);
    card.appendChild(cardBody).appendChild(cardTitle);
    cardBody.appendChild(cardText);
  }
}

function getFormData() {
  return {
    id: -1 * new Date().getTime(),
    title: titleInput.value,
    location: locationInput.value,
    image: image,
    rawLocation: fetchedLocation
  };
}

// Sincronizeaza datele adaugate in formular
FORM.addEventListener("submit", function(event) {
  event.preventDefault();

  let isFormValid =
    titleInput.value.trim() === "" || locationInput.value.trim() === "";
  let doesBrowserSupportSync =
    "serviceWorker" in navigator && "SyncManager" in window;

  if (isFormValid) {
    alert("Completeaza toate campurile!");
    return;
  }

  let post = getFormData();

  // Sincronizeaza datele in IndexedDB
  // pentru a le putea trimite atunci cand utilizatorul este online
  if (doesBrowserSupportSync) {
    console.log("Browser supports sync");
    navigator.serviceWorker.ready.then(function(sw) {
      savePostForLater(sw, post);
    });
  } else {
    sendDataToFirebase();
  }

  closeCreatePostModal();
});

function savePostForLater(sw, post) {
  localForageSync
    .setItem(post.id.toString(), post)
    .then(function() {
      console.log("Register sync-new-posts");
      return sw.sync.register("sync-new-posts");
    })
    .then(notifyUserAboutSync)
    .catch(function(error) {
      console.log("Eroare sincronizare:", error);
    });
}

function notifyUserAboutSync() {
  $.snackbar({
    content: "Postarea ta a fost salvata si va fi incarcata ulterior!"
  });
}

function createPostData() {
  let postData = new FormData();
  let id = -1 * new Date().getTime();

  postData.append("id", id);
  postData.append("title", titleInput.value);
  postData.append("location", locationInput.value);
  postData.append("rawLocationLat", fetchedLocation.lat);
  postData.append("rawLocationLng", fetchedLocation.lng);
  postData.append("file", image, id + ".png");

  return postData;
}

// Trimite date la baza de date din Firebase
function sendDataToFirebase() {
  let postData = createPostData();
  fetch(FIREBASE_STORE_POST_DATA_URL, {
    method: "POST",
    body: postData
  }).then(function(response) {
    console.log("Am trimis datele la Firebase"), response;
  });
}

// Polyfill pentru webkit si Mozilla pentru a folosi instrumente media
function setMediaDevicesPolyfill() {
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
}

function initializeMedia() {
  setMediaDevicesPolyfill();

  navigator.mediaDevices
    .getUserMedia({
      video: true
    })
    .then(function(stream) {
      // videoPlayer.offsetHeight
      // videoPlayer.offsetWidth
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

  canvasEl.width = videoPlayer.videoWidth;
  canvasEl.height = videoPlayer.videoHeight;
  canvasEl.style.display = "block";
  videoPlayer.style.display = "none";
  captureBtn.style.display = "none";

  context.translate(videoPlayer.videoWidth, 0);
  context.scale(-1, 1);
  context.drawImage(
    videoPlayer,
    0,
    0,
    videoPlayer.videoWidth,
    videoPlayer.videoHeight
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

function createMapImage(position) {
  var img = new Image();
  img.src =
    "https://maps.googleapis.com/maps/api/staticmap?center=" +
    position.coords.latitude +
    "," +
    position.coords.longitude +
    "&zoom=16&size=600x400&sensor=false&key=" +
    gcAPIkey;
  return img;
}

function locationReceived(position) {
  fetchedLocation = {
    lat: position.coords.latitude,
    lng: position.coords.latitude
  };
  locationInput.value = "Bucuresti";
  document.querySelector("#manual-location").classList.add("is-focused");

  mapImg.appendChild(createMapImage(position));
  locationLoader.style.display = "none";
  locationBtn.style.display = "none";
  mapImg.style.display = "block";
}

function locationInaccessible(error) {
  //locationBtn.style.display = "inline-block";
  locationLoader.style.display = "none";
  mapImg.style.display = "none";
  if (!sawAlert) {
    alert("Browserul nu a putut obtine locatia, adaug-o manual");
    sawAlert = true;
  }
  fetchedLocation = { lat: 0, lng: 0 };
  console.log(error);
}

locationBtn.addEventListener("click", function(event) {
  if (!"geolocation" in navigator) {
    locationBtn.style.display = "none";
    return;
  }
  let options = {
    enableHighAccuracy: true,
    maximumAge: 30000,
    timeout: 27000
  };

  locationBtn.style.display = "none";
  locationLoader.style.display = "inline-block";

  navigator.geolocation.getCurrentPosition(
    locationReceived,
    locationInaccessible,
    options
  );
});

function initializeLocation() {
  if (!"geolocation" in navigator || !isMobileOrTablet()) {
    locationBtn.style.display = "none";
    mapImg.style.display = "none";
  } else {
    navigator.permissions.query({ name: "geolocation" }).then(function(status) {
      if (status.state === "denied") {
        locationBtn.style.display = "none";
        mapImg.style.display = "none";
      }
    });
  }
}

function initializePushNotifications() {
  let browserSupportsNotifications =
    "Notification" in window && "serviceWorker" in navigator;
  let userUndecidedAboutNotifications = Notification.permission === "default";

  if (browserSupportsNotifications && userUndecidedAboutNotifications) {
    // Cere permisiunea de a afisa notificari push
    Notification.requestPermission(configurePushSubscription);
  }
}

// Dispozitivul are din nou acces la internet
// Afisez imaginile actualizate
window.addEventListener("online", function(event) {
  document.querySelectorAll(".figure img").forEach(function(value, key) {
    let src = value.src;
    value.src = src;
  });
  document.querySelectorAll(".card img").forEach(function(value, key) {
    let src = value.src;
    value.src = src;
  });
});

// Check if APP is opened on Mobile || Tablet
function isMobileOrTablet() {
  var check = false;
  (function(a) {
    if (
      /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
        a
      ) ||
      /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
        a.substr(0, 4)
      )
    )
      check = true;
  })(navigator.userAgent || navigator.vendor || window.opera);
  return check;
}
