<?php

namespace App\Services\Dashboard\Setting;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function update($request, $dataValidated, $general_setting){
        DB::beginTransaction();
        try {
            // Elements to remove from the validated data
            $elementsToRemove = ['site_name_en', 'site_desc_en', 'site_name_ar', 'site_desc_ar'];

            // Filter out the elements we don't want to mass-assign
            $data = array_diff_key($dataValidated, array_flip($elementsToRemove));

            // Update the settings with the new validated data
            $general_setting->update($data);
            // Handle translations for fields ('site_name', 'site_desc')
            $general_setting->handleTranslations(
                $dataValidated,
                ['site_name', 'site_desc'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $general_setting->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'settings', // media type (storage folder)
                ['logo', 'white_logo','dark_logo','fav_icon'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $general_setting;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
