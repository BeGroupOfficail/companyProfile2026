<?php

namespace App\Services\Dashboard\Seo;
use App\Models\Dashboard\Seo\Seo;
use Illuminate\Support\Facades\DB;

class SeoService
{
    public function edit($pageType){
        $seo = Seo::where('page_type',$pageType)->first();
        $pageTypes = Seo::PAGETYPES;
        $schmeaTypes= Seo::SCHEMATPES;

        if(!$seo && in_array($pageType, $pageTypes)){
            $seo = Seo::updateOrCreate(
                ['page_type' => $pageType]  // Attributes to update or create
            );
        }
        return[$seo,$pageTypes,$schmeaTypes];
    }
    public function update($dataValidated, $seo){
        DB::beginTransaction();

        try {
            $data = [
                'index' => $dataValidated['index']?? 0,
                'schema_types' => $dataValidated['schema_types']?? [],
            ];

            // Update the settings with the new validated data
            $seo->update($data);

            // Handle translations for fields ('site_name', 'site_desc')
            $seo->handleTranslations(
                $dataValidated,
                ['title','slug', 'meta_title', 'meta_desc'], // custom fields
                true // auto-generate slug
            );
            DB::commit();

            return $seo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
