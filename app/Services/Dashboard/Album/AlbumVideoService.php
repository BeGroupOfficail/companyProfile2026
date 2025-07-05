<?php

namespace App\Services\Dashboard\Album;

use App\Helper\Media;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Album\AlbumVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumVideoService
{

    public function store(Request $request, $id)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'video_url' => 'required|url|starts_with:https://www.youtube.com,https://youtu.be/,https://vimeo.com',
                'order' => 'required|integer|min:0',
                'status' => 'required|in:published,inactive',
            ]);

            // Create the album videos record
            $albumMedia = AlbumVideo::create([
                'order' => $validated['order'],
                'status' => $validated['status'],
                'video_url' => $this->getYoutubeEmbedUrl($validated['video_url']) ?? null,
                'album_id' => $id
            ]);

            // Find the album
            $album = Album::findOrFail($id);

            return $album;

        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function deleteVideo($id)
    {
        try {
            $video = AlbumVideo::findOrFail($id);
            // Delete the record
            $video->delete();

            return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function changeStatus($request,$id){
        try {
            $video = AlbumVideo::find($id);
            $newStatus = $video->status === 'published' ? 'inactive' : 'published';

            $video->update(['status' => $newStatus]);

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

    public function updateOrder($request, $id){
        $video = AlbumVideo::findOrFail($id);
        $video->order = $request->input('order');
        $video->save();

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully'
        ]);
    }

    protected function getYoutubeEmbedUrl($url){
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id ;
    }


}

