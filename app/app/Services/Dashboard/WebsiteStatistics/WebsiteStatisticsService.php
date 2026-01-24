<?php

namespace App\Services\Dashboard\WebsiteStatistics;

use App\Helper\Media;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use Illuminate\Support\Facades\DB;

class WebsiteStatisticsService
{
    public function index()
    {
        return WebsiteStatistics::all();
    }
    public function create()
    {
        return WebsiteStatistics::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'count' => $dataValidated['count'],
            ];

            $websiteStatistic = WebsiteStatistics::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $websiteStatistic->handleTranslations(
                $dataValidated,
                ['title'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $websiteStatistic->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'websiteStatistic', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $websiteStatistic;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $websiteStatistic){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'count' => $dataValidated['count'],
            ];

            // Update the category with the new validated data
            $websiteStatistic->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $websiteStatistic->handleTranslations(
                $dataValidated,
                ['title'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $websiteStatistic->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'websiteStatistic', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $websiteStatistic;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteWebsiteStatistics($selectedIds){
        DB::beginTransaction();
        try {
            $deleted = WebsiteStatistics::whereIn('id', $selectedIds)->delete();
            DB::commit();
            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
