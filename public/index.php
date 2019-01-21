<?php require_once("header.php") ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <h2>1. Introduction</h2>
        <p>
          <strong>Progressive Web Apps</strong> are websites that can be installed to a device’s homescreen without an app store, along with other capabilities like working offline and receiving push notifications.
        </p>
        <div class="alert alert-primary" role="alert">
            <i class="material-icons"> info </i>
            
            It loads quickly, even on flaky networks, sends relevant push
        notifications, has an icon on the home screen, and loads as a
        top-level, full screen experience.
        </div>

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

        <nav aria-label="Page navigation example">
              <ul class="pagination clearfix">
                  <li class="page-item forward">
                      <a class="page-link" href="<?php echo ROOT ?>web-app-manifest/" aria-label="Next">
                          <span class="paginationDesc">Web App Manifest</span>
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
    </div>
  </div>
<?php require_once("footer.php") ?>
