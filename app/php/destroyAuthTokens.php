<?php 

require_once "../../db/conn.php";

$qry = $conn->query("UPDATE users SET auth_token = NULL, auth_token_timestamp = NULL WHERE user_id IN( SELECT user_id FROM users WHERE TIMESTAMPDIFF( MINUTE, auth_token_timestamp, NOW()) > 5 );");

?>