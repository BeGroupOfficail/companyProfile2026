<?php

namespace App\Services\Dashboard\Destination;

use App\Helper\Media;
use App\Models\Dashboard\Country;
use App\Models\Dashboard\Destination\Destination;
use App\Models\Dashboard\Region;
use Illuminate\Support\Facades\DB;

class DestinationService
{
    public function index()
    {
        return Destination::get();
    }
    public function create()
    {
        $countries = Country::select('id','name')->get();
        return $countries;
    }

    public function edit($destination)
    {
        $countries =  Country::get()->pluck('name', 'id')->toArray();
        $regions =  Region::where('country_id', $destination->country_id)->pluck('name', 'id')->toArray();
        return [$countries,$regions];
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
                'featured' => $dataValidated['featured']??0,
                'country_id' => $dataValidated['country_id'],
                'region_id' => $dataValidated['region_id'],
            ];

            $destination = Destination::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $destination->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $destination->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'destinations', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $destination;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $destination){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
                'featured' => $dataValidated['featured']??0,
                'country_id' => $dataValidated['country_id'],
                'region_id' => $dataValidated['region_id'],
            ];

            // Update the category with the new validated data
            $destination->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $destination->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $destination->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'destinations', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $destination;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteDestinations($selectedIds){
        $destinations = Destination::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($destinations as $destination) {
                // Delete associated image if it exists
                if ($destination->image) {
                    Media::removeFile('destinations', $destination->image);
                }
            }
            $deleted = Destination::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
