<?php

namespace App\Services\Dashboard\Section;

use App\Models\Dashboard\Sections\CompanySection;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public function index()
    {
        return CompanySection::all();
    }
    
    public function create()
    {
        return CompanySection::all();
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            $data = [
                'key' => $dataValidated['key'],
                'is_active' => $dataValidated['is_active'],
                'sort_order' => $dataValidated['sort_order'],
            ];

            $section = CompanySection::create($data);

            $section->handleTranslations(
                $dataValidated,
                ['title', 'description'],
                false
            );

            DB::commit();

            return $section;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $section)
    {
        DB::beginTransaction();

        try {
            $data = [
                'key' => $dataValidated['key'],
                'is_active' => $dataValidated['is_active'],
                'sort_order' => $dataValidated['sort_order'],
            ];

            $section->update($data);

            $section->handleTranslations(
                $dataValidated,
                ['title', 'description'],
                false
            );

            DB::commit();

            return $section;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteSection($selectedIds)
    {
        DB::beginTransaction();
        try {
            $deleted = CompanySection::whereIn('id', (array)$selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
