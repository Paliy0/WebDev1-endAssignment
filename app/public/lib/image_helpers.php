<?php

function cloudinary_thumbnail($url, $use_thumbnail = true) {
    if (!$use_thumbnail || empty($url)) {
        return htmlspecialchars($url);
    }

    if (strpos($url, 'res.cloudinary.com') !== false && strpos($url, '/upload/') !== false) {
        $url = str_replace('/upload/', '/upload/t_Thumbnail/', $url);
    }

    return htmlspecialchars($url);
}

function extract_cloudinary_public_id($url) {
    if (empty($url) || strpos($url, 'res.cloudinary.com') === false) {
        return null;
    }

    $parts = explode('/upload/', $url);
    if (count($parts) !== 2) {
        return null;
    }

    $pathParts = explode('/', $parts[1]);
    $pathParts = array_filter($pathParts, function($part) {
        return !preg_match('/^v\d+$/', $part);
    });

    $lastPart = end($pathParts);
    $pathParts[count($pathParts) - 1] = pathinfo($lastPart, PATHINFO_FILENAME);

    return implode('/', $pathParts);
}
