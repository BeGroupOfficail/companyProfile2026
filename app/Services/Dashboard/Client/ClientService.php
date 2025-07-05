<?php

namespace App\Services\Dashboard\Client;

use App\Helper\Media;
use App\Models\Dashboard\Client\Client;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function index()
    {
        return Client::all();
    }
    public function create()
    {
        $types = Client::TYPES;
        return $types;
    }

    public function edit($client)
    {
        $types = Client::TYPES;
        return $types;
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'types' => $dataValidated['types'],
            ];

            $client = Client::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $client->handleTranslations(
                $dataValidated,
                ['name', 'desc'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $client->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'clients', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $client){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'types' => $dataValidated['types'],
            ];

            // Update the category with the new validated data
            $client->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $client->handleTranslations(
                $dataValidated,
                ['name', 'desc'], // custom fields
                false // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $client->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'clients', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteClients($selectedIds){
        $clients = Client::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($clients as $client) {
                // Delete associated image if it exists
                if ($client->image) {
                    Media::removeFile('clients', $client->image);
                }
            }
            $deleted = Client::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
