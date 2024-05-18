<?php

require_once "../php/functions.php";
require_once "../../db/conn.php";

$uid = @getUserId();
if (empty($uid)) {
    header("Location: " . getBaseURL() . "/app/user/login.php");
    die();
}
$qry = $conn->query("SELECT user_email,user_name,profile_img FROM users WHERE user_id = $uid");
$email = $username = '';
$profile = getBaseURL() . '/images/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.avif`';
if ($qry && $qry->num_rows) {
    $data = $qry->fetch_assoc();
    $email = base64_decode($data['user_email']);
    $username = base64_decode($data['user_name']);
    if ($data['profile_img']) $profile = getBaseURL() . '/profiles/' . $data['profile_img'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCloud Account</title>
    <link rel="shortcut icon" href="<?php echo getBaseURL() ?>/images/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.avif">

    <!-- CDNS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- stylesheets -->
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/styles.css">
    <link rel="stylesheet" href="<?php echo getBaseURL() ?>/app/css/form.css">
</head>

<body>

    <!-- body -->

    <!-- header -->
    <?php include "../includes/header.php" ?>
    <div class="main pt-3 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">

                    <form class="login-form" autocomplete="off">
                        <input type="file" accept="image/*" hidden id="changeProfileInp">
                        <div class="form-header">
                            <h3 class="mb-1">My Account</h3>
                            <p class="text-secondary">your privacy is our concern <br> we do not share your data to anyone !</p>
                        </div>
                        <hr class="mb-4 d-block">
                        <div class="header mb-3">
                            <img src="<?php echo $profile; ?>" alt="profile picture" class="rounded-circle bg-light d-block mx-auto" style="height: 100px;width:100px;object-fit:cover;">
                            <label for="changeProfileInp" class="d-block mx-auto">
                                <button class="btn btn-dark btn-toggle-inp rounded-5 px-3 py-1 d-block mt-3 mx-auto" type="button" onclick="$(this).parent().click()"><b><small>Change Profile &nbsp;<i class="ri-edit-fill"></i></small></b></button>
                            </label>
                        </div>
                        <div class="alert alert-danger d-none align-items-center gap-3">
                            <i class="ri-plug-2-fill h2 m-0"></i>
                            <span class="alert-text">Something Went Wrong !</span>
                        </div>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-lg border-0 rounded-2 valid" id="_email" value="<?php echo $email; ?>" readonly>
                            <div class="form-text text-danger"></div>
                            <label for="_email" class="inp-label">Email Address</label>
                        </div>
                        <div class="position-relative mt-4">
                            <input type="text" class="form-control form-control-lg border-0 rounded-2" id="_uname" value="<?php echo $username; ?>">
                            <div class="form-text text-danger"></div>
                            <label for="_uname" class="inp-label">Set User Name</label>
                        </div>
                        <div class="mt-2 form-check">
                            <input type="checkbox" class="form-check-input" id="dis_acc">
                            <label class="form-check-label text-danger" for="dis_acc">Delete My Account Permanetly</label>
                        </div>
                        <button class="btn btn-outline-primary btn-submit rounded-5 mt-3 px-4 py-2 d-block ms-auto d-none" type="button"><b>Continue</b> &nbsp;<i class="ri-arrow-right-fill"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo getBaseURL() ?>/app/js/functions.js"></script>
    <script src="<?php echo getBaseURL() ?>/app/js/account.js"></script>

</body>

</html>