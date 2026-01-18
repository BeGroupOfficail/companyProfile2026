<?php

namespace App\Services\Dashboard\Project;

use App\Helper\Media;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Service\Service;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    public function create()
    {
        $servics = Service::select('id', 'name')->get();
        return $servics;
    }

    public function edit($project)
    {
        $services = Service::select('id', 'name')->get();
        return $services;
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'service_id' => data_get($dataValidated, 'service_id'),
                'status' => data_get($dataValidated, 'status'),
                'home' => data_get($dataValidated, 'home', 0),
                'menu' => data_get($dataValidated, 'menu', 0),
            ];

            $project = Project::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $project->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc', 'long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $project->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'projects', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, Project $project)
    {
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'service_id' => data_get($dataValidated, 'service_id'),
                'status' => data_get($dataValidated, 'status'),
                'home' => data_get($dataValidated, 'home', 0),
                'menu' => data_get($dataValidated, 'menu', 0),
                'alt_image' => data_get($dataValidated, 'alt_image'),
            ];

            // Update the category with the new validated data
            $project->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $project->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc', 'long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $project->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'projects', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );
            DB::commit();

            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProjects($selectedIds)
    {
        DB::beginTransaction();
        try {
            $trashedProjects = Project::onlyTrashed()->whereIn('id', $selectedIds)->get();
            $activeProjects = Project::whereIn('id', $selectedIds)->get();

            if ($trashedProjects->isNotEmpty()) {
                foreach ($trashedProjects as $service) {
                    if ($service->image) {
                        Media::removeFile('projects', $service->image);
                    }
                }
                Project::onlyTrashed()
                    ->whereIn('id', $trashedProjects->pluck('id'))
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
