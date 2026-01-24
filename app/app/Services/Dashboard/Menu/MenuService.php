<?php

namespace App\Services\Dashboard\Menu;

use App\Helper\Media;
use App\Models\Dashboard\Menu\Menu;
use Illuminate\Support\Facades\DB;

class MenuService
{
    public function index()
    {
        return Menu::all();
    }
    public function create()
    {
        return Menu::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
            ];

            $menu = Menu::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $menu->handleTranslations(
                $dataValidated,
                ['name'], // custom fields
                false // auto-generate slug
            );

            DB::commit();

            return $menu;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $menu){
        DB::beginTransaction();

        try {
            // Update the chapter data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
            ];

            // Update the chapter with the new validated data
            $menu->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $menu->handleTranslations(
                $dataValidated,
                ['name'], // custom fields
                false // auto-generate slug
            );

            DB::commit();

            return $menu;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function deleteMenu($selectedId){
        DB::beginTransaction();
        try {

            $deleted = Menu::where('id', $selectedId)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
