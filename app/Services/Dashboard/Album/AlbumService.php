<?php

namespace App\Services\Dashboard\Album;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Album\Album;
use Illuminate\Support\Facades\DB;

class AlbumService
{
    public function index()
    {
        return Album::all();
    }
    public function create()
    {
        return Album::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'type' => $dataValidated['type'],
                'type_value_id' => $dataValidated['type_value_id']??null,
            ];

            $category = Album::create($data);

            // Handle translations for the album fields (name, slug, meta_title, meta_desc, desc)
            $this->handleTranslations($dataValidated, $category);

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $album){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'type' => $dataValidated['type'],
                'type_value_id' => $dataValidated['type_value_id']??null,
            ];

            // Update the category with the new validated data
            $album->update($data);

            // Handle translations for the category fields (name, slug, meta_title, meta_desc, desc)
            $this->handleTranslations($dataValidated, $album);

            DB::commit();

            return $album;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handleTranslations($dataValidated, $album){
        // Get supported languages from config
        $languages = array_keys(config('languages')); // Fetch language codes (keys)
        $translatableFields = ['title','text'];

        foreach ($languages as $lang) {
            foreach ($translatableFields as $field) {
                $fieldKey = "{$field}_{$lang}";

                if (isset($dataValidated[$fieldKey])) {
                    // For 'slug', generate it dynamically from 'name'
                    $value = $field === 'slug'
                        ? preg_replace('/[\/\\\ ]/', '-', $dataValidated["name_{$lang}"])
                        : $dataValidated[$fieldKey];

                    $album->setTranslation($field, $lang, $value)->save();
                }
            }
        }
    }

    public function deleteAlbums($selectedIds){
        $albums = Album::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            $deleted = SoftDeleteHelper::deleteWithEvents(Album::class, $selectedIds);

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
