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
            'questions',
            'menus',
            'menu_items',
            'about_us',
            'about_values',
            'albums',
            'sliders',
            'pages',
            'services',
            'blogs',
            'blog_categories',
            'clients',
            'testimonials',
            'faqs',
            'seo',
            'settings',
            'countries',
            'regions',
            'areas',
            'general_settings',
            'website_designs',
            'messages',
            'users',
            'permissions',
            'roles',
            'destinations',
            'tours',

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
