<?php

require "../php/functions.php";
if (@getUserId()) {
    header("Location:" . getBaseURL() . "/app/user/profile.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="shortcut icon" href="http://localhost/file_manager/images/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.avif">

    <!-- CDNS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- stylesheets -->
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/styles.css">
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/form.css">
</head>

<body class="vh-100 vw-100 d-flex">

    <!-- body -->
    <div class="container m-md-auto pt-5 pt-md-0">
        <div class="row align-items-center">
            <div class="col-md-7 d-md-block d-none">
                <div class="row-hero"></div>
            </div>
            <div class="col-md-5">
                <form class="login-form" autocomplete="off">
                    <div class="form-header">
                        <h3 class="mb-1">Sign In</h3>
                        <p class="text-secondary">your privacy is our concern <br> we do not share your data to anyone !</p>
                    </div>
                    <hr class="mb-4 d-block">
                    <div class="alert alert-danger d-none align-items-center gap-3">
                        <i class="ri-plug-2-fill h2 m-0"></i>
                        <span class="alert-text">Something Went Wrong !</span>
                    </div>
                    <div class="row g-2">
                        <div class="col position-relative">
                            <input type="text" class="form-control form-control-lg border-0 rounded-2" id="_email">
                            <div class="form-text text-danger"></div>
                            <label for="_email" class="inp-label">Email Address</label>
                        </div>
                        <div class="col-4 position-relative pass-field d-none">
                            <input type="text" maxlength="6" class="form-control form-control-lg border-0 rounded-2" id="_otp">
                            <div class="form-text text-danger"></div>
                            <label for="_otp" class="inp-label">OTP</label>
                        </div>
                    </div>
                    <div class="mt-2 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me">
                        <label class="form-check-label" for="remember_me">Dont Ask For Codes On This Device !</label>
                    </div>
                    <button class="btn btn-outline-primary btn-submit rounded-5 mt-3 px-4 py-2 d-block ms-auto d-none" type="button"><b>Continue</b> &nbsp;<i class="ri-arrow-right-fill"></i><i class="ri-loader-3-fill"></i></button>
                </form>
            </div>
        </div>
    </div>



    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- login script -->
    <script src="<?php echo getBaseURL() ?>/app/js/functions.js"></script>
    <script src="<?php echo getBaseURL() ?>/app/js/form.js"></script>

</body>

</html>