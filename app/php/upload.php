<?php

require_once "./functions.php";
$uid = @getUserId();
$output = "(Something Went Wrong !)";

if ($uid && isset($_FILES['file'])) {
    $tpath = userDir($uid);
    if (isset($_POST['path'])) {
        $tpath = $tpath ."/". htmlentities($_POST['path']);
        if (!file_exists($tpath)) {
            mkdir($tpath, 0777, true);
        }
    }

    $file = $_FILES['file'];

    if ($file['error'] == 0) {
        $name = $file['name'];
        $size = $file['size'];
        $tmpname = $file['tmp_name'];


        if ($size < 32000000) {
            $tpath = $tpath.'/'.$name;
            if (move_uploaded_file($tmpname, $tpath)) {
                $output = "success";
            } else {
                $output = $name . $output;
            }
        } else $output = $name . " Exceeded File Size !";
    }
}

echo $output;
