<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\Setting\HomepageSection;

class HomepageSectionsSeeder extends Seeder
{
    public function run()
    {

        $sections = [
            [
                'order' => '1',
                'title' => [
                    'en' => 'slidersSection',
                    'ar' => ' شرائح العرض',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '2',
                'title' => [
                    'en' => 'aboutSection',
                    'ar' => 'عن الموقع',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '3',
                'title' => [
                    'en' => 'servicesSection',
                    'ar' => 'الخدمات',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '4',
                'title' => [
                    'en' => 'popularToursSection',
                    'ar' => 'الرحلات الاكثر شهرة',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '5',
                'title' => [
                    'en' => 'offersSection',
                    'ar' => 'عروض الرحلات',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '6',
                'title' => [
                    'en' => 'howItWorksSection',
                    'ar' => 'كيف يعمل',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '7',
                'title' => [
                    'en' => 'whyChooseUsSection',
                    'ar' => 'لماذا تختارنا',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '8',
                'title' => [
                    'en' => 'blogsSection',
                    'ar' => 'المقالات',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '9',
                'title' => [
                    'en' => 'instagramSection',
                    'ar' => 'الانستجرام',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],

            [
                'order' => '10',
                'title' => [
                    'en' => 'popularDestinationSection',
                    'ar' => 'افضل الوجهات',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],

            [
                'order' => '11',
                'title' => [
                    'en' => 'numbersSection',
                    'ar' => 'الاحصائيات والارقام',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],




        ];

        foreach ($sections as $section) {
            HomepageSection::updateOrCreate(
                [
                    'title' => $section['title']
                ],
                [
                    'order' => $section['order'],
                    'image' => $section['image'],
                    'alt_image' => $section['alt_image'],
                    'is_active' => $section['is_active'],
                ]
            );
        }
    }
}
