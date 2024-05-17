<?php

function sendMail($to, $sub = "", $msg, $mail_type = null)
{
    // headers
    $headers = array(
        "From: MyCloud <patelzaid12121@gmail.com>",
        "To:$to",
        "Reply-To: MyCloud Help<patelzaid12121@gmail.com>"
    );

    if ($mail_type) {
        if ($mail_type == "html") {
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        }
    }

    return mail($to, $sub, $msg, implode("\r\n", $headers));
}
