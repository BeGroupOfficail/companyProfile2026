<?php

namespace App\Services\Dashboard\Menu;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Menu\Menu;
use App\Models\Dashboard\Menu\MenuItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class MenuItemService
{
    public function index()
    {
        return MenuItem::all();
    }
    public function create()
    {
        $menus = Menu::select('id','name')->get();
        $menuType = MenuItem::MENUTPES;
        $menuItems= MenuItem::select('id','name')->get();
        return [$menus,$menuType,$menuItems];
    }

    public function edit($menuItem)
    {
        $menus = Menu::select('id','name')->get();
        $menuTypes = MenuItem::MENUTPES;
        $type = $menuItem->types;
        $menuItems= MenuItem::where('id','!=',$menuItem->id)->select('id','name')->get();
        return [$menus,$menuTypes,$type,$menuItems];
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'menu_id' => $dataValidated['menu_id'],
                'parent_id' => $dataValidated['parent_id'],
                'order' => $dataValidated['order'],
                'types' => $dataValidated['types'],
                'type_value_id' => $dataValidated['type_value_id']??null,
                'link' => $dataValidated['link']??null,
            ];

            $menuItem = MenuItem::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $menuItem->handleTranslations(
                $dataValidated,
                ['name'], // custom fields
                false // auto-generate slug
            );


            DB::commit();

            return $menuItem;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $menuItem){
        DB::beginTransaction();

        try {
            // Update the chapter data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'menu_id' => $dataValidated['menu_id'],
                'parent_id' => $dataValidated['parent_id'],
                'order' => $dataValidated['order'],
                'types' => $dataValidated['types'],
                'type_value_id' => $dataValidated['type_value_id']??null,
                'link' => $dataValidated['link']??null,
            ];

            // Update the chapter with the new validated data
            $menuItem->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $menuItem->handleTranslations(
                $dataValidated,
                ['name'], // custom fields
                false // auto-generate slug
            );

            DB::commit();

            return $menuItem;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function deleteMenuItem($selectedId){
        DB::beginTransaction();
        try {

            $deleted = SoftDeleteHelper::deleteWithEvents(MenuItem::class, $selectedId);
            Cache::forget('head_menu');
            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
