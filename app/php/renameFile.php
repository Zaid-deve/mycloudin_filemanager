<?php


require "./functions.php";

$uid = @getUserId();
$output = "Something Went Wrong !";

if ($uid && !empty($_POST['oldPath']) && !empty($_POST['newName'])) {
    $oldPath = htmlentities($_POST['oldPath']);
    $newName = htmlentities($_POST['newName']);

    $path = userDir($uid) . "/" . $oldPath;
    $newPath = userDir($uid) . "/" . $newName;

    if ($path && file_exists($path)) {
        if (rename($path, $newPath)) {
            $output = "success";
        }
    }
}

echo $output;
