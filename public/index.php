<?php require_once("header.php") ?>

  <main class="bmd-layout-content">
    <div class="container">
      <div class="row">
        <div class="col">
          <h2>1. Introduction</h2>
          <p>
            <strong>Progressive Web Apps</strong> are experiences that
            combine the best of the web and the best of apps. They are
            useful to users from the very first visit in a browser tab, no
            install required.
          </p>
          <p>
            <div class="alert alert-primary" role="alert">
                <i class="material-icons"> info </i>
                
                As the user progressively builds a relationship with the app
                over time, it becomes more and more powerful.
            </div>
          </p>
          <p>
            It loads quickly, even on flaky networks, sends relevant push
            notifications, has an icon on the home screen, and loads as a
            top-level, full screen experience.
          </p>

          <figure class="figure">
            <a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">
                <img src="img/web-app-manifest.png" class="figure-img img-fluid rounded" alt="web app manifest browser support">
            <figcaption class="figure-caption"><a href="https://caniuse.com/#feat=web-app-manifest" target="_blank">Web App Manifest Browser Support</a></figcaption>
          </figure>

          <button
            type="button"
            class="btn btn-primary btn-raised"
            data-toggle="snackbar"
            data-content="Free fried chicken here! <a href='https://example.org' class='btn btn-info'>Check it out</a>"
            data-html-allowed="true"
            data-timeout="0"
          >
            Snackbar
          </button>

          <ul>
            <li>Progressive</li>
            <li>Responsive</li>
            <li>Connectivity independent</li>
            <li>App-like</li>
            <li>Fresh</li>
            <li>Safe</li>
            <li>Discoverable</li>
            <li>Re-engageable</li>
            <li>Installable</li>
            <li>Linkable</li>
          </ul>
        </div>
      </div>
    </div>
  </main>

<?php require_once("footer.php") ?>
