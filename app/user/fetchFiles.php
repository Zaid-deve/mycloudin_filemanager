<?php

$userFilesdata = [];
$fileTypes = array(
    "pdf" => "ri-file-pdf-fill",
    "doc" => "ri-file-word-fill",
    "docx" => "ri-file-word-fill",
    "xls" => "ri-file-excel-fill",
    "xlsx" => "ri-file-excel-fill",
    "ppt" => "ri-file-ppt-fill",
    "pptx" => "ri-file-ppt-fill",
    "image" => "ri-file-image-fill",
    "video" => "ri-file-video-fill",
    "txt" => "ri-file-fill",
    "dir" => "ri-folder-fill",
    "exe" => "ri-google-play-fill",
    "audio" => "ri-headphone-fill"
);

$uid = @getUserId();

if ($uid) {
    $euid = base64_encode($uid);
    if (!isset($path)) {
        $path = userDir($uid);
        if (isset($_GET['path'])) {
            $path .= "/" . htmlentities($_GET['path']);
        }
    }
    $files = getFiles($path);

    if (!empty($files)) {
        foreach ($files as $f) {
            $fpath = "$path/$f";
            $info = pathinfo($fpath);
            $ftype = $info['extension'] ?? '';
            $fsize = filesize($fpath);
            $isMedia = false;
            $thumbnail = "";



            if (is_dir($fpath)) {
                $ftype = "dir";
                $dir = getFiles($fpath);
                foreach ($dir as $di) {
                    $fsize += filesize("$fpath/$di");
                }
            } else if (is_executable($fpath)) {
                $ftype = "exe";
            } else if (isAudioFile($fpath)) {
                $ftype = "audio";
            } else if (isImage($fpath)) {
                $ftype = "image";
                $isMedia = true;
            } else if (isVideo($fpath)) {
                $ftype = "video";
                $isMedia = true;
                $thumbnail = createThumbnail($fpath);
            }
            $loc = explode($euid . "/", $fpath)[1];

            $userFilesdata[] = [
                "fname" => $f,
                "fsize" => formatFileSize($fsize),
                "fdate" => date("d M,Y", filectime($fpath)),
                "ftype" => $ftype,
                "ficon" => $fileTypes[$ftype] ?? 'ri-file-fill',
                "fpath" => $loc,
                "isMedia" => $isMedia,
                "thumbnailPath" => $thumbnail
            ];
        }
    }
}
