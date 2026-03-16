<?php

namespace App\Services\Dashboard\User;

use App\Helper\Media;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserService
{
    public function index()
    {
        return User::all();
    }
    public function create()
    {
        $job_roles = User::JOBRoles;
        $roles = Role::where('id', '!=', 1)->pluck('name', 'name')->toarray();
        return [$job_roles, $roles];
    }

    public function edit($user)
    {
        $job_roles = User::JOBRoles;
        $roles = Role::where('id', '!=', 1)->pluck('name', 'name')->toarray();
        $userRoles = $user->roles()->pluck('name')->toArray();
        ;
        return [$job_roles, $roles, $userRoles];
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        $userData = $dataValidated;
        unset($userData['roles']);

        try {
            $user = User::create($userData);
            $user->email_verified_at =  now();
            $user->phone_verified_at =  now();
            $user->save();

            // Handle media uploads (icon and image)
            $user->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'users', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            if (isset($dataValidated['roles'])) {
                // Assign roles to user
                $user->syncRoles($dataValidated['roles']);
            }

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $user)
    {
        DB::beginTransaction();

        try {
            $userData = $dataValidated;
            unset($userData['roles']);

            // Remove password if it's empty or null
            if (empty($userData['password'])) {
                unset($userData['password']);
            }

            $user->update($userData);
            $user->handleMedia(
                request(), // Pass the current request
                $userData, // Use filtered userData instead of dataValidated
                'users', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            if ($user->is_admin == 1 && isset($dataValidated['roles'])) {
                // rmv role the assign new
                $user->syncRoles([]);
                $user->syncRoles($dataValidated['roles']);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function deleteUsers($selectedIds)
    {
        DB::beginTransaction();
        try {
            $trashedUsers = User::onlyTrashed()->whereIn('id', $selectedIds)->get();
            $activeUsers = User::whereIn('id', $selectedIds)->get();

            // Handle permanently deleting already soft-deleted users
            if ($trashedUsers->isNotEmpty()) {
                foreach ($trashedUsers as $user) {
                    if ($user->image) {
                        Media::removeFile('users', $user->image);
                    }
                }
                User::onlyTrashed()->whereIn('id', $trashedUsers->pluck('id'))->forceDelete();
            }

            // Handle soft deleting active users
            if ($activeUsers->isNotEmpty()) {
                SoftDeleteHelper::deleteWithEvents(User::class, $activeUsers->pluck('id')->toArray());
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
