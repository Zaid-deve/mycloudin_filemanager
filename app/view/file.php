<?php

require_once "../php/functions.php";
if (!@getUserId()) {
    header("Location:" . getBaseURL() . "/app/user/login.php");
}
$uid = getUserId();

if (isset($_GET['path'])) {
    $path = userDir($uid);
    $file = htmlentities($_GET['path']);

    $fpath = "$path/$file";
    if (!file_exists($fpath)) {
        header("Location:" . getBaseURL() . "/error.php");
        die("requested files is been deleted");
    }
    $mime = mime_content_type($fpath);

    $forceDownloadTypes = array(
        'application/octet-stream',
        'application/zip'
    );

    header("Content-Type: $mime");
    if (in_array($mime, $forceDownloadTypes)) {
        header("Content-Disposition: attachment; filename=\"$file\"");
    } else {
        header("Content-Disposition: inline; filename=\"$file\"");
    }

    ob_clean();
    flush();

    readfile($fpath);
} else {
    http_response_code(400);
    die("Bad Request");
}
