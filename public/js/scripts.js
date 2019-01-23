var ROOT = "/PWA/how-to-pwa/public/";
var installBtn = document.querySelector("#InstallPWA");
var deferredPrompt;

$(document).ready(function() {
  $("body").bootstrapMaterialDesign();
});

if (!window.Promise) {
  window.Promise = Promise;
}

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

window.addEventListener("beforeinstallprompt", function(event) {
  console.log("beforeinstallprompt fired");
  installBtn.style.display = "block";
  event.preventDefault();
  deferredPrompt = event;
  return false;
});

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
