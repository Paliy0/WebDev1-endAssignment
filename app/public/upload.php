<?php
require_once __DIR__ . '../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Initialize Cloudinary configuration
Configuration::instance("cloudinary://{$_ENV['CLOUDINARY_KEY']}:{$_ENV['CLOUDINARY_SECRET']}@{$_ENV['CLOUDINARY_USER']}?secure=true");


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $uploadApi = new UploadApi();

    // Upload image to Cloudinary
    $response = $uploadApi->upload($_FILES['image']['tmp_name']);

    // Check if upload was successful
    if (isset($response['url'])) {
        echo "Image uploaded successfully. Here's the URL: " . $response['url'];
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product Image</title>
</head>

<body>
    <h1>Upload Product Image</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" id="image" accept="image/*" required>
        <button type="button" id="removeImage">Cancel</button>
        <button type="submit">Upload Image</button>
    </form>
    <script>
        document.getElementById('removeImage').addEventListener('click', function() {
            var input = document.getElementById('image');
            input.value = ''; // Clear the input value
        });
    </script>
</body>

</html>