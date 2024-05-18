<nav class="navbar navbar-expand-lg" style="min-height: 90px;border-bottom:2px solid #f8f8f8;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 me-auto" href="#">
            <img src="http://localhost/file_manager/images/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.avif" alt="#" height="30px">
            <h3 class="h3 m-0" style="font-weight:900;color:#1490de;">MyCloud</h3>
        </a>

        <?php if (@getUserId()) { ?>

            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="flex-grow: 0;">
                <ul class="navbar-nav d-flex gap-md-2 ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-primary" aria-current="page" href="<?php echo getBaseURL() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo getBaseURL() ?>/app/user/account.php">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo getBaseURL() ?>/app/user/settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo getBaseURL() ?>/app/user/contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo getBaseURL() ?>/app/user/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="width: 40px;">
                <div class="d-grid  gap-2">
                    <span class="col rounded-5 pt-1 bg-dark ms-2"></span>
                    <span class="col rounded-5 pt-1 bg-dark ms-1"></span>
                    <span class="col rounded-5 pt-1 bg-dark"></span>
                </div>
            </button>
            <a href="<?php echo getBaseURL() ?>/app/user/upload.php<?php echo !empty($_GET['path']) ? "?path={$_GET['path']}" : '' ?>" class="btn btn-dark px-4 rounded-5 ms-3"><i class="ri-upload-fill"></i><b class="d-none d-sm-inline">&nbsp; Upload</b></a>

        <?php } else { ?>
            <a href="<?php echo getBaseURL() ?>/app/user/login.php" class="btn btn-primary px-4 rounded-5 ms-3"><b>Login</b></a>
        <?php } ?>
    </div>
</nav>