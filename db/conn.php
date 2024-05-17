<?php

define("host", "localhost");
define("username", "root");
define("password", "");
define("db", "file_manager");

try {
    $conn = new mysqli(host, username, password, db);
} catch (Exception $e) {
    die("Something Went Wrong ! [" . $e->getCode() . "]");
}

?>