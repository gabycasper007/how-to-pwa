const functions = require("firebase-functions");
const admin = require("firebase-admin");
const cors = require("cors")({ origin: true });
const serviceAccount = require("./how-to-pwa-fb-key.json");
const webpush = require("web-push");

// Create and Deploy Your First Cloud Functions
// https://firebase.google.com/docs/functions/write-firebase-functions

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://how-to-pwa.firebaseio.com/"
});

exports.storePostData = functions.https.onRequest((request, response) => {
  cors(request, response, _ => {
    admin
      .database()
      .ref("posts")
      .push({
        id: request.body.id,
        title: request.body.title,
        location: request.body.location,
        image: request.body.image
      })
      .then(_ => {
        webpush.setVapidDetails(
          "mailto:gabriell.vasile@gmail.com",
          "BBe9Nffr35gtlfpKIQ0VhzaVVM7L-t1lfD3inWM4ItY0aWy8IPFrPLO8MCPYTF4YAoXBGNMmegzYuvFY58Ty9ts",
          "Zf5gPx1T4wRL57cxP1rDh17WPEaJiAv_47LN0HHv3rQ"
        );
        return admin
          .database()
          .ref("subscriptions")
          .once("value");
      })
      .then(subscriptions => {
        subscriptions.forEach(sub => {
          let pushConfig = {
            endpoint: sub.val().endpoint,
            keys: {
              auth: sub.val().keys.auth,
              p256dh: sub.val().keys.p256dh
            }
          };
          webpush.sendNotification(
            pushConfig,
            JSON.stringify({
              title: "New Post",
              content: "New Post Added"
            })
          );
        });
        return response.status(201).json({
          message: "Data stored",
          id: request.body.id
        });
      })
      .catch(err => {
        console.log("Subscription error", err);
      });
  });
});
