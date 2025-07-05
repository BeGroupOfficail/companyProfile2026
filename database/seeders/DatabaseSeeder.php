<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SettingSeeder::class,
            MenuSeeder::class,
            MenuItemSeeder::class,
            WebsiteDesignSeeder::class,
            HomepageSectionsSeeder::class,
            AboutUsSeeder::class,
            AboutValuesSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            SeoTableSeeder::class,
        ]);

        $user = User::updateOrcreate([
            'email' => 'super.admin@system.com',
            'phone' => '9665123456789',
        ],[
            'f_name' => 'Super',
            'l_name' => 'Admin',
            'password' => bcrypt('admin100200??'),
            'is_admin' => true,
            'status' => 'active',
            'job_role' => 'super_admin',
        ]);
        $user->syncRoles('Super Admin');

    }
}
