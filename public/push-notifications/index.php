<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>7. Push Notifications</h2>

        <p>The Push API gives web applications the ability to receive messages pushed to them from a server, whether or not the web app is in the foreground, or even currently loaded, on a user agent. This lets developers deliver asynchronous notifications and updates to users that opt in, resulting in better engagement with timely new content.</p>
        <p>A notification is a message that pops up on the user's device. Notifications can be triggered locally by an open application, or they can be "pushed" from the server to the user even when the app is not running. They allow your users to opt-in to timely updates and allow you to effectively re-engage users with customized content.</p>

        <p>
            <div class="alert alert-info" role="alert">
            <i class="material-icons"> info </i>
            The Push API allows a service worker to handle Push Messages from a server, even while the app is not active.
            </div>  
        </p>

        <p>Browser support for Push API can be checked here: <a href="https://caniuse.com/#search=push%20notifications" target="_blank">Push API browser support</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=push%20notifications" target="_blank">
            <img src="<?php echo ROOT ?>img/push-api-browser-support.png" class="figure-img img-fluid rounded" alt="Push API browser support">
          </a>
          <figcaption class="figure-caption">Push API browser support</figcaption>
        </figure>

        <p>Push notifications let your app extend beyond the browser, and are an incredibly powerful way to engage with the user. They can do simple things, such as alert the user to an important event, display an icon and a small piece of text that the user can then click to open up your site.</p>
        <p>The Notifications API lets us display notifications to the user. Where possible, it uses the same mechanisms a native app would use, giving a completely native look and feel.</p>

        <h4>Check for Support</h4>
        <p>The web is not yet at the point where we can build apps that depend on web notifications.</p>
        <pre><code class="language-javascript">
if ('Notification' in window && navigator.serviceWorker) {
  // Display the UI to let the user toggle notifications
}
        </code></pre>

        <h4>Request permission</h4>
        <p>Before we can create a notification we need to get permission from the user.</p>
        <pre><code class="language-javascript">
Notification.requestPermission(function(status) {
    console.log('Notification permission status:', status);
});
        </code></pre>

        <h4>Check for permission</h4>
        <p>Always check for permission to use the Notifications API. It is important to keep checking that permission has been granted because the status may change.</p>
        <pre><code class="language-javascript">
if (Notification.permission === "granted") {
  /* do our magic */
} else if (Notification.permission === "blocked") {
 /* the user has previously denied push. Can't reprompt. */
} else {
  /* show a prompt to the user */
}
        </code></pre>

        <h4>Display a notification</h4>
        <p>We can show a notification from the app's main script with the showNotification method which is called on the service worker registration object. This creates the notification on the active service worker, so that events triggered by interactions with the notification are heard by the service worker.</p>
        <pre><code class="language-javascript">
if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function(reg) {
      reg.showNotification('Hello world!');
    });
}
        </code></pre>

        <h4>Notification options</h4>
        <p>The showNotification method has an optional second argument for configuring the notification.</p>
        <pre><code class="language-javascript">
if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function(reg) {
      var options = {
        body: 'Here is a notification body!', // Adds a main description to the notification
        icon: 'images/example.png', // Attaches an image to make the notification more visually appealing
        vibrate: [100, 50, 100], // Specifies a vibration pattern 
        data: {  // Attaches custom data to the notification
          dateOfArrival: Date.now(),
          primaryKey: 1
        }
      };
      reg.showNotification('Hello world!', options);
    });
}
        </code></pre>

        <h4>Acting on events</h4>
        <p>If the user dismisses the notification through a direct action on the notification (such as a swipe in Android), it raises a <strong>notificationclose</strong> event inside the service worker.</p>
        <pre><code class="language-javascript">
self.addEventListener('notificationclose', function(e) {
  var notification = e.notification;
  var primaryKey = notification.data.primaryKey;

  console.log('Closed notification: ' + primaryKey);
});
        </code></pre>
        <p>he click triggers a notificationclick event inside the service worker</p>
        <pre><code class="language-javascript">
self.addEventListener('notificationclick', function(e) {
  var notification = e.notification;
  var primaryKey = notification.data.primaryKey;
  var action = e.action;

  if (action === 'close') {
    notification.close();
  } else {
    clients.openWindow('http://www.example.com');
    notification.close();
  }
});
        </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>background-sync/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Background Sync</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>native-device-features/" aria-label="Next">
                        <span class="paginationDesc">Native Device Features</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
