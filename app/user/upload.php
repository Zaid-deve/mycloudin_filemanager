<?php

require_once "../php/functions.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="shortcut icon" href="http://localhost/file_manager/images/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.avif">


    <!-- CDNS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- stylesheets -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/upload.css">
</head>

<body class="vh-100 vw-100 position-relative d-flex">

    <!-- body -->
    <div class="container d-none position-absolute top-0 start-0 bg-white z-4 py-3 progress-outer h-100 w-100">
        <div class="header positon-relative">
            <button class="btn btn-light d-flex ms-auto rounded-circle btn-cancel-upload p-0">
                <i class="ri-close-line m-auto"></i>
            </button>
            <h3 class="h3">Upload Progress</h3>
            <p class="text-secondary">Do Not Cancel The Upload <br> Uploads Heare Are Ir-resumeable</p>
            <hr>
        </div>
        <div class="alert alert-danger d-none"></div>
        <div class="progress-center"></div>
    </div>

    <div class="container m-md-auto p-md-0 pt-5">
        <div class="row">
            <div class="col-md-7 d-none d-md-block vector-img"></div>
            <div class="col-md-5">
                <div class="header">
                    <h3 class="h3 m-0">Upload Files</h3>
                    <p class="text-secondary">Upload Files Of 50MB max, add multiple files.</p>
                </div>
                <div class="upload-outer bg-light border-0  mt-4 rounded-4 text-center py-4">
                    <label for="uploadSelInp">
                        <i class="ri-upload-2-fill text-dark upload-icon"></i>
                        <br>
                        <div class="d-inline-block mx-auto py-2 px-5 bg-dark rounded-5 text-light"><b>Browse</b></div>
                    </label>
                    <input type="file" id="uploadSelInp" multiple hidden>
                </div>
            </div>
        </div>
    </div>



    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/upload.js"></script>

</body>

</html>