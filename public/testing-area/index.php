<?php require_once("../header.php") ?>
<div class="container">
    <div class="row">
    <div class="col">
        <h2>Testing Area</h2>
        
        <form id="syncForm">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" placeholder="Enter location">
            </div>
            <button type="submit" class="btn btn-primary btn-raised">Submit</button>
        </form>

        <br>

        <button class="btn btn-raised btn-primary" id="enableNotifications">
            Enable Notifications
        </button>


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
