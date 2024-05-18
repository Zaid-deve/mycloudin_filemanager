<?php

require "../php/functions.php";
logOutUser();
header("Location: " . getBaseURL() . "/app/user/login.php");
