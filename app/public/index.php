<?php

/**
 * Include Composer autoloader
 */
require_once(__DIR__ . "/../vendor/autoload.php");

/**
 * Set env variables and enable error reporting in local environment
 */
require_once(__DIR__ . "/lib/env.php"); // sets global env variables (database configuration)
require_once(__DIR__ . "/lib/error_reporting.php"); // enables error reporting locally

/**
 * Start user session
 */
session_start();

/**
 * Require routing library
 *  allows handling request for different URL routes, i.e. /users, /products, etc.
 */
require_once(__DIR__ . "/lib/Route.php");

/**
 * Require routes
 */
require_once(__DIR__ . "/routes/index.php");
require_once(__DIR__ . "/routes/user.php");
require_once(__DIR__ . "/routes/auth.php");
require_once(__DIR__ . "/routes/product.php");
require_once(__DIR__ . "/routes/shop.php");

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://974684973245881:XxDkhqEcnzOVHX2EHLez6D8HLQg@paliyo?secure=true');


// Handle 404 errors
Route::pathNotFound(function ($path) {
    header('HTTP/1.0 404 Not Found');
    require(__DIR__ . "/views/pages/404.php");
});

// Start the router, enabling handling requests
Route::run();
