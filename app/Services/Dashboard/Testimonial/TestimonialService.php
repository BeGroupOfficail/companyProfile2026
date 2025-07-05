<?php

namespace App\Services\Dashboard\Testimonial;

use App\Helper\Media;
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

    public function deleteTestimonials($selectedIds){
        $testimonials = Testimonial::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($testimonials as $testimonial) {
                // Delete associated image if it exists
                if ($testimonial->image) {
                    Media::removeFile('testimonials', $testimonial->image);
                }
            }
            $deleted = Testimonial::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

}
