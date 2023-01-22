<?php

$_SESSION = array();
$_SESSION["loggedin"] = false;
session_destroy();
// Redirecting To Home Page
header("Location: index");
