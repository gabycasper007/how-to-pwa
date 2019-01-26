const ROOT = "/PWA/how-to-pwa/public/";
const installBtn = document.querySelector("#InstallPWA");
const POSTS_URL = "https://how-to-pwa.firebaseio.com/posts.json";
let deferredPrompt;

// Load Material Bootstrap
$(document).ready(function() {
  $("body").bootstrapMaterialDesign();
});

// Promise Polyfill
if (!window.Promise) {
  window.Promise = Promise;
}

// Register ServiceWorker
if ("serviceWorker" in navigator) {
  window.addEventListener("load", function() {
    navigator.serviceWorker.register(ROOT + "sw.js").then(
      function(reg) {
        console.log("SW Registed", reg.scope);
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

fetch(POSTS_URL)
  .then(function(response) {
    return response.json();
  })
  .then(showcards);

// Show all the cards
function showcards(data) {
  for (key in data) {
    createCard(data[key]);
  }
}

// Create a single card
function createCard(data) {
  var cards = document.querySelector("#cards");
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
