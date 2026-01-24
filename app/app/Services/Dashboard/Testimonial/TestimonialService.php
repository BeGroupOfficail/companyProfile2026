<?php

namespace App\Services\Dashboard\Testimonial;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Testimonial\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialService
{
    public function index()
    {
        return Testimonial::all();
    }
    public function create()
    {
        return Testimonial::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'author_name' => $dataValidated['author_name'],
                'author_title' => $dataValidated['author_title'],
                'company' => $dataValidated['company'],
                'rate' => $dataValidated['rate'],
            ];

            $testimonial = Testimonial::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $testimonial->handleTranslations(
                $dataValidated,
                ['title', 'text'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $testimonial->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'testimonials', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $testimonial;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $testimonial){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'author_name' => $dataValidated['author_name'],
                'author_title' => $dataValidated['author_title'],
                'company' => $dataValidated['company'],
                'rate' => $dataValidated['rate'],
            ];

            // Update the category with the new validated data
            $testimonial->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $testimonial->handleTranslations(
                $dataValidated,
                ['title', 'text'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $testimonial->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'testimonials', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $testimonial;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteTestimonials($selectedIds)
    {
        DB::beginTransaction();
        try {
            $trashedTestimonials = Testimonial::onlyTrashed()->whereIn('id', $selectedIds)->get();
            $activeTestimonials = Testimonial::whereIn('id', $selectedIds)->get();
            
            if ($trashedTestimonials->isNotEmpty()) {
                foreach ($trashedTestimonials as $testimonial) {
                    if ($testimonial->image) {
                        Media::removeFile('testimonials', $testimonial->image);
                    }
                }
                Testimonial::onlyTrashed()->whereIn('id', $trashedTestimonials->pluck('id'))->forceDelete();
            }
            
            if ($activeTestimonials->isNotEmpty()) {
                SoftDeleteHelper::deleteWithEvents(Testimonial::class, $activeTestimonials->pluck('id')->toArray());
            }
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
