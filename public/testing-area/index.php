<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col" id="create-post">
        <h2>Testing Area</h2>

        <button class="btn btn-raised btn-success" id="enableNotifications">
            Enable Notifications
        </button>

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

        <div id="cards"></div>

        <br>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item backward">
                    <a class="page-link" href="<?php echo ROOT ?>native-device-features/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="paginationDesc">Native Device Features</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
<?php require_once("../footer.php") ?>
