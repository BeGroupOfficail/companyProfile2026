<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\Settings\AreaRequest;
use App\Models\Dashboard\Country;
use App\Models\Dashboard\Area;
use App\Models\Dashboard\Region;
use Illuminate\Support\Facades\DB;

class AreaService
{
    public function create()
    {
        return Country::get()->pluck('name', 'id')->toArray();;
    }
    public function edit($area)
    {
        $countries =  Country::get()->pluck('name', 'id')->toArray();
        $regions =  Region::where('country_id', $area->region->country->id)->pluck('name', 'id')->toArray();
        return [$countries, $regions];
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            $area = new Area();
            $area->region_id=$dataValidated['region_id'];
            $this->handleTranslations($dataValidated, $area);
            $area->save();
            DB::commit();
            return $area;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($dataValidated, $area)
    {
        DB::beginTransaction();
        try {
            $area->region_id = $dataValidated['region_id'];
            $this->handleTranslations($dataValidated, $area);
            $area->update();
            DB::commit();
            return $area;
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
            $deleted = Area::whereIn('id', $selectedIds)->delete();
            DB::commit();
            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
