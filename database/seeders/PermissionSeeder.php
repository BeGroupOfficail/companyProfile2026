<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'contact_us',
            'menus',
            'menu_items',
            'about_us',
            'about_values',
            'albums',
            'sliders',
            'pages',
            'services',
            'projects',
            'blogs',
            'blog_categories',
            'clients',
            'testimonials',
            'seo',
            'settings',
            'general_settings',
            'website_statistics',
            'messages',
            'users',
            'permissions',
            'roles',
        ];

        $actions = ['read', 'create', 'update', 'delete'];

        foreach ($models as $model) {
            // Create base permission (e.g., 'user')
            Permission::firstOrCreate(['name' => $model]);

            // Create CRUD permissions (e.g., 'user.read', 'user.create', etc.)
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$model}.{$action}"]);
            }
        }
    }
}
