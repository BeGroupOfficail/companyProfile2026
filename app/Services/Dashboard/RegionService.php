<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\Settings\RegionRequest;
use App\Models\Dashboard\Country;
use App\Models\Dashboard\Region;
use Illuminate\Support\Facades\DB;

class RegionService
{
    public function create()
    {
        return Country::get()->pluck('name', 'id')->toArray();;
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            $region = new Region();
            $region->country_id=$dataValidated['country_id'];
            $this->handleTranslations($dataValidated, $region);
            $region->save();
            DB::commit();
            return $region;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($dataValidated, $region)
    {
        DB::beginTransaction();
        try {
            $region->country_id = $dataValidated['country_id'];
            $this->handleTranslations($dataValidated, $region);
            $region->update();
            DB::commit();
            return $region;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handleTranslations($dataValidated, $country)
    {

        $languages = array_keys(config('languages'));
        $translatableFields = ['name'];

        foreach ($languages as $lang) {
            foreach ($translatableFields as $field) {
                $fieldKey = "{$field}_{$lang}";

                if (isset($dataValidated[$fieldKey])) {
                    $value = $field === 'slug'
                        ? preg_replace('/[\/\\\ ]/', '-', $dataValidated["name_{$lang}"])
                        : $dataValidated[$fieldKey];

                    $country->setTranslation($field, $lang, $value)->save();
                }
            }
        }
    }

    public function delete($selectedIds)
    {
        DB::beginTransaction();
        try {
            $deleted = Region::whereIn('id', $selectedIds)->delete();
            DB::commit();
            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
