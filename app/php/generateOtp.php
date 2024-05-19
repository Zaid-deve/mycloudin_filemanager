<?php

$output = "Something Went Wrong !";
if (!empty($_POST)) {
    // db 
    require_once "../../db/conn.php";
    require_once "../php/functions.php";

    // data
    $email = $conn->real_escape_string(htmlentities($_POST['email']));

    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $ran_otp = mt_rand(111111, 999999);
        $enc_email = base64_encode($email);
        $enc_ran_otp = base64_encode($ran_otp);
        $uname = explode("@", $email)[0];

        // store

        try {
            $qry = $conn->query("INSERT INTO users (user_email, auth_token,auth_token_timestamp) VALUES ('{$enc_email}', '{$enc_ran_otp}',CURRENT_TIMESTAMP())");
        } catch (mysqli_sql_exception $e) {
            $qry = $conn->query("SELECT login_attempt FROM users WHERE user_email = '{$enc_email}'");
            if ($qry && $qry->num_rows) {
                $attempt = $qry->fetch_assoc()['login_attempt'];
                if ($attempt && $attempt > 3) {
                    $output = "To Many Login Attempts,Please try Again After Some Time";
                    die($output);
                } else {
                    if ($e->getCode() == 1062) {
                        $qry2 = $conn->query("UPDATE users SET auth_token = '{$enc_ran_otp}',auth_token_timestamp = CURRENT_TIMESTAMP() WHERE user_email = '{$enc_email}'");
                    }
                }
            } else die($output);
        } finally {
            require_once "mailer.php";
            $info = [
                'sub' => "My Cloud Account Verification",
                'msg' =>
                        "<html>
                            <head>
                                <title>myCloud - OTP Verification</title>
                                <style>
                                        body {
                                          font-family: Arial, sans-serif;
                                          background-color: #f4f4f4;
                                        }
                                        .container {
                                          max-width: 600px;
                                          margin: 0 auto;
                                          padding: 20px;
                                          background-color: #fff;
                                          border-radius: 8px;
                                          box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
                                        }
                                        h2 {
                                          color: #333;
                                        }
                                        p {
                                          color: #555;
                                        }
                                        .header-image {
                                          width: 100%;
                                          height: 200px;
                                          margin-bottom: 20px;
                                          object-fit: contain;
                                          background: #eee;
                                          border-radius: 12px;
                                        }
                                      </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <img
                                        src='https://gdm-catalog-fmapi-prod.imgix.net/ProductLogo/6ff3cf9e-b0df-48ac-89a0-2df5894d5d02.png?auto=format%2Ccompress&fit=max&w=256&q=75&ch=Width%2CDPR'
                                        alt='myCloud Logo' class='header-image'>
                                    <h5>Hello,$uname</h5>
                                    <p style='color: #42455a;'>Your one-time password (OTP) for myCloud
                                        account verification
                                        is: <strong>$ran_otp</strong></p>
                                    <p><i><small>If you did not request this OTP, please ignore this
                                                email.</small></i></p>
                                    <p><small><b>Best regards,<br>myCloud Support</b></small></p>
                                </div>
                            </body>
                        </html>",
                "to" => $email
                                    ];

            $output = sendMail($info, true);
        }
    }
}
echo $output;
