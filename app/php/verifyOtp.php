<?php

$output = "Something Went Wrong !";
if (!empty($_POST)) {
    // db 
    require_once "../../db/conn.php";
    require "functions.php";

    // data
    $email = $conn->real_escape_string(htmlentities($_POST['email']));
    $otp = $conn->real_escape_string(htmlentities($_POST['otp']));

    if (($email && filter_var($email, FILTER_VALIDATE_EMAIL)) && (filter_var($otp, FILTER_VALIDATE_INT) && strlen($otp) == "6")) {
        $enc_email = base64_encode($email);
        $enc_otp = base64_encode($otp);

        try {
            $qry = $conn->query("SELECT user_id,auth_token,login_attempt FROM users WHERE user_email = '{$enc_email}'");
            if ($qry && $qry->num_rows > 0) {
                $data = $qry->fetch_assoc();
                if ($data['login_attempt'] > 3) {
                    $output = "Too Many Login Attempts,Please Try Again After Some Time";
                } else {
                    if(!$data['auth_token']) {
                        $output = "AUTH_TOKEN_EXPIRE";
                    }
                    else if ($data['auth_token'] == $enc_otp) {
                        setUserId($data['user_id'], $_POST['rem_me'] == "ON" ? true : null);
                        $output = "success";
                    } else {
                        $qry2 = $conn->query("UPDATE users SET login_attempt = login_attempt + 1 WHERE user_email = '{$enc_email}'");
                        $output = "otp does not math, try again later !";
                    }
                }
            }
        } finally {
            if ($output == "success") {
                $qry1 = $conn->query("UPDATE users SET auth_token = NULL,auth_token_timestamp = NULL,last_login_attempt = NULL,login_attempt = 0 WHERE user_email = '{$enc_email}'");
            }
        }
    }
}
echo $output;
