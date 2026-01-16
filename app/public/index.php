<?php

require_once(__DIR__ . "/../vendor/autoload.php");

require_once(__DIR__ . "/lib/env.php");
require_once(__DIR__ . "/lib/error_reporting.php");
require_once(__DIR__ . "/lib/image_helpers.php");

session_start();

require_once(__DIR__ . "/lib/Route.php");

require_once(__DIR__ . "/routes/index.php");
require_once(__DIR__ . "/routes/user.php");
require_once(__DIR__ . "/routes/auth.php");
require_once(__DIR__ . "/routes/product.php");
require_once(__DIR__ . "/routes/shop.php");
require_once(__DIR__ . "/routes/customer.php");
require_once(__DIR__ . "/routes/admin.php");

use Cloudinary\Configuration\Configuration;

// Configure Cloudinary using environment variables
$cloudinaryUrl = sprintf(
    'cloudinary://%s:%s@%s?secure=true',
    $_ENV['CLOUDINARY_API_KEY'],
    $_ENV['CLOUDINARY_API_SECRET'],
    $_ENV['CLOUDINARY_CLOUD_NAME']
);
Configuration::instance($cloudinaryUrl);

Route::pathNotFound(function ($path) {
    header('HTTP/1.0 404 Not Found');
    require(__DIR__ . "/views/pages/404.php");
});

Route::run();
