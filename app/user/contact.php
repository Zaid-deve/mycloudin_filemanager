<?php

require "../php/functions.php";
require_once "../php/mailer.php";
require "../../db/conn.php";
$uid = @getUserId();

if (!$uid) {
    header("Location:login.php?r=contact");
    die();
}

$email = $subject = $description = '';

$qry = $conn->query("SELECT user_email FROM users WHERE user_id=$uid");

if ($qry && $qry->num_rows) {
    $data = $qry->fetch_assoc();
    $email = base64_decode($data['user_email']);
}

if (isset($_POST)) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $subject = htmlspecialchars(trim($_POST['sub']), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(trim($_POST['des']), ENT_QUOTES, 'UTF-8');

        // Error message
        $error = [];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Invalid email address.\n";
        }

        // Validate subject length
        if (strlen($subject) < 1 || strlen($subject) > 100) {
            $error[] = "Subject must be between 1 and 100 characters.\n";
        }

        // Validate description length
        if (strlen($description) < 1 || strlen($description) > 1000) {
            $error[] = "Description must be between 1 and 500 characters.\n";
        }

        if (empty($error)) {
            $msg = "<html>
                    <body>
                       <h1>Contact Form Recieved From {$email}</h1><br>
                       <p>Subject: $subject</p><br>
                       <p>Description: $description</p>
                    </body>
                   </html>";

            $info = array(
                "to" => "patelzaid12121@gmail.com",
                "msg" => $msg,
                "sub" => "New Mail Recieved"
            );

            if(sendMail($info, true)){
                $mailSent = true;
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
                <div class="row-hero" style="background-image: url('<?php echo getBaseURL() ?>/images/Mobile user-amico.png') !important;height:350px"></div>
            </div>
            <div class="col-md-5">
                <?php if (!isset($mailSent)) { ?>

                    <form class="login-form" action="#" autocomplete="off" method="POST">
                        <div class="form-header">
                            <h3 class="mb-1">Contact Us</h3>
                            <p class="text-secondary">contact us and we will reach you soon.</p>
                        </div>
                        <hr class="mb-4 d-block">
                        <?php

                        if (!empty($error)) {
                            echo "<div class='alert alert-danger d-none align-items-center gap-3'>
                                 <i class='ri-plug-2-fill h2 m-0'></i>
                                 <span class='alert-text'>" . implode("<br>", $error) . "</span>
                             </div>";
                        }

                        ?>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-lg border-0 rounded-2" id="_email" name="email" value="<?php echo $email ?>" readonly>
                            <div class="form-text text-danger"></div>
                            <label for="_email" class="inp-label">Email Address</label>
                        </div>
                        <div class="position-relative mt-3">
                            <input type="text" maxlength="50" class="form-control form-control-lg border-0 rounded-2" id="_sub" name="sub" value="<?php echo $subject ?>">
                            <div class="form-text">length 0 of 50</div>
                            <label for="_sub" class="inp-label">Subject</label>
                        </div>
                        <div class="position-relative mt-3">
                            <textarea type="text" maxlength="1000" class="form-control form-control-lg border-0 rounded-2" id="_des" name="des" value="<?php echo $description ?>"></textarea>
                            <div class="form-text">length 0 of 1000</div>
                            <label for="_des" class="inp-label">Brief Description</label>
                        </div>
                        <button class="btn btn-outline-primary btn-submit rounded-5 mt-3 px-4 py-2 d-block ms-auto" type="button"><b>Continue</b> &nbsp;<i class="ri-arrow-right-fill"></i><i class="ri-loader-3-fill"></i></button>
                    </form>
                <?php } else { ?>
                    <div class="p-4 rounded-5">
                        <h1 class="text-info">Thank Your For Contacting Us !</h1>
                        <p class="text-secondary">We Will Reach You Soon.</p>
                        <a href="<?php echo getBaseURL() ?>" class="btn btn-primary py-2 px-5 d-block mx-auto"><b>Go To Home</b></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>



    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- login script -->
    <script src="<?php echo getBaseURL() ?>/app/js/contact.js"></script>

</body>

</html>