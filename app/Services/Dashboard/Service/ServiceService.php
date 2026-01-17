<?php

namespace App\Services\Dashboard\Service;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Service\Service;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    public function create()
    {
        $service_parents = Service::where('parent_id', null)->select('id', 'name')->get();
        return $service_parents;
    }

    public function edit($service)
    {
        $serviceCategories = Service::whereNot('id', $service->id)->where('parent_id', null)->select('id', 'name')->get();
        return $serviceCategories;
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'parent_id' => data_get($dataValidated, 'parent_id'),
                'status' => data_get($dataValidated, 'status'),
                'home' => data_get($dataValidated, 'home', 0),
                'menu' => data_get($dataValidated, 'menu', 0),
                'index' => data_get($dataValidated, 'index', 0),
            ];

            $service = Service::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $service->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'short_desc', 'long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $service->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'services', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $service;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, Service $service)
    {
        // dd($dataValidated);
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'parent_id' => data_get($dataValidated, 'parent_id'),
                'status' => data_get($dataValidated, 'status'),
                'home' => data_get($dataValidated, 'home', 0),
                'menu' => data_get($dataValidated, 'menu', 0),
                'index' => data_get($dataValidated, 'index', 0),
                'alt_image' => data_get($dataValidated, 'alt_image'),

            ];


            // Update the category with the new validated data
            $service->update($data);
            // dd($service);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $service->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'short_desc', 'long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $service->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'services', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );
            DB::commit();

            return $service;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteServices($selectedIds)
    {
        DB::beginTransaction();
        try {
            $trashedServices = Service::onlyTrashed()->whereIn('id', $selectedIds)->get();
            $activeServices = Service::whereIn('id', $selectedIds)->get();

            if ($trashedServices->isNotEmpty()) {
                foreach ($trashedServices as $service) {
                    if ($service->image) {
                        Media::removeFile('services', $service->image);
                    }
                }
                Service::onlyTrashed()
                    ->whereIn('id', $trashedServices->pluck('id'))
                    ->forceDelete();
            }
            if ($activeServices->isNotEmpty()) {
                SoftDeleteHelper::deleteWithEvents(Service::class, $activeServices->pluck('id')->toArray());
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
