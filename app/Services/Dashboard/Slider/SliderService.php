<?php

namespace App\Services\Dashboard\Slider;

use App\Helper\Media;
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

    public function deleteSliders($selectedIds){
        $sliders = Slider::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($sliders as $slider) {
                // Delete associated image if it exists
                if ($slider->image) {
                    Media::removeFile('sliders', $slider->image);
                }
            }
            $deleted = Slider::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
