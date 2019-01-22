<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>6. Background Sync</h2>

        <p>Background sync is a new web API that lets you defer actions until the user has stable connectivity. This is useful for ensuring that whatever the user wants to send, is actually sent. The user can go offline and even close the browser, safe in the knowledge that their request will be sent when they regain connectivity.</p>
        <p>Service Workers provides offline functionality and dramatically speeds up load times using caching. While this is useful, there has been no way for the page to actually send something to the server without connectivity. Background Sync is the feature that has been built to handle just such a scenario.</p>

        <h4>What could I use background sync for?</h4>

        <p>Ideally, you’d use it to schedule any data sending that you care about beyond the life of the page. Chat messages, emails, document updates, settings changes, photo uploads… anything that you want to reach the server even if user navigates away or closes the tab. The page could store these in an "outbox" store in indexedDB, and the service worker would retrieve them, and send them.</p>
        <p>If you write an email, instant message, or simply favorite a tweet, the application needs to communicate that data to the server. If that fails, either due to user connectivity, service availability or anything in-between, the app can store that action in some kind of 'outbox' for retry later.</p>

        <p>
            <div class="alert alert-danger" role="alert">
            <i class="material-icons"> warning </i>
            Sync may not be available to all web applications, not even all apps served over SSL. Browsers may choose to limit the set of applications which can register for synchronization based on quality signals that aren't a part of the visible API. This is especially true of periodic sync.
            </div>  
        </p>
    
        <h4>Requesting a sync</h4>
        <pre><code class="language-javascript">
navigator.serviceWorker.ready.then(function(registration) {
  registration.sync.register('outbox').then(function() {
    // registration succeeded
  }, function() {
    // registration failed
  });
});
        </code></pre>

        <h4>Responding to a sync</h4>
        <pre><code class="language-javascript">
self.addEventListener('sync', function(event) {
  if (event.tag == 'outbox') {
    event.waitUntil(sendEverythingInTheOutbox());
  }
});
        </code></pre>

        <p>sync will fire when the user agent believes the user has connectivity.</p>

        <h4>Periodic synchronization (in design)</h4>

        <p>Opening a news or social media app to find content you hadn't seen before - without going to the network, is a user experience currently limited to native apps.</p>
        <p>An example of using periodic syncing is if the user agent knows the user has a morning alarm set, it may run synchronizations shortly beforehand, giving the user quick and up-to-date information from their favorite sites.</p>

        <h4>To request a periodic sync</h4>
        <pre><code class="language-javascript">
navigator.serviceWorker.ready.then(function(registration) {
  registration.periodicSync.register({
    tag: 'get-latest-news',         // default: ''
    minPeriod: 12 * 60 * 60 * 1000, // default: 0
    powerState: 'avoid-draining',   // default: 'auto'
    networkState: 'avoid-cellular'  // default: 'online'
  }).then(function(periodicSyncReg) {
    // success
  }, function() {
    // failure
  })
});
        </code></pre>

        <h4>To respond to a periodic sync</h4>
        <pre><code class="language-javascript">
self.addEventListener('periodicsync', function(event) {
  if (event.registration.tag == 'get-latest-news') {
    event.waitUntil(fetchAndCacheLatestNews());
  }
  else {
    // unknown sync, may be old, best to unregister
    event.registration.unregister();
  }
});
        </code></pre>

        <p>The promise passed to waitUntil is a signal to the user agent that the sync event is ongoing and that it should keep the service worker alive if possible. Rejection of the event signals to the user agent that the sync failed.</p>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>indexed-db/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">IndexedDB</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>push-notifications/" aria-label="Next">
                        <span class="paginationDesc">Push Notifications</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
