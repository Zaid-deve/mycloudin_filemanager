<?php

if (!session_id()) session_start();

function getUserId()
{
    return $_SESSION['user_id'] ?? $_COOKIE['user_id'];
}

function setUserId($id, $cookie = false, $expiry = null)
{
    if (!$id) return;

    if ($cookie) {
        setcookie("user_id", $id, $expiry ?? (time() + (7 * 24 * 3600)), "/");
        return;
    }

    $_SESSION['user_id'] = $id;
}

function getBaseURL()
{
    if ($_SERVER['SERVER_NAME'] === "localhost") {
        return "http://localhost/file_manager";
    }
    return "https://" . $_SERVER['SERVER_NAME'];
}

function getRoot()
{
    $root = $_SERVER['DOCUMENT_ROOT'];
    if ($root != "public_html") {
        return $root . "/file_manager";
    }
    return $root;
}

function logOutUser()
{
    session_unset();
    session_destroy();
    if (isset($_COOKIE['user_id'])) {
        setcookie("user_id", "", time() - 3600, "/");
    }
}

function userDir($id)
{
    $id = base64_encode($id);
    $path = getRoot() . "/uploads/$id";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    return $path;
}

function getFiles($path): array
{
    return array_diff(scandir($path), [".", ".."]);
}

function formatFileSize($size)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $unitIndex = 0;

    while ($size >= 1024 && $unitIndex < count($units) - 1) {
        $size /= 1024;
        $unitIndex++;
    }

    return round($size, 2) . ' ' . $units[$unitIndex];
}


function isAudioFile($path)
{
    $fileExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $audioExtensions = array(
        'mp3', 'wav', 'ogg', 'aac', 'm4a', 'flac', 'wma', // Add more audio file extensions as needed
    );
    return in_array($fileExtension, $audioExtensions);
}


function isImage($path)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $path);
    finfo_close($finfo);

    return strpos($mime, 'image') === 0;
}

function isVideo($path)
{
    $fileExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $videoExtensions = array('mp4', 'avi', 'mov', 'wmv', 'mkv');
    return in_array($fileExtension, $videoExtensions);
}

function createThumbnail($path)
{
    $ffmpegPath = 'C:\ffmpeg\bin\ffmpeg.exe'; // Update with the correct path to ffmpeg.exe
    $thumbURL = getBaseURL() . "/thumbnails/" . basename($path) . ".jpg";
    $thumbDir =  getRoot() . "file_manager/thumbnails/";
    $thumbPath = $thumbDir . basename($path) . ".jpg";
    if (file_exists($thumbPath)) {
        return $thumbURL;
    }
    $command = "$ffmpegPath -i \"$path\" -ss 00:00:01 -vframes 1 \"$thumbPath\"";
    exec($command, $output, $returnCode);
    return $thumbURL;
}

function displayFiles(array $files, string $searchQry = null)
{
    $output = "<div class='files-grid row row-gap-3'>";

    foreach ($files as $f) {
        if ($searchQry && stripos($f['fname'], $searchQry) === false) {
            continue;
        }

        $class = "";
        $loc = "";
        $preview = "";

        if ($f["ftype"] == "dir") {
            $class = "file-icon-dir";
        } else {
            $loc = getBaseURL() . "/app/view/file.php";
        }

        if ($f['isMedia']) {
            $vicon = "";
            $upath = getBaseURL() . "/uploads/" . base64_encode(getUserId()) . "/" . $f['fpath'];
            if ($f['ftype'] == "video" && $f['thumbnailPath']) {
                $upath = $f['thumbnailPath'];
                $vicon = "ri-play-circle-fill";
            }
            $img = "<img src='$upath' alt='#' class='rounded-1 position-static z-0'>";

            $preview = "<div class='file-icon file-icon-media rounded-1 position-relative'>
                                            $img
                                            <div class='position-absolute top-0 end-0 pb-2 ps-3 d-flex'>
                                                <i class='{$vicon} m-auto h3 text-warning'></i>
                                            </div>
                                        </div>";
        } else {
            $preview = "<div class='file-icon $class d-flex rounded-1'>
                                            <i class='{$f['ficon']} m-auto'></i>
                         </div>";
        }
        $euid = base64_encode(getUserId());
        $sharePath = base64_encode(getRoot()."/uploads/$euid/{$f['fpath']}");

        $output .= "<div class='col-md-4 position-relative file-outer' data-filepath='{$f['fpath']}' data-sharepath='{$sharePath}' oncontextmenu='toggleMenu(event)'>
                        <div class='file-check-outer d-none position-absolute top-0 start-0 h-100 w-100 z-4'>
                            <label for='fileCheck' class='h-100 w-100 d-block ps-3 pt-1'>
                                <input class='form-check-input bg-warning border-0' type='checkbox' id='fileCheck' onchange='checkFile(event)'>
                            </label>
                        </div>
                        <a class='file-item row g-2 pb-2' href='{$loc}?path={$f['fpath']}'>
                            <div class='col-md-4 col-xl-3 col-3'>
                                $preview
                            </div>
                            <div class='col-md-8 col-xl-9 col-9'>
                                <div class='file-info'>
                                    <div class='file-title'>{$f['fname']}</div>
                                    <div class='file-prop text-secondary'>
                                    <i><span class='file-date'>{$f['fdate']}</span></i> &bullet;
                                        <span class='file-size'>{$f['fsize']}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>";
    }
    $output .= "</div>";
    echo $output;
}

function deleteFiles($path)
{
    if (!is_dir($path)) return unlink($path);

    $files = array_diff(scandir($path), array('.', '..'));
    foreach ($files as $file) {
        deleteFiles("$path/$file");
    }
    rmdir($path);
}

function deleteAccount($conn)
{
    $uid = @getUserId();
    if ($uid) {
        $path = userDir($uid);
        deleteFiles($path);
        $qry = $conn->query("DELETE FROM users WHERE user_id = $uid");
        logOutUser();
        return true;
    }
}
