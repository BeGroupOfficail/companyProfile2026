<?php
namespace App\Helper;
class WebsiteHelper
{

    public static function getAsset($path)
    {
        return asset('assets/website/' . $path);
    }

    public static function getImage($folder, $image)
    {
        $url = asset("uploads/$folder/$image");
        $default_image = asset('assets/dashboard/default.png');
        if ($image) {
            return $url;
        } else {
            return $default_image;
        }

    }

}
