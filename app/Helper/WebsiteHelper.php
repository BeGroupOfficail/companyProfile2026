<?php
namespace App\Helper;

use App\Models\Dashboard\Setting\WebsiteDesign;
class WebsiteHelper
{

    public static function getAsset($path)
    {
        $design = WebsiteDesign::getActiveDesign();
        $designFolder = $design ? $design->folder : 'design1';
        return asset('assets/website-designs/' . $designFolder . '/' . $path);
    }

    public static function getImage($folder, $image)
    {
        $path = public_path("uploads/$folder/$image");
        $url = asset("uploads/$folder/$image");
        $default_image = public_path("no-image.png");
        if ($image) {
            return $url;
        } else {
            return $default_image;
        }
    }
}
