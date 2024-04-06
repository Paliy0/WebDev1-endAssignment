<?php
require '../vendor/autoload.php';

// use Dotenv\Dotenv;
use Cloudinary\Configuration\Configuration;

// $dotenv = Dotenv::createImmutable(dirname(__DIR__));
// $dotenv->load();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

echo 'this is dir', __DIR__;

// Configure an instance of your Cloudinary cloud
Configuration::instance("cloudinary://{$_ENV['CLOUDINARY_KEY']}:{$_ENV['CLOUDINARY_SECRET']}@{$_ENV['CLOUDINARY_USER']}?secure=true");

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new App\PatternRouter();
$router->route($uri);
