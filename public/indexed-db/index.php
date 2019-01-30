<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>5. IndexedDB</h2>

        <p>IndexedDB is a low-level API for client-side storage of significant amounts of structured data, including files/blobs. This API uses indexes to enable high-performance searches of this data. While Web Storage is useful for storing smaller amounts of data, it is less useful for storing larger amounts of structured data.</p>
        <p>IndexedDB is a way for you to persistently store data inside a user's browser. Because it lets you create web applications with rich query abilities regardless of network availability, these applications can work both online and offline.</p>

        <p>The IndexedDB storage can be seen in Google Chrome using Developer Tools and going to Application -> Storage -> IndexedDB</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/indexedDB-storage.png" class="figure-img img-fluid rounded" alt="IndexedDB">
          <figcaption class="figure-caption">IndexedDB Storage</figcaption>
        </figure>

        <p>Browser support for IndexedDB can be checked here: <a href="https://caniuse.com/#search=indexedDB" target="_blank">IndexedDB browser support</a></p>

        <figure class="figure">
          <a href="https://caniuse.com/#search=indexedDB" target="_blank">
            <img src="<?php echo ROOT ?>img/indexedDB-browser-support.png" class="figure-img img-fluid rounded" alt="IndexedDB browser support">
          </a>
          <figcaption class="figure-caption">IndexedDB browser support</figcaption>
        </figure>

        <p>Deleting IndexedDB storage manually can be done in Google Chrome using Developer Tools and going to Application -> Clear Storage -> Clear side data</p>

        <figure class="figure">
          <img src="<?php echo ROOT ?>img/deleting-cached-files.png" class="figure-img img-fluid rounded" alt="clear site data">
          <figcaption class="figure-caption">Clear site data</figcaption>
        </figure>

        <p>IndexedDB is a transactional JavaScript-based object-oriented database system. IndexedDB lets you store and retrieve objects that are indexed with a key. </p>
        <p>You need to specify the database schema, open a connection to your database, and then retrieve and update data within a series of transactions.</p>

        <p>IndexedDB API is powerful, but it's too complicated for simple cases, so we're going to use <a href="https://localforage.github.io/localForage/" target="_blank">localForage JavaScript library</a> for a simpler approach.</p>
        <p>LocalForage includes a localStorage-backed fallback store for browsers with no IndexedDB or WebSQL support.</p>

        <h4>Installing localForage</h4>
        <p>The simplest approach to use localForage is to simply include the JS file</p>
        <pre><code class="language-html">
&lt;script src="localforage.js"></script>
            </code></pre>

        <h4>Configuring localForage</h4>
        <p>Set and persist localForage options. This must be called before any other calls to localForage are made, but can be called after localForage is loaded:</p>
        <pre><code class="language-javascript">
// This will rename the database from "localforage"
// to "Ghid PWA".
localforage.config({
    name: 'Ghid PWA'
});
            </code></pre>

        <h4>Adding an item to the storage</h4>
        <p>Saves data to an offline store:</p>
        <pre><code class="language-javascript">
localforage.setItem('somekey', 'some value').then(function (value) {
    // Do other things once the value has been saved.
    console.log(value);
}).catch(function(err) {
    // This code runs if there were any errors
    console.log(err);
});
            </code></pre>

        <h4>Getting an item from the storage</h4>
        <p>Gets an item from the storage library and supplies the result to a callback. If the key does not exist, getItem() will return null.</p>
        <pre><code class="language-javascript">
localforage.getItem('somekey').then(function(value) {
    // This code runs once the value has been loaded
    // from the offline store.
    console.log(value);
}).catch(function(err) {
    // This code runs if there were any errors
    console.log(err);
});
            </code></pre>

        <h4>Getting ALL the items from the storage</h4>
        <p>Iterate over all value/key pairs in datastore.</p>
        <pre><code class="language-javascript">
// The same code, but using ES6 Promises.
localforage.iterate(function(value, key, iterationNumber) {
    // Resulting key/value pair -- this callback
    // will be executed for every item in the
    // database.
    console.log([key, value]);
}).then(function() {
    console.log('Iteration has completed');
}).catch(function(err) {
    // This code runs if there were any errors
    console.log(err);
});
            </code></pre>

        <h4>Removing an item from the storage</h4>
        <p>Removes the value of a key from the offline store.</p>
        <pre><code class="language-javascript">
localforage.removeItem('somekey').then(function() {
    // Run this code once the key has been removed.
    console.log('Key is cleared!');
}).catch(function(err) {
    // This code runs if there were any errors
    console.log(err);
});
            </code></pre>

        <h4>Removing ALL the items from the storage</h4>
        <p>Removes every key from the database, returning it to a blank slate.</p>
        <pre><code class="language-javascript">
localforage.clear().then(function() {
    // Run this code once the database has been entirely deleted.
    console.log('Database is now empty.');
}).catch(function(err) {
    // This code runs if there were any errors
    console.log(err);
});
            </code></pre>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>caching/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Caching</span>
                    </a>
                </li>
                <li class="page-item forward">
                    <a class="page-link" href="<?php echo ROOT ?>background-sync/" aria-label="Next">
                        <span class="paginationDesc">Background Sync</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
