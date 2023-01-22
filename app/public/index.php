<?php
require __DIR__ . '/../routers/patternrouter.php';

//print_r($_SESSION);

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new PatternRouter();
$router->route($uri);
