<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Transformation\Transformation;
use Cloudinary\Asset\Image;
use Exception;

class CloudinaryService
{
    private static $instance = null;

    /**
     * Initialize Cloudinary configuration
     */
    private function __construct()
    {
        // Configure Cloudinary
        Configuration::instance("cloudinary://{$_ENV['CLOUDINARY_API_KEY']}:{$_ENV['CLOUDINARY_API_SECRET']}@{$_ENV['CLOUDINARY_CLOUD_NAME']}?secure=true");
    }

    /**
     * Get singleton instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Upload an image to Cloudinary
     * 
     * @param string $filePath Path to the file to upload
     * @param string $folder Folder to upload to (e.g., 'products', 'shops')
     * @param string $publicId Optional public ID for the image
     * @return array Upload result data or false on failure
     */
    public function uploadImage($filePath, $folder = null, $publicId = null)
    {
        try {
            $uploadApi = new UploadApi();

            $options = [
                'overwrite' => true,
                'resource_type' => 'image'
            ];

            if ($folder) {
                $options['folder'] = $folder;
            }

            if ($publicId) {
                $options['public_id'] = $publicId;
            }

            $result = $uploadApi->upload($filePath, $options);

            return $result;
        } catch (Exception $e) {
            error_log("Cloudinary upload error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete an image from Cloudinary
     * 
     * @param string $publicId Public ID of the image to delete
     * @return bool Success or failure
     */
    public function deleteImage($publicId)
    {
        try {
            $uploadApi = new UploadApi();
            $result = $uploadApi->destroy($publicId);

            return $result['result'] === 'ok';
        } catch (Exception $e) {
            error_log("Cloudinary delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a transformed image URL
     * 
     * @param string $publicId Public ID of the image
     * @param array $transformations Array of transformation options
     * @return string Transformed image URL
     */
    public function getImageUrl($publicId, $transformations = [])
    {
        try {
            $transformation = new Transformation();

            // Add transformations if provided
            if (isset($transformations['width']) && isset($transformations['height'])) {
                $transformation->resize(
                    \Cloudinary\Transformation\Resize::fill()
                        ->width($transformations['width'])
                        ->height($transformations['height'])
                );
            }

            // Create the Cloudinary image
            $image = new Image($publicId);
            $image->addTransformation($transformation);

            return $image->toUrl();
        } catch (Exception $e) {
            error_log("Cloudinary URL error: " . $e->getMessage());
            return '';
        }
    }
}
