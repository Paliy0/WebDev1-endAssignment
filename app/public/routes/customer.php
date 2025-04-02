<?php

// Login page route
Route::add('/dashboard', function () {
    require(__DIR__ . "/../views/pages/customer_dashboard.php");
}, 'get');
