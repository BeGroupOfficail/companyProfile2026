<?php

namespace App\Services\Dashboard\User;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function index()
    {
        return Permission::all();
    }
    public function create()
    {
        return Permission::all();
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {

            $basePermissionName = $dataValidated['name'];

            $basePermission = Permission::create(['name' => $basePermissionName]);

            // Create the sub-permissions (read, write, update, delete)
            $permissions = ['read', 'create', 'update', 'delete'];

            foreach ($permissions as $permission) {
                // Create the full permission name, e.g., 'added.read', 'added.write'
                Permission::create(['name' => $basePermissionName . '.' . $permission]);
            }

            DB::commit();

            return $permission;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $permission)
    {
        DB::beginTransaction();

        try {
            // Step 1: Get the old base permission name
            $oldBasePermissionName = $permission->name; // Old base permission name (e.g., 'added')

            // Step 2: Get the new base permission name from validated data (e.g., 'new_added')
            $basePermissionName = $dataValidated['name']; // New base permission name from the request

            // Step 3: Handle sub-permissions (read, create, update, delete)
            $permissions = ['read', 'create', 'update', 'delete'];

            // Loop through each sub-permission and update it
            foreach ($permissions as $subPermission) {
                // Construct the old sub-permission name (e.g., 'added.read' -> 'new_added.read')
                $oldSubPermissionName = $oldBasePermissionName . '.' . $subPermission;
                $newSubPermissionName = $basePermissionName . '.' . $subPermission;

                // Check if the old sub-permission exists
                $subPermissionObj = Permission::where('name', $oldSubPermissionName)->first();

                // If the sub-permission exists, update it with the new base permission name
                if ($subPermissionObj) {
                    // Update the sub-permission to reflect the new base permission name
                    $subPermissionObj->update(['name' => $newSubPermissionName]);
                }
            }

            // Step 4: After updating sub-permissions, update the base permission name
            $permission->update(['name' => $basePermissionName]);

            // Commit the transaction after all updates
            DB::commit();

            // Return the updated base permission object
            return $permission;
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();

            // Re-throw the exception to handle it appropriately in the calling code
            throw $e;
        }
    }



    public function deletePermissions($selectedIds){
        DB::beginTransaction();
        try {

            $deleted = Permission::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
