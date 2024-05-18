<?php

include "app/php/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCloud</title>
    <link rel="shortcut icon" href="http://localhost/file_manager/images/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.avif">

    <!-- CDNS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- stylesheets -->
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/styles.css">
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/files-grid.css">
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/menu.css">
</head>

<body>

    <!-- body -->

    <!-- header -->
    <?php include "app/includes/header.php" ?>
    <!-- navigation -->
    <?php include "app/includes/nav.php" ?>
    <!-- content -->
    <div class="main pt-3">
        <div class="container output">
            <?php
            if (!@getUserId()) {
                require_once "app/includes/no-auth.php";
            } else {
                require_once "app/user/fetchFiles.php";
                $uid = base64_encode(getUserId());

                if (empty($userFilesdata)) {
                    require "app/includes/empty-files.php";
                } else {
                    require "app/includes/menu.php";
                    displayFiles($userFilesdata);
                }
            }
            ?>
        </div>
    </div>


    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo getBaseURL() ?>/app/js/functions.js"></script>
    <script src="<?php echo getBaseURL() ?>/app/js/search.js"></script>
    <script src="<?php echo getBaseURL() ?>/app/js/menu.js"></script>

</body>

</html>