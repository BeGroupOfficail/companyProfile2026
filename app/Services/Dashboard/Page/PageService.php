<?php

namespace App\Services\Dashboard\Page;

use App\Helper\Media;
use App\Models\Dashboard\Page\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageService
{
    public function index()
    {
        return Page::all();
    }
    public function create()
    {
        return Page::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
            ];

            $page = Page::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $page->handleTranslations(
                $dataValidated,
                ['name','slug','short_desc','long_text'], // custom fields
                true // auto-generate slug
            );

            DB::commit();

            return $page;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $page){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'index' => $dataValidated['index']?? 0,
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
            ];

            // Update the category with the new validated data
            $page->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $page->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc','long_text'], // custom fields
                true // auto-generate slug
            );

            DB::commit();

            return $page;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletePages($selectedIds)
{
    DB::beginTransaction();
    try {
        // Get trashed pages for permanent deletion
        $trashedPages = Page::onlyTrashed()->whereIn('id', $selectedIds)->get();

        // Get active pages for soft deletion
        $activePages = Page::whereIn('id', $selectedIds)->get();

        // Handle permanently deleting trashed pages
        if ($trashedPages->isNotEmpty()) {
            Page::onlyTrashed()
                ->whereIn('id', $trashedPages->pluck('id'))
                ->forceDelete();
        }


        DB::commit();
        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        return false;
    }
}
}
