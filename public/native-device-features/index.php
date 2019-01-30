<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>8. Native Device Features</h2>

        <h3>a) The Stream API</h3>

        <p>The Stream API getUserMedia() method prompts the user for permission to use a media input which produces a MediaStream with tracks containing the requested types of media.</p>
        <p>That stream can include a video track (produced by a camera, video recording device, screen sharing service), an audio track (similarly, produced a microphone), and possibly other track types.</p>

        <p>Browser support for Stream API can be checked here: <a href="https://caniuse.com/#search=stream%20api" target="_blank">Stream API browser support</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=stream%20api" target="_blank">
            <img src="<?php echo ROOT ?>img/stream-api.png" class="figure-img img-fluid rounded" alt="Stream API browser support">
          </a>
          <figcaption class="figure-caption">Stream API browser support</figcaption>
        </figure>

        <h4>Getting Media Access</h4>
        <pre><code class="language-javascript">
navigator.mediaDevices.getUserMedia(constraints)
.then(function(stream) {
  /* use the stream */
})
.catch(function(err) {
  /* handle the error */
});
        </code></pre>

        <h4>Applying constraints</h4>
        <p>While information about a user's cameras and microphones are inaccessible for privacy reasons, an application can request the camera and microphone capabilities it needs and wants, using additional constraints.</p>
        <pre><code class="language-javascript">
{
  audio: true,
  video: { width: 1280, height: 720 }
}
        </code></pre>

        <p>As an API that may involve significant privacy concerns, getUserMedia() must always get user permission before opening any media gathering input such as a webcam or microphone. </p>

        <h4>Using the new API in older browsers</h4>
        <pre><code class="language-javascript">
// Older browsers might not implement mediaDevices at all, so we set an empty object first
if (navigator.mediaDevices === undefined) {
  navigator.mediaDevices = {};
}

// Some browsers partially implement mediaDevices. We can't just assign an object
// with getUserMedia as it would overwrite existing properties.
// Here, we will just add the getUserMedia property if it's missing.
if (navigator.mediaDevices.getUserMedia === undefined) {
  navigator.mediaDevices.getUserMedia = function(constraints) {

    // First get ahold of the legacy getUserMedia, if present
    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // Some browsers just don't implement it - return a rejected promise with an error
    // to keep a consistent interface
    if (!getUserMedia) {
      return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
    }

    // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
    return new Promise(function(resolve, reject) {
      getUserMedia.call(navigator, constraints, resolve, reject);
    });
  }
}

navigator.mediaDevices.getUserMedia({ audio: true, video: true })
.then(function(stream) {
  var video = document.querySelector('video');
  // Older browsers may not have srcObject
  if ("srcObject" in video) {
    video.srcObject = stream;
  } else {
    // Avoid using this in new browsers, as it is going away.
    video.src = window.URL.createObjectURL(stream);
  }
  video.onloadedmetadata = function(e) {
    video.play();
  };
})
.catch(function(err) {
  console.log(err.name + ": " + err.message);
});
        </code></pre>

        <br>

        <h3>b) The Geolocation API</h3>

        <p>The Geolocation API allows the user to provide their location to web applications if they so desire. For privacy reasons, the user is asked for permission to report location information.</p>

        <p>Browser support for Geolocation API can be checked here: <a href="https://caniuse.com/#search=Geolocation" target="_blank">Geolocation API browser support</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=Geolocation" target="_blank">
            <img src="<?php echo ROOT ?>img/geolocation-api.png" class="figure-img img-fluid rounded" alt="Geolocation API browser support">
          </a>
          <figcaption class="figure-caption">Geolocation API browser support</figcaption>
        </figure>

        <h4>The geolocation object</h4>
        <p>If the object exists, geolocation services are available. You can test for the presence of geolocation like this:</p>
        <pre><code class="language-javascript">
if ("geolocation" in navigator) {
  /* geolocation is available */
} else {
  /* geolocation IS NOT available */
}
        </code></pre>

        <h4>Getting the current position</h4>
        <p>The getCurrentPosition() method. This initiates an asynchronous request to detect the user's position, and queries the positioning hardware to get up-to-date information.</p>
        <pre><code class="language-javascript">
navigator.geolocation.getCurrentPosition(function(position) {
  do_something(position.coords.latitude, position.coords.longitude);
});
        </code></pre>

        <h4>Watching the current position</h4>
        <p>If the position data changes (either by device movement or if more accurate geo information arrives), you can set up a callback function that is called with that updated position information. </p>
        <pre><code class="language-javascript">
var watchID = navigator.geolocation.watchPosition(function(position) {
  do_something(position.coords.latitude, position.coords.longitude);
});
        </code></pre>

        <h4>Stop Watching the current position</h4>
        <pre><code class="language-javascript">
navigator.geolocation.clearWatch(watchID);
        </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>push-notifications/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Push Notifications</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>testing-area/" aria-label="Next">
                        <span class="paginationDesc">Testing Area</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
