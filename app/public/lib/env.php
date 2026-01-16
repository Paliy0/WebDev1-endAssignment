<?php

// Database configuration - uses environment variables if set, otherwise defaults for local dev
$_ENV["DB_HOST"] = getenv("DB_HOST") ?: "mysql";
$_ENV["DB_NAME"] = getenv("DB_NAME") ?: "phpshop";
$_ENV["DB_USER"] = getenv("DB_USER") ?: "root";
$_ENV["DB_PASSWORD"] = getenv("DB_PASSWORD") ?: "secret123";
$_ENV["DB_CHARSET"] = getenv("DB_CHARSET") ?: "utf8mb4";
$_ENV["ENV"] = getenv("ENV") ?: "LOCAL";

// Cloudinary configuration
$_ENV["CLOUDINARY_CLOUD_NAME"] = getenv("CLOUDINARY_CLOUD_NAME") ?: "your_cloud_name";
$_ENV["CLOUDINARY_API_KEY"] = getenv("CLOUDINARY_API_KEY") ?: "your_api_key";
$_ENV["CLOUDINARY_API_SECRET"] = getenv("CLOUDINARY_API_SECRET") ?: "your_api_secret";
