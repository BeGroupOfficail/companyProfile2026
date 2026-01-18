<?php

namespace App\Services\Dashboard\Video;

use App\Models\Dashboard\Video\Video;
use Illuminate\Support\Facades\DB;

class VideoService
{
    public function index()
    {
        return Video::all();
    }
    public function create()
    {
        return Video::all();
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'video' => $dataValidated['video'] ?? 0,
            ];

            $video = Video::create($data);
            $video->handleMedia(
                request(),
                $dataValidated,
                'videos',
                ['image']
            );
            DB::commit();

            return $video;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $video)
    {
        DB::beginTransaction();
        try {
            // Update the category data (status, index, etc.)
            $data = [
                'video' => $dataValidated['video'] ?? 0,
            ];
            $video->update($data);
            $video->handleMedia(
                request(),
                $dataValidated,
                'videos',
                ['image']
            );

            DB::commit();

            return $video;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteVideos($selectedIds)
    {
        $videos = Video::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {

            $deleted = Video::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
