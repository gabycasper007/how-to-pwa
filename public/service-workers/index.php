<?php require_once("../header.php") ?>
<div class="container">
  <div class="row">
    <div class="col">
      <h2>3. Service Workers</h2>
      <p>Rich offline experiences, periodic background syncs, push notifications—functionality that would normally require a native application—are coming to the web. Service workers provide the technical foundation that all these features rely on.</p>
      <ul>
          <li><a href="#what-is-a-service-worker">What is a service worker</a></li>
          <li><a href="#register-a-service-worker">Register a Service Worker</a></li>
          <li><a href="#install-a-service-worker">Install a Service Worker</a></li>
          <li><a href="#cache-and-return-requests">Cache and return requests</a></li>
          <li><a href="#dynamic-caching">Dynamic Caching</a></li>
          <li><a href="#delete-old-caches">Delete Old Caches</a></li>
      </ul>
      <h4 id="what-is-a-service-worker">What is a service worker</h4>
      <p>A service worker is a script that your browser runs in the background, separate from a web page, opening the door to features that don't need a web page or user interaction. Today, they already include features like push notifications and background sync. </p>
      <p>Service workers run on a separate thread from the main JavaScript code of our page, and don't have any access to the DOM structure. The API is non-blocking, and can send and receive communication between different contexts.</p>
      <div class="alert alert-info" role="alert">
            <i class="material-icons"> done </i>
            
            In the future, service workers might support other things like periodic sync or geofencing. The core feature discussed here is the ability to intercept and handle network requests, including programmatically managing a cache of responses.
      </div>
      <p>The reason this is such an exciting API is that it allows you to support offline experiences, giving developers complete control over the experience.</p>
      <p>Service workers can do a lot more than "just" offering offline capabilities, including handling notifications, performing heavy calculations on a separate thread, etc. Service workers are quite powerful as they can take control over network requests, modify them, serve custom responses retrieved from the cache, or synthesize responses completely.</p>

      <h4 id="register-a-service-worker">Register a Service Worker</h4>

      <p>The next code checks to see if the service worker API is available, and if it is, the service worker at /sw.js is registered once the page is loaded.</p>
      <pre><code class="language-javascript">
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(
        function(reg) {
            console.log('SW Registed', reg.scope);
        }, 
        function(err) {
            console.log('SW failed: ', err);
        }
    );
  });
}

</code></pre>

        <h4 id="install-a-service-worker">Install a Service Worker</h4>

        <p>In order to install the service worker, you need to define a callback for the install event and decide which files you want to cache.</p>
        <div>Inside of our install callback, we need to take the following steps:</div>
        <ul>
            <li>Open a cache.</li>
            <li>Cache our files.</li>
            <li>Confirm whether all the required assets are cached or not.</li>
        </ul>

        <pre><code class="language-javascript">
var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
  '/',
  '/styles/main.css',
  '/script/main.js'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

</code></pre>
      <p>This is a chain of promises (caches.open() and cache.addAll()). The event.waitUntil() method takes a promise and uses it to know how long installation takes, and whether it succeeded or not.</p>
      <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            If all the files are successfully cached, then the service worker will be installed. If any of the files fail to download, then the install step will fail.
      </div>
      <h4 id="cache-and-return-requests">Cache and return requests</h4>
      <p>After a service worker is installed and the user navigates to a different page or refreshes, the service worker will begin to receive fetch events.</p>
      <pre><code class="language-javascript">
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});
</code></pre>

    <p>Here we've defined our fetch event and within event.respondWith(), we pass in a promise from caches.match(). This method looks at the request and finds any cached results from any of the caches your service worker created.</p>
    <p>If we have a matching response, we return the cached value, otherwise we return the result of a call to fetch, which will make a network request and return the data from the network.</p>

    <div class="alert alert-info" role="alert">
        <i class="material-icons"> done </i>
        This uses any cached assets we cached during the install step.
    </div>

    <h4 id="dynamic-caching">Dynamic Caching</h4>
    <p>If we want to cache new requests cumulatively, we can do so by handling the response of the fetch request and then adding it to the cache, like below.</p>
    <pre><code class="language-javascript">
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }

        return fetch(event.request).then(
          function(response) {
            // Check if we received a valid response
            if(!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // IMPORTANT: Clone the response. A response is a stream
            // and because we want the browser to consume the response
            // as well as the cache consuming the response, we need
            // to clone it so we have two streams.
            var responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(function(cache) {
                cache.put(event.request, responseToCache);
              });

            return response;
          }
        );
      })
    );
});
</code></pre>

    <p>Once we get a response, we perform the following checks:
    <ul>
        <li>Ensure the response is valid.</li>
        <li>Check the status is 200 on the response.</li>
        <li>Make sure the response type is basic, which indicates that it's a request from our origin. This means that requests to third party assets aren't cached as well.</p></li>
    </ul>
    <p>If we pass the checks, we clone the response so we can send one to the browser and one to the cache. The reason for this is that because the response is a Stream, the body can only be consumed once.</p>

    <h4 id="delete-old-caches">Delete Old Caches</h4>

    <p>The following code will loop through all of the caches in the service worker and deleting any caches that aren't defined in the cache whitelist.</p>
    <pre><code class="language-javascript">
self.addEventListener('activate', function(event) {

  var cacheWhitelist = ['pages-cache-v1', 'blog-posts-cache-v1'];

  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});        
    </code></pre>
    
      <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item backward">
                <a class="page-link" href="<?php echo ROOT ?>web-app-manifest/" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="paginationDesc">Web App Manifest</span>
                </a>
            </li>
            <li class="page-item forward">
                <a class="page-link" href="<?php echo ROOT ?>caching/" aria-label="Next">
                    <span class="paginationDesc">Caching</span>
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
<?php require_once("../footer.php") ?>
