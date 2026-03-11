<?php

namespace App\Services\Dashboard\Section;

use App\Models\Dashboard\Sections\CompanySubSectionItem;
use Illuminate\Support\Facades\DB;

class SubSectionItemService
{
    public function index()
    {
        return CompanySubSectionItem::all();
    }
    
    public function create()
    {
        return CompanySubSectionItem::all();
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            $data = [
                'sub_section_id' => $dataValidated['sub_section_id'],
                'sort_order' => $dataValidated['sort_order'],
            ];

            $item = CompanySubSectionItem::create($data);

            $item->handleTranslations(
                $dataValidated,
                ['title', 'description'],
                false
            );

            DB::commit();

            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $item)
    {
        DB::beginTransaction();

        try {
            $data = [
                'sub_section_id' => $dataValidated['sub_section_id'],
                'sort_order' => $dataValidated['sort_order'],
            ];

            $item->update($data);

            $item->handleTranslations(
                $dataValidated,
                ['title', 'description'],
                false
            );

            DB::commit();

            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteItem($selectedIds)
    {
        DB::beginTransaction();
        try {
            $deleted = CompanySubSectionItem::whereIn('id', (array)$selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
