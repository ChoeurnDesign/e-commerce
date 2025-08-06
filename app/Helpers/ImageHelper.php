<?php

namespace App\Helpers;

class ImageHelper
{
    // Example: return a default image if $url is empty
    public static function get($url, $default = '/img/default-product.png')
    {
        return $url ?: $default;
    }
}
