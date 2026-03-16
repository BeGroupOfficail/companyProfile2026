<?php

namespace App\Services\Dashboard\Project;

use App\Helper\Media;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Project\ProjectImage;
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

            // 1. Create Project
            $project = Project::create($data);

            // 2. Handle translations
            $project->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc', 'long_desc', 'type', 'location', 'area', 'client', 'badges'], // custom fields
                true // auto-generate slug
            );

            // 3. Handle Media (Trait only)
            // Note: We removed 'image' from here as it's now handled by gallery logic
            $project->handleMedia(
                request(),
                $dataValidated,
                'projects',
                [] // No single image field anymore
            );

            // 4. Handle Gallery Images
            if (isset($dataValidated['images'])) {
                foreach ($dataValidated['images'] as $index => $imageFile) {
                    $imageName = Media::storeImage($imageFile, 'projects');
                    if ($imageName) {
                        $project->images()->create([
                            'image' => $imageName,
                            'sort_order' => $index,
                        ]);
                        
                        // Set the first image as the main project image for backward compatibility
                        if ($index === 0) {
                            $project->update(['image' => $imageName]);
                        }
                    }
                }
            }

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

            // Handle translations
            $project->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc', 'long_desc', 'type', 'location', 'area', 'client', 'badges'],
                true
            );

            // Handle media (Trait) - excludes 'image'
            $project->handleMedia(
                request(),
                $dataValidated,
                'projects',
                []
            );

            // Handle Gallery Deletions
            if (!empty($dataValidated['delete_images'])) {
                $imagesToDelete = ProjectImage::whereIn('id', $dataValidated['delete_images'])
                                              ->where('project_id', $project->id)
                                              ->get();

                foreach ($imagesToDelete as $img) {
                    Media::removeFile('projects', $img->image);
                    $img->delete();
                }
            }

            // Handle New Gallery Images
            $newImagesCount = 0;
            if (isset($dataValidated['images'])) {
                foreach ($dataValidated['images'] as $imageFile) {
                    $imageName = Media::storeImage($imageFile, 'projects');
                    if ($imageName) {
                        // Get max sort order to append correctly
                        $maxSort = $project->images()->max('sort_order') ?? 0;
                        $project->images()->create([
                            'image' => $imageName,
                            'sort_order' => $maxSort + 1,
                        ]);
                        $newImagesCount++;
                    }
                }
            }
            
            // Failsafe: Ensure at least one image exists
            if ($project->images()->count() === 0) {
                 throw new \Exception(__('dash.The project must have at least one image.'));
            }

            // Sync main image with the first gallery image if current main image is missing or invalid
            // Or just always sync to the first available gallery image
            $firstImage = $project->images()->orderBy('sort_order')->orderBy('id')->first();
            if ($firstImage) {
                 $project->update(['image' => $firstImage->image]);
            } else {
                 // This should be unreachable due to exception above, but good for type safety
                 $project->update(['image' => null]); 
            }

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
            
            if ($trashedProjects->isNotEmpty()) {
                foreach ($trashedProjects as $project) {
                    // Delete Gallery Images
                    foreach ($project->images as $image) {
                        Media::removeFile('projects', $image->image);
                        $image->delete();
                    }
                    
                    // Delete Main Image if different (though it should be one of them)
                    if ($project->image) {
                        Media::removeFile('projects', $project->image);
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
