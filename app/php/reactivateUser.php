<?php

require_once "../../db/conn.php";
$qry = $conn->query("UPDATE users 
                     SET login_attempt = 0 ,
                         last_login_attempt = NULL
                     WHERE user_id IN (
                         SELECT user_id 
                         FROM users 
                         WHERE TIMESTAMPDIFF(MINUTE, last_login_attempt, NOW()) >= 120
                     )");
