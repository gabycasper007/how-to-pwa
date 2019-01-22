<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>4. Caching</h2>

        <p>It doesn't matter how much caching you do, the ServiceWorker won't use the cache unless you tell it when & how. Here are a few patterns for handling requests:</p>

        <h4>Cache only</h4>
        <p>Ideal for: Anything you'd consider static to that "version" of your site. You should have cached these in the install event, so you can depend on them being there.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  // If a match isn't found in the cache, the response
  // will look like a connection error
  event.respondWith(caches.match(event.request));
});        
        </code></pre>

        <h4>Network only</h4>
        <p>Ideal for: Things that have no offline equivalent, such as analytics pings, non-GET requests.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(fetch(event.request));
  // or simply don't call event.respondWith, which
  // will result in default browser behaviour
});      
        </code></pre>

        <h4>Cache, falling back to network</h4>
        <p>Ideal for: If you're building offline-first, this is how you'll handle the majority of requests. Other patterns will be exceptions based on the incoming request.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    const response = await caches.match(event.request);
    return response || fetch(event.request);
  }());
});
        </code></pre>

        <h4>Cache & network race</h4>
        <p>Ideal for: Small assets where you're chasing performance on devices with slow disk access.</p>

        <pre><code class="language-javascript">
// Promise.race is no good to us because it rejects if
// a promise rejects before fulfilling. Let's make a proper
// race function:
function promiseAny(promises) {
  return new Promise((resolve, reject) => {
    // make sure promises are all promises
    promises = promises.map(p => Promise.resolve(p));
    // resolve this promise as soon as one resolves
    promises.forEach(p => p.then(resolve));
    // reject if all promises reject
    promises.reduce((a, b) => a.catch(() => b))
      .catch(() => reject(Error("All failed")));
  });
};

self.addEventListener('fetch', (event) => {
  event.respondWith(
    promiseAny([
      caches.match(event.request),
      fetch(event.request)
    ])
  );
});
        </code></pre>

        <h4>Network falling back to cache</h4>
        <p>Ideal for: A quick-fix for resources that update frequently, outside of the "version" of the site. E.g. articles, avatars, social media timelines, game leader boards.</p>

        <p>
            <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            If the user has an intermitent or slow connection they'll have to wait for the network to fail before they get the perfectly acceptable content already on their device. This can take an extremely long time and is a frustrating user experience. See the next pattern, "Cache then network", for a better solution.
            </div>  
        </p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    try {
      return await fetch(event.request);
    } catch (err) {
      return caches.match(event.request);
    }
  }());
});
        </code></pre>
        
        <h4>Cache then network</h4>
        <p>Ideal for: Content that updates frequently. E.g. articles, social media timelines, game leaderboards. This requires the page to make two requests, one to the cache, one to the network. The idea is to show the cached data first, then update the page when/if the network data arrives.</p>

        <pre><code class="language-javascript">
async function update() {
  // Start the network request as soon as possible.
  const networkPromise = fetch('/data.json');

  startSpinner();

  const cachedResponse = await caches.match('/data.json');
  if (cachedResponse) await displayUpdate(cachedResponse);

  try {
    const networkResponse = await networkPromise;
    const cache = await caches.open('mysite-dynamic');
    cache.put('/data.json', networkResponse.clone());
    await displayUpdate(networkResponse);
  } catch (err) {
    // Maybe report a lack of connectivity to the user.
  }

  stopSpinner();

  const networkResponse = await networkPromise;

}

async function displayUpdate(response) {
  const data = await response.json();
  updatePage(data);
}
        </code></pre>
        
        <h4>Generic fallback</h4>
        <p>If you fail to serve something from the cache and/or network you may want to provide a generic fallback. Ideal for: Secondary imagery such as avatars, failed POST requests, "Unavailable while offline" page.</p>

        <pre><code class="language-javascript">
self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    // Try the cache
    const cachedResponse = await caches.match(event.request);
    if (cachedResponse) return cachedResponse;

    try {
      // Fall back to network
      return await fetch(event.request);
    } catch (err) {
      // If both fail, show a generic fallback:
      return caches.match('/offline.html');
      // However, in reality you'd have many different
      // fallbacks, depending on URL & headers.
      // Eg, a fallback silhouette image for avatars.
    }
  }());
});

        </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>service-workers/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Service Workers</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>indexed-db/" aria-label="Next">
                        <span class="paginationDesc">IndexedDB</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
