const functions = require("firebase-functions");
const admin = require("firebase-admin");
const cors = require("cors")({ origin: true });
const serviceAccount = require("./how-to-pwa-fb-key.json");

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
        return response.status(201).json({
          message: "Data stored",
          id: request.body.id
        });
      })
      .catch(err => err);
  });
});
