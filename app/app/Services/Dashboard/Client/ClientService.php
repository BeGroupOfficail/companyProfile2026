<?php

namespace App\Services\Dashboard\Client;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
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
                'home' => $dataValidated['home'],
                'types' => $dataValidated['types'],
                'link' => $dataValidated['link'],
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
                'home' => $dataValidated['home'],
                'types' => $dataValidated['types'],
                'link' => $dataValidated['link'],
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

    public function deleteClients($selectedIds)
    {
        DB::beginTransaction();
        try {
            $trashedClients = Client::onlyTrashed()->whereIn('id', $selectedIds)->get();
            $activeClients = Client::whereIn('id', $selectedIds)->get();

            // Handle trashed clients - hard delete
            if ($trashedClients->isNotEmpty()) {
                foreach ($trashedClients as $client) {
                    if ($client->image) {
                        Media::removeFile('clients', $client->image);
                    }
                }
                Client::onlyTrashed()
                    ->whereIn('id', $trashedClients->pluck('id'))
                    ->forceDelete();
            }

            // Handle active clients - soft delete
            if ($activeClients->isNotEmpty()) {
                foreach ($activeClients as $client) {
                    if ($client->image) {
                        Media::removeFile('clients', $client->image);
                    }
                }
                SoftDeleteHelper::deleteWithEvents(Client::class, $activeClients->pluck('id')->toArray());
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
