<?php


require "./functions.php";

$uid = @getUserId();
$output = "Something Went Wrong !";

if ($uid && !empty($_POST['path'])) {
    $file = htmlentities($_POST['path']);
    $path = userDir($uid) . "/" . $file;

    if ($path && file_exists($path)) {
        deleteFiles($path);
        $output = "success";
    }
}

echo $output;
