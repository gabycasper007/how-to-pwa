

          <div class="floating-button">
            <button class="btn btn-success bmd-btn-fab"
                    id="share-image-button">
              <i class="material-icons">add</i>
            </button>
          </div>

          <div id="create-post">
            <div class="container">
              <button class="btn btn-primary btn-raised" id="InstallPWA" type="button">Instaleaza PWA</button>
              <video id="player" autoplay></video>
              <canvas id="canvas" width="320px" height="240px"></canvas>
              <button class="btn btn-raised btn-secondary" id="capture-btn">Capture</button>
              <div id="pick-image">
                  <h6>Pick an Image instead</h6>
                  <input type="file" accept="image/*" id="image-picker">
              </div>
              
              <form id="syncForm">
                  <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title" placeholder="Enter title">
                  </div>
                  <div class="form-group" id="manual-location">
                      <label for="location">Location</label>
                      <input type="text" class="form-control" id="location" placeholder="Enter location">
                  </div>
                  <div class="input-section">
                      <button class="btn btn-primary btn-raised" type="button" id="location-btn">Get Location</button>
                      <div class="spinner-border spinner-border-sm" role="status" id="location-loader">
                          <span class="sr-only">Loading...</span>
                      </div>
                  </div>
                  <div id="customMap"></div>
                  <button type="submit" class="btn btn-warning btn-raised">Submit</button>
              </form>
              <button class="btn btn-secondary bmd-btn-fab" id="close-modal-btn" type="button">
                <i class="material-icons">close</i>
              </button>
            </div>
          </div>

          <footer>
            © Copyright <?php echo date('Y') ?> - Gabriel VASILE
          </footer>
        </main>
    </div>

    <script>
      const ROOT = "<?php echo ROOT; ?>";
    </script>

    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
      integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
      crossorigin="anonymous"
    ></script>

    <script src="https://cdn.rawgit.com/FezVrasta/snackbarjs/1.1.0/dist/snackbar.min.js"></script>

    <script
      src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"
      integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9"
      crossorigin="anonymous"
    ></script>

    <script src="<?php echo ROOT; ?>js/promise.js"></script>
    <script src="<?php echo ROOT; ?>js/fetch.js"></script>
    <script src="<?php echo ROOT; ?>js/prism.js"></script>
    <script src="<?php echo ROOT; ?>js/localforage.min.js"></script>
    <script src="<?php echo ROOT; ?>js/utility.js"></script>
    <script src="<?php echo ROOT; ?>js/app.js"></script>
    </body>
</html>
