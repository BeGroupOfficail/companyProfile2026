<?php

namespace App\Services\Dashboard\User;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function index()
    {
        return Role::all();
    }
    public function create()
    {
        return Role::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Create the new role
            $role = Role::create(['name' => $dataValidated['name']]);

            // Attach permissions to the newly created role
            $role->givePermissionTo($dataValidated['permissions']);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $role){
        DB::beginTransaction();

        try {
            $role->update($dataValidated);

            $rolePermissions= $role->permissions()->get();
            foreach($rolePermissions as $rolePermission){
                $role->revokePermissionTo($rolePermission);
            }

            $role->syncPermissions($dataValidated['permissions']);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteRole($selectedId){
        DB::beginTransaction();
        try {

            $deleted = Role::where('id', $selectedId)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
