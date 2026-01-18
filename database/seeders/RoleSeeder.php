<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin role
        $role = Role::updateOrCreate(['name' => 'Super Admin','guard_name'=>'web']);

        // sync all permission to super admin role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
}
