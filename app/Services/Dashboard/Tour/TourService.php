<?php

namespace App\Services\Dashboard\Tour;

use App\Helper\Media;
use App\Models\Dashboard\Destination\Destination;
use App\Models\Dashboard\Tour\Tour;
use Illuminate\Support\Facades\DB;

class TourService
{
    public function index()
    {
        return Tour::get();
    }
    public function create()
    {
        $destinations= Destination::select('id','name')->get();
        $tourTypes = Tour::TOURTPES;
        return [$destinations,$tourTypes];
    }

    public function edit()
    {
        $destinations =  Destination::get()->pluck('name', 'id')->toArray();
        $tourTypes = Tour::TOURTPES;
        return [$destinations,$tourTypes];
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data =[
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
                'featured' => $dataValidated['featured']??0,
                'destination_id' => $dataValidated['destination_id'],
                'tour_type' => $dataValidated['tour_type'],
                'person_price_per_day' => $dataValidated['person_price_per_day'],
                'number_days' => $dataValidated['number_days'],
                'number_nights' => $dataValidated['number_nights'],
            ];

            $tour = Tour::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $tour->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'short_desc','long_desc','tour_plan'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $tour->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'tours', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $tour;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $tour){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
                'featured' => $dataValidated['featured']??0,
                'destination_id' => $dataValidated['destination_id'],
                'tour_type' => $dataValidated['tour_type'],
                'person_price_per_day' => $dataValidated['person_price_per_day'],
                'number_days' => $dataValidated['number_days'],
                'number_nights' => $dataValidated['number_nights'],
            ];

            // Update the category with the new validated data
            $tour->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $tour->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'short_desc','long_desc','tour_plan'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $tour->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'tours', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $tour;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteTours($selectedIds){
        $tours = Tour::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($tours as $tour) {
                // Delete associated image if it exists
                if ($tour->image) {
                    Media::removeFile('tours', $tour->image);
                }
            }
            $deleted = Tour::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
