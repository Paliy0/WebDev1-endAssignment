<?php
require __DIR__ . '/../routers/patternrouter.php';



$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new PatternRouter();
//$router->get('/logout', 'LoginController@logout');
$router->route($uri);
