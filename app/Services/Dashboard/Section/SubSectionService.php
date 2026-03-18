<?php

namespace App\Services\Dashboard\Section;

use App\Models\Dashboard\Sections\CompanySubSection;
use Illuminate\Support\Facades\DB;

class SubSectionService
{
    public function index()
    {
        return CompanySubSection::all();
    }
    
    public function create()
    {
        return CompanySubSection::all();
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            $data = [
                // 'section_id' => $dataValidated['section_id'],
                'layout' => $dataValidated['layout'],
                'sort_order' => $dataValidated['sort_order'],
                'key' => $dataValidated['key'],
            ];

            $subSection = CompanySubSection::create($data);

            $subSection->handleTranslations(
                $dataValidated,
                ['title', 'description'],
                false
            );

            DB::commit();

            return $subSection;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $subSection)
    {
        DB::beginTransaction();

        try {
            $data = [
                // 'section_id' => $dataValidated['section_id'],
                'layout' => $dataValidated['layout'],
                'sort_order' => $dataValidated['sort_order'],
                'key' => $dataValidated['key'],
            ];

            $subSection->update($data);

            $subSection->handleTranslations(
                $dataValidated,
                ['title', 'description'],
                false
            );

            DB::commit();

            return $subSection;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteSubSection($selectedIds)
    {
        DB::beginTransaction();
        try {
            $deleted = CompanySubSection::whereIn('id', (array)$selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
