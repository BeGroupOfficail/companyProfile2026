<?php

namespace App\Services\Dashboard\BlogCategory;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Blog\BlogCategory;
use Illuminate\Support\Facades\DB;

class BlogCategoryService
{
    public function index()
    {
        return BlogCategory::all();
    }
    public function create()
    {
        return BlogCategory::all();
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

            $blogCategory = BlogCategory::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $blogCategory->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc','long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $blogCategory->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'blog_categories', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $blogCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $blogCategory){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
            ];

            // Update the category with the new validated data
            $blogCategory->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $blogCategory->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc','long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $blogCategory->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'blog_categories', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $blogCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteBlogCategories($selectedIds){
        $blogCategories = BlogCategory::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($blogCategories as $blogCategory) {
                // Delete associated image if it exists
                if ($blogCategory->image) {
                    Media::removeFile('blog_categories', $blogCategory->image);
                }
            }
            $deleted = SoftDeleteHelper::deleteWithEvents(BlogCategory::class, $selectedIds);

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
