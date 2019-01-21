<?php require_once("../header.php") ?>

  <main class="bmd-layout-content">
    <div class="container">
      <div class="row">
        <div class="col">
          <h2>6. Background Sync</h2>
          
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
  </main>

<?php require_once("../footer.php") ?>
