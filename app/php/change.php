<?php

require_once "./functions.php";
require_once "../../db/conn.php";

$output = "Something Went Wrong !";
$uid = @getUserId();

if (!empty($uid)) {
    if (!empty($_POST) || !empty($_FILES)) {
        if (isset($_POST['deleteAccount'])) {
            if (deleteAccount($conn)) {
                $output = "success";
            }
        } else {
            $update_str = [];
            if (isset($_FILES['profileImg']) && $_FILES["profileImg"]['error'] == 0) {
                $update_str[] = "profile_img = '{$_FILES['profileImg']['name']}'";
                move_uploaded_file($_FILES['profileImg']['tmp_name'], "C:/xampp/htdocs/file_manager/profiles/".$_FILES['profileImg']['name']);
            }

            if (!empty($_POST['uname'])) {
                $update_str[] = "user_name = '" . base64_encode($conn->real_escape_string(htmlentities($_POST['uname']))) . "'";
            }

            $qry = $conn->query("UPDATE users SET " . implode(",", $update_str) . " WHERE user_id = $uid");
            if($qry && $conn->affected_rows) $output = "success";
        }
    }
}


echo  $output;
