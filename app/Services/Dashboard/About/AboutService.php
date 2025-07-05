<?php

namespace App\Services\Dashboard\About;
use Illuminate\Support\Facades\DB;

class AboutService
{
    public function update($dataValidated, $about){
        DB::beginTransaction();

        try {
            // Update the settings with the new validated data
            $about->update($dataValidated);

            // Handle translations for fields ('site_name', 'site_desc')
            $about->handleTranslations(
                $dataValidated,
                ['title', 'description','why_choose_us','slug', 'meta_title', 'meta_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (banner and image)
            $about->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'about', // media type (storage folder)
                ['image', 'banner'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $about;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
