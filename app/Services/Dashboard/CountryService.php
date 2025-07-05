<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Dashboard\Country;
use Illuminate\Support\Facades\DB;

class CountryService
{

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            $country = new Country();
            $this->handleTranslations($dataValidated, $country);
            $country->save();
            DB::commit();
            return $country;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($dataValidated, $country){
        DB::beginTransaction();
        try {
            $this->handleTranslations($dataValidated, $country);
            $country->update();
            DB::commit();
            return $country;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handleTranslations($dataValidated, $country){

        // Get supported languages from config
        $languages = array_keys(config('languages')); // Fetch language codes (keys)
        $translatableFields = ['name'];

        foreach ($languages as $lang) {
            foreach ($translatableFields as $field) {
                $fieldKey = "{$field}_{$lang}";

                if (isset($dataValidated[$fieldKey])) {
                    // For 'slug', generate it dynamically from 'name'
                    $value = $field === 'slug'
                        ? preg_replace('/[\/\\\ ]/', '-', $dataValidated["name_{$lang}"])
                        : $dataValidated[$fieldKey];

                    $country->setTranslation($field, $lang, $value)->save();

                }
            }
        }
    }

    public function delete($selectedIds){
        DB::beginTransaction();
        try {
            $deleted = Country::whereIn('id', $selectedIds)->delete();
            DB::commit();
            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
