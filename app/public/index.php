<?php
// Start output buffering
ob_start();

// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Start session at the beginning
session_start();

require '../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// Only redirect to login if NOT logged in and trying to access protected routes
$publicRoutes = ['login', 'register', 'home', ''];  // Add other public routes as needed
$uri = trim($_SERVER['REQUEST_URI'], '/');
$firstSegment = explode('/', $uri)[0];

if (!isset($_SESSION['user_id']) && !in_array($firstSegment, $publicRoutes)) {
    header('Location: /login');
    exit();
}

$router = new App\PatternRouter();
$router->route($uri);

// Flush output buffer
ob_end_flush();
