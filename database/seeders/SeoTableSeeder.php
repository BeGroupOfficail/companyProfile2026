<?php

namespace Database\Seeders;

use App\Models\Dashboard\Seo\Seo;
use Illuminate\Database\Seeder;

class SeoTableSeeder extends Seeder
{
    public function run()
    {
        $pageTypes = Seo::PAGETYPES;

        $defaultMetaData = [
            'meta_title' => [
                'en' => 'Default Page Title',
                'ar' => 'عنوان الصفحة الافتراضي'
            ],
            'meta_desc' => [
                'en' => 'Default page description',
                'ar' => 'وصف الصفحة الافتراضي'
            ],
        ];

        // Custom metadata for specific page types
        $customMetaData = [
            "home" => [
                'meta_title' => ['en' => 'Home Page', 'ar' => 'الصفحة الرئيسية'],
                'meta_desc' => ['en' => 'Welcome to our website', 'ar' => 'مرحبًا بكم في موقعنا'],
            ],
            "about-us" => [
                'meta_title' => ['en' => 'About Us', 'ar' => 'معلومات عنا'],
                'meta_desc' => ['en' => 'Learn more about our company', 'ar' => 'تعرف على المزيد عن شركتنا'],
            ],
            "contact-us" => [
                'meta_title' => ['en' => 'Contact Us', 'ar' => 'اتصل بنا'],
                'meta_desc' => ['en' => 'Get in touch with our team', 'ar' => 'تواصل مع فريقنا'],
            ],
            'courses' => [
                'meta_title' => ['en' => 'Our Courses', 'ar' => 'دوراتنا'],
                'meta_desc' => ['en' => 'Browse our available courses', 'ar' => 'تصفح الدورات المتاحة لدينا'],
            ],
        ];

        foreach ($pageTypes as $key => $pageType) {
            $data = $customMetaData[$key] ?? $defaultMetaData;

            Seo::updateOrCreate(
                ['page_type' => $key],
                [
                    'schema_types' => null,
                    'meta_title' => $data['meta_title'],
                    'meta_desc' => $data['meta_desc'],
                    'index' => true,
                ]
            );
        }
    }
}
