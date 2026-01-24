<?php

namespace App\Services\Dashboard\Album;

use App\Helper\Media;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Album\AlbumImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumImageService
{

    public function edit()
    {
        $images = DB::table('temp_upload_files')->where('type', 'album_images')->get();
        if (count($images) > 0) {
            foreach ($images as $image) {
                try {
                    // Define the full path
                    $folder = 'album_images';
                    $img_path = public_path('uploads/' . $folder);

                    // Ensure the directory exists
                    if (!file_exists($img_path)) {
                        mkdir($img_path, 0755, true); // Create directory if it does not exist
                    }

                    if ($image->server_name) {
                        (file_exists(sprintf($img_path . '%s', $image->server_name))) ? unlink(sprintf($img_path . '%s', $image->server_name)) : '';
                    }
                } catch (\Exception $e) {
                    throw $e;
                }
            }
            DB::table('temp_upload_files')->where('type', 'album_images')->delete();
            session()->forget('imagesUpload');
            session()->forget('imagesUploadRealName');
        }
    }

    public function store($id)
    {
        try {
            $album = Album::find($id);

            ///////// save gallery images//////
            if (session()->has('imagesUpload')) {

                $images = DB::table('temp_upload_files')->where('type', 'album_images')->get();
                $lang = app()->getLocale();
                foreach ($images as $key => $file) {
                    $img = new AlbumImage();
                    $img->album_id = $id;
                    $img->image = $file->server_name;
                    $img->alt_image = $album->getTranslation('title', $lang) . ' image'.($key + 1) ;
                    $img->status = 'published';
                    $img->order = $key + 1;
                    $img->save();
                }
            }

            DB::table('temp_upload_files')->where('type', 'gallery_image')->delete();
            session()->forget('imagesUpload');
            session()->forget('imagesUploadRealName');

            return $album;

        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function deleteImage($id)
    {
        try {
            $image = AlbumImage::findOrFail($id);

            // Delete the file from storage
            if ($image->image) {
                Media::removeFile('album_images', $image->image);
            }

            // Delete the record
            $image->delete();

           return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function changeStatus($request,$id){
        try {
            $image = AlbumImage::find($id);
            $newStatus = $image->status === 'published' ? 'inactive' : 'published';

            $image->update(['status' => $newStatus]);

            return [
                'new_status' => $newStatus,
                'status_label' => $newStatus === 'published'
                    ? __('dash.published')
                    : __('dash.inactive'),
                'status_class' => $newStatus === 'published'
                    ? 'badge-light-success'
                    : 'badge-light-danger'
            ];

        } catch (\Exception $e) {
            throw $e;
        }
    }


    /////// upload images///////////////
    public function uploadImages($request){
        $request->validate([
            'file' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:3096' // 3MB max
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = Media::storeImage($file, 'album_images');

            // Store in temporary database
            DB::table('temp_upload_files')->insert([
                'server_name' => $fileName,
                'original_name' => $originalName,
                'type' => 'album_images',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Manage session data more efficiently
            $uploadedFiles = session('imagesUpload', []);
            $uploadedNames = session('imagesUploadRealName', []);

            array_push($uploadedFiles, $fileName);
            array_push($uploadedNames, $originalName);

            session([
                'imagesUpload' => $uploadedFiles,
                'imagesUploadRealName' => $uploadedNames
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'message' => __('File uploaded successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => __('Failed to upload file: ') . $e->getMessage()
            ], 500);
        }
    }

    ///////// delete uploaded images///////////
    public function removeUploadImages($request){
        try {
            DB::beginTransaction();

            // Get session data with defaults
            $originalNames = session('imagesUploadRealName', []);
            $serverNames = session('imagesUpload', []);

            // Find the file to remove
            $key = array_search($request->name, $originalNames);

            if ($key === false) {
                throw new \Exception(__('File not found in session'));
            }

            // File paths
            $storagePath = storage_path('app/public/uploads/galleryImages/');
            $filePath = $storagePath . $serverNames[$key];

            // Delete physical file if exists
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    throw new \Exception(__('Failed to delete physical file'));
                }
            }

            // Remove from session arrays
            array_splice($originalNames, $key, 1);
            array_splice($serverNames, $key, 1);

            // Update session
            session([
                'imagesUpload' => array_values($serverNames), // Reindex array
                'imagesUploadRealName' => array_values($originalNames)
            ]);

            // Delete from database
            DB::table('temp_upload_files')
                ->where('original_name', $request->name)
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('File removed successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder($request, $id){
        $image = AlbumImage::findOrFail($id);
        $image->order = $request->input('order');
        $image->save();

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully'
        ]);
    }





}

