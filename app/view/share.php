<?php


require_once "../php/functions.php";
$output = "Something Went Wrong !";

$uid = @getUserId();
if ($uid) {
    if (isset($_GET['link'])) {
        $path = htmlentities($_GET['link']);
        if ($path && base64_decode($path, true)) {
            $path = base64_decode($path);
            if (file_exists($path)) {
                if (is_dir($path)) {
                    displayFiles(getFiles($path));
                } else {
                    $mime = mime_content_type($path);
                    header("Content-Type:$mime");
                    ob_clean();
                    flush();
                    readfile($path);
                }
            }
        }
    }
}

echo $output;