<?php

namespace App\Services\Dashboard\Slider;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Slider\Slider;
use Illuminate\Support\Facades\DB;

class SliderService
{
    public function index()
    {
        return Slider::all();
    }
    public function create()
    {
        return Slider::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            $slider = Slider::create($dataValidated);

            // Handle media uploads (image)
            $slider->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'sliders', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $slider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $slider){
        DB::beginTransaction();

        try {
            // Update the slider with the new validated data
            $slider->update($dataValidated);

            // Handle media uploads (image)
            $slider->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'sliders', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $slider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteSliders($selectedIds)
{
    DB::beginTransaction();
    try {
        $trashedSliders = Slider::onlyTrashed()->whereIn('id', $selectedIds)->get();
        $activeSliders = Slider::whereIn('id', $selectedIds)->get();
        
        if ($trashedSliders->isNotEmpty()) {
            foreach ($trashedSliders as $slider) {
                if ($slider->image) {
                    Media::removeFile('sliders', $slider->image);
                }
            }
            Slider::onlyTrashed()->whereIn('id', $trashedSliders->pluck('id'))->forceDelete();
        }
        
        if ($activeSliders->isNotEmpty()) {
            SoftDeleteHelper::deleteWithEvents(Slider::class, $activeSliders->pluck('id')->toArray());
        }
        
        DB::commit();
        return true;
        
    } catch (\Exception $e) {
        DB::rollBack();
        return false;
    }
}
}
