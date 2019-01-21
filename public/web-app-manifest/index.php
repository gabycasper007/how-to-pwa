<?php require_once("../header.php") ?>

  <main class="bmd-layout-content">
    <div class="container">
      <div class="row">
        <div class="col">
          <h2>2. Web App Manifest</h2>
          <p>
            The <strong>web app manifest</strong> provides information about an application 
            <em>(such as its name, author, icon, and description)</em> in a JSON text file. 
          </p>
          <p>
              <div class="alert alert-primary" role="alert">
                <i class="material-icons"> info </i>
                The manifest informs details for websites installed on the homescreen of a device, providing users with quicker access and a richer experience
              </div>  
          </p>
          <hr>
          <h4>Linking the manifest file</h4>
          <p>Web app manifests are deployed in your HTML pages using a <link> element in the <head> of a document:</p>
          <pre><code class="language-html">
&lt;link rel="manifest" href="/manifest.json">
              </code></pre>
          <h4>Example manifest</h4>    
          <pre><code class="language-javascript">{
  "name": "HackerWeb", // App name
  "short_name": "HackerWeb", // App short name
  "start_url": ".", // The URL that loads when a user launches the application
  "display": "standalone",
  "background_color": "#fff",
  "description": "A simply readable Hacker News app.",
  "icons": [{
    "src": "images/touch/homescreen48.png",
    "sizes": "48x48",
    "type": "image/png"
  }, {
    "src": "images/touch/homescreen72.png",
    "sizes": "72x72",
    "type": "image/png"
  }, {
    "src": "images/touch/homescreen96.png",
    "sizes": "96x96",
    "type": "image/png"
  }, {
    "src": "images/touch/homescreen144.png",
    "sizes": "144x144",
    "type": "image/png"
  }, {
    "src": "images/touch/homescreen168.png",
    "sizes": "168x168",
    "type": "image/png"
  }, {
    "src": "images/touch/homescreen192.png",
    "sizes": "192x192",
    "type": "image/png"
  }],
  "related_applications": [{
    "platform": "play",
    "url": "https://play.google.com/store/apps/details?id=cheeaun.hackerweb"
  }]
}</code></pre>
            <h4>Members</h4>
            background_color
        </div>
      </div>
    </div>
  </main>

<?php require_once("../footer.php") ?>
