<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Configure an instance of your Cloudinary cloud
Configuration::instance("cloudinary://{$_ENV['CLOUDINARY_KEY']}:{$_ENV['CLOUDINARY_SECRET']}@{$_ENV['CLOUDINARY_USER']}?secure=true");

if (isset($_SESSION['loggedin'])) {
    header('Location: /login/index');
}
$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new App\PatternRouter();
$router->route($uri);
