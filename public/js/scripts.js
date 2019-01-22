var ROOT = "/PWA/how-to-pwa/public/";

$(document).ready(function() {
  $("body").bootstrapMaterialDesign();
});

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
