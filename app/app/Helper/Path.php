<?php
 namespace App\Helper;
 use Illuminate\Support\Facades\Log;
 use Illuminate\Support\Facades\Storage;
class Path{

    public static function dashboardPath($path)
    {
      return asset('assets/dashboard/'.$path);
    }

    public function dashboardImage()
    {
        return asset('assets/dashboard');
    }

    public static function uploadedImage($folder, $image){
        return asset('uploads/'.$folder.'/'.$image);
    }
    //that to convert the embed link to share link

    function convertEmbedToShareLink($embedUrl) {
        // Extract the place ID from the pb parameter
        preg_match( '/!1s(0x[a-f0-9]+:0x[a-f0-9]+)/i', $embedUrl, $matches);
        if (isset($matches[1])) {
            $placeId = $matches[1];
            return "https://www.google.com/maps/place/?q=place_id:" . $placeId;
        }

        // Extract coordinates from !2d (longitude) and !3d (latitude)
        if (preg_match('/!2d([0-9.\-]+)!3d([0-9.\-]+)/', $embedUrl, $coordMatches)) {
            $lng = $coordMatches[1];
            $lat = $coordMatches[2];
            return "https://www.google.com/maps/search/?api=1&query=$lat,$lng";
        }

        // Fallback
        return "https://www.google.com/maps/";
    }

    /**
     * Get the full URL for a file stored in Hetzner Object Storage.
     */
    public static function getHetznerUrl($folder, $filename)
    {
        if (!$filename) {
            return null;
        }

        $path = $folder . '/' . $filename;

        try {
            return Storage::disk('hetzner')->url($path);
        } catch (\Exception $e) {
            Log::error('Failed to get Hetzner URL: ' . $e->getMessage());
            return null;
        }
    }



}
