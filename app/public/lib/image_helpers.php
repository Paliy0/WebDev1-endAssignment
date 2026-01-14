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
