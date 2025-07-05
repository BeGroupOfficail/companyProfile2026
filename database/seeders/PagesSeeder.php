<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $pages = [
            [
                'slug' => 'privacy_policy',
                'name' => [
                    'en' => 'Privacy Policy',
                    'ar' => 'سياسة الخصوصية',
                ],
                'short_desc' => [
                    'en' => 'Our privacy policy explains how we handle your data.',
                    'ar' => 'توضح سياسة الخصوصية كيفية تعاملنا مع بياناتك.',
                ],
                'long_text' => [
                    'en' => '<p>This is the detailed privacy policy content in English.</p>',
                    'ar' => '<p>هذا هو محتوى سياسة الخصوصية المفصل باللغة العربية.</p>',
                ],
                'status' => 'published',
                'slug' => [
                    'en' => 'privacy-policy',
                    'ar' => 'سياسة-الخصوصية',
                ],
                'meta_title' => [
                    'en' => 'Privacy Policy - YourSite',
                    'ar' => 'سياسة الخصوصية - موقعك',
                ],
                'meta_desc' => [
                    'en' => 'Read our privacy policy to understand how we protect your data.',
                    'ar' => 'اقرأ سياسة الخصوصية لفهم كيفية حماية بياناتك.',
                ],
                'index' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'terms_and_conditions',
                'name' => [
                    'en' => 'Terms and Conditions',
                    'ar' => 'الشروط والأحكام',
                ],
                'short_desc' => [
                    'en' => 'Terms and conditions for using our website.',
                    'ar' => 'الشروط والأحكام لاستخدام موقعنا.',
                ],
                'long_text' => [
                    'en' => '<p>This is the detailed terms and conditions content in English.</p>',
                    'ar' => '<p>هذا هو محتوى الشروط والأحكام المفصل باللغة العربية.</p>',
                ],
                'status' => 'published',
                'slug' => [
                    'en' => 'terms-and-conditions',
                    'ar' => 'الشروط-والأحكام',
                ],
                'meta_title' => [
                    'en' => 'Terms and Conditions - YourSite',
                    'ar' => 'الشروط والأحكام - موقعك',
                ],
                'meta_desc' => [
                    'en' => 'Read the terms and conditions carefully before using our services.',
                    'ar' => 'اقرأ الشروط والأحكام بعناية قبل استخدام خدماتنا.',
                ],
                'index' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($pages as $page) {
            $page['name'] = json_encode($page['name']);
            $page['short_desc'] = json_encode($page['short_desc']);
            $page['long_text'] = json_encode($page['long_text']);
            $page['meta_title'] = json_encode($page['meta_title']);
            $page['meta_desc'] = json_encode($page['meta_desc']);
            $page['slug'] = json_encode($page['slug']);

            $slug_en = json_decode($page['slug'], true)['en'] ?? null;

            DB::table('pages')->updateOrInsert(
                ['slug' => $slug_en], // شرط البحث نصي صالح
                $page
            );
        }
    }
}
