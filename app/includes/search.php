<?php

require_once "../php/functions.php";

if (isset($_POST['qry'])) {
    $qry = htmlentities($_POST['qry']);
    $uid = @getUserId();
    $path = userDir($uid);

    if (isset($_POST['dir'])) {
        $path .= "/" . htmlentities($_POST['dir']);
    }

    if (file_exists($path)) {
        require_once "../user/fetchFiles.php";

        if (!empty($userFilesdata)) {
            displayFiles($userFilesdata, $qry);
            die();
        }
    }
}

echo "No Result Found !";
