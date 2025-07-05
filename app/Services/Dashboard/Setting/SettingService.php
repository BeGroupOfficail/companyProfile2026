<?php

namespace App\Services\Dashboard\Setting;

use App\Helper\Media;
use App\Models\Dashboard\Setting\HomepageSection;
use App\Models\Dashboard\Setting\WebsiteDesign;
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

    public function updateWebsiteDesign($request){
        DB::beginTransaction();
        try{
            // Find the website design by its ID
            $websiteDesign = WebsiteDesign::find($request->website_design_id);
            if (!$websiteDesign) {
                throw new \Exception('Website design not found.');
            }
            $websiteDesign->update(['is_active' => true]);

            // Deactivate all homepage sections
            $updatedRows = HomepageSection::query()->update(['is_active' => false]);

            // Loop through the array of selected section IDs and activate them
            $selectedSectionIds = $request->selectedSectionIds; // assuming this is an array
            $sections = HomepageSection::whereIn('id', $selectedSectionIds)->get();

            foreach ($sections as $section) {
                $section->update(['is_active' => true]);
            }

            // Commit the transaction
            DB::commit();
        } catch(\Exception $e) {
            // Rollback if any error occurs
            DB::rollBack();
            \Log::error('Error updating website design: ' . $e->getMessage());
            throw $e;
        }
    }

}
