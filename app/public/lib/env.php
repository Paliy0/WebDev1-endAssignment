<?php

// Use Railway environment variables, fall back to local defaults
$_ENV["DB_HOST"] = getenv('MYSQL_HOST') ?: getenv('DB_HOST') ?: "mysql";
$_ENV["DB_NAME"] = getenv('MYSQL_DATABASE') ?: getenv('DB_NAME') ?: "phpshop";
$_ENV["DB_USER"] = getenv('MYSQL_USER') ?: getenv('DB_USER') ?: "root";
$_ENV["DB_PASSWORD"] = getenv('MYSQL_PASSWORD') ?: getenv('DB_PASSWORD') ?: "secret123";
$_ENV["DB_CHARSET"] = "utf8mb4";
$_ENV["ENV"] = getenv('RAILWAY_ENVIRONMENT') ? "PROD" : "LOCAL";

$_ENV["CLOUDINARY_CLOUD_NAME"] = getenv('CLOUDINARY_CLOUD_NAME') ?: "paliyo";
$_ENV["CLOUDINARY_API_KEY"] = getenv('CLOUDINARY_API_KEY') ?: "974684973245881";
$_ENV["CLOUDINARY_API_SECRET"] = getenv('CLOUDINARY_API_SECRET') ?: "XxDkhqEcnzOVHX2EHLez6D8HLQg";
