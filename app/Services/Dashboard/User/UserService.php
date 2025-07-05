<?php

namespace App\Services\Dashboard\User;

use App\Helper\Media;
use App\Models\Dashboard\Category;
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
        $job_roles= User::JOBRoles;
        $roles = Role::where('id','!=',1)->pluck('name','name')->toarray();
        return  [$job_roles,$roles];
    }

    public function edit($user)
    {
        $job_roles= User::JOBRoles;
        $roles = Role::where('id','!=',1)->pluck('name','name')->toarray();
        $userRoles =$user->roles()->pluck('name')->toArray();;
        return  [$job_roles,$roles,$userRoles];
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        $userData = $dataValidated;
        unset($userData['roles']);

        try {
            $user = User::create($userData);

            // Handle media uploads (icon and image)
            $user->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'users', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            if($user->job_role == 'admin' && isset($dataValidated['roles']) ){
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

            $user->update($userData);

            if($user->job_role == 'admin' && isset($dataValidated['roles']) ){
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
        $users = User::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($users as $user) {
                // Delete associated image if it exists
                if ($user->image) {
                    Media::removeFile('users', $user->image);
                }
            }
            $deleted = user::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
