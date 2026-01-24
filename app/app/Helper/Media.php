<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class Media
{
    /**
     * Store an image file in the specified folder using the public disk.
     */
    public static function storeImage($imageFile, $folder)
    {
        try {
            // Generate a unique filename
            $name_gen = hexdec(uniqid()) . '.' . $imageFile->getClientOriginalExtension();

            // Define the path within the storage disk
            $path = 'uploads/' . $folder . '/' . $name_gen;

            // Store the image using the Storage facade
            Storage::disk('public')->put($path, file_get_contents($imageFile));

            return $name_gen;
        } catch (\Exception $e) {
            Log::error('Image storage failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Store a non-image file in the specified folder using the public disk.
     */
    public static function storeFile($file, $folder)
    {
        try {
            // Generate a unique filename
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            // Define the path within the storage disk
            $path = 'uploads/' . $folder . '/' . $name_gen;

            // Store the file using the Storage facade
            Storage::disk('public')->put($path, file_get_contents($file));

            return $name_gen;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Upload and attach images to a model.
     */
    public static function uploadAndAttachImages($data, $model, $folder = 'uploads')
    {
        foreach (['image','image_en','banner_en', 'icon', 'logo', 'white_logo', 'dark_logo', 'banner', 'fav_icon','certificate_example','statement_template'] as $field) {
            if (isset($data[$field])) {
                // Call static method storeImage
                $imageName = self::storeImage($data[$field], $folder);

                if (!$imageName) {
                    throw new \Exception("Failed to upload {$field}.");
                }

                $model->update([$field => $imageName]);
            }
        }
    }

    /**
     * Remove a file from the specified folder in the public disk.
     */
    public static function removeFile($folder, $file)
    {
        $path = 'uploads/' . $folder . '/' . $file;
        if ($file && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // ============================================
    // HETZNER OBJECT STORAGE METHODS
    // ============================================

    /**
     * Store an image file in the specified folder using Hetzner Object Storage.
     */
    public static function storeImageToHetzner($imageFile, $folder)
    {
        try {
            // Generate a unique filename
            $name_gen = hexdec(uniqid()) . '.' . $imageFile->getClientOriginalExtension();

            // Define the path within the storage disk
            $path = $folder . '/' . $name_gen;

            // Store the image using the Storage facade
            Storage::disk('hetzner')->put($path, file_get_contents($imageFile), 'public');

            return $name_gen;
        } catch (\Exception $e) {
            Log::error('Hetzner image storage failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Store a non-image file in the specified folder using Hetzner Object Storage.
     */
    public static function storeFileToHetzner($file, $folder)
    {
        try {
            // Generate a unique filename
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            // Define the path within the storage disk
            $path = $folder . '/' . $name_gen;

            // Store the file using the Storage facade
            Storage::disk('hetzner')->put($path, file_get_contents($file), 'public');

            return $name_gen;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Upload and attach images to a model using Hetzner Object Storage.
     */
    public static function uploadAndAttachImagesToHetzner($data, $model, $folder = 'uploads')
    {
        foreach (['image','image_en','banner_en', 'icon', 'logo', 'white_logo', 'dark_logo', 'banner', 'fav_icon','certificate_example','statement_template'] as $field) {
            if (isset($data[$field])) {
                // Call static method storeImageToHetzner
                $imageName = self::storeImageToHetzner($data[$field], $folder);

                if (!$imageName) {
                    throw new \Exception("Failed to upload {$field}.");
                }

                $model->update([$field => $imageName]);
            }
        }
    }

    /**
     * Remove a file from the specified folder in Hetzner Object Storage.
     */
    public static function removeFileFromHetzner($folder, $file)
    {
        $path = $folder . '/' . $file;
        if ($file && Storage::disk('hetzner')->exists($path)) {
            Storage::disk('hetzner')->delete($path);
        }
    }
}
