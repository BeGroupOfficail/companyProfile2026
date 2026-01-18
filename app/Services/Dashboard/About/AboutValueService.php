<?php

namespace App\Services\Dashboard\About;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\About\AboutValue;
use Illuminate\Support\Facades\DB;

class AboutValueService
{
    public function index()
    {
        return AboutValue::get();
    }

    public function create(){
        return AboutValue::TYPES;
    }
    public function edit(){
        return AboutValue::TYPES;
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'type' => $dataValidated['type'],
                'order' => $dataValidated['order'],
            ];

            $aboutValue = AboutValue::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $aboutValue->handleTranslations(
                $dataValidated,
                ['title', 'description'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $aboutValue->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'about_values', // media type (storage folder)
                ['image','icon'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $aboutValue;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $aboutValue){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'type' => $dataValidated['type'],
                'order' => $dataValidated['order'],
                'index' => $dataValidated['index']?? 0,
            ];

            // Update the category with the new validated data
            $aboutValue->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $aboutValue->handleTranslations(
                $dataValidated,
                ['title', 'description'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $aboutValue->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'about_values', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );
            DB::commit();

            return $aboutValue;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteAboutValues($selectedIds){
        $aboutValues = AboutValue::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($aboutValues as $aboutValue) {
                // Delete associated image if it exists
                if ($aboutValue->image) {
                    Media::removeFile('about_values', $aboutValue->image);
                }

                // Delete associated icon if it exists
                if ($aboutValue->icon) {
                    Media::removeFile('about_values', $aboutValue->icon);
                }
            }
            $deleted = SoftDeleteHelper::deleteWithEvents(AboutValue::class, $selectedIds);
            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
