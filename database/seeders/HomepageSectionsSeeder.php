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
                    'en' => 'sliders',
                    'ar' => ' شرائح العرض',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '2',
                'title' => [
                    'en' => 'about',
                    'ar' => 'عن الموقع',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '3',
                'title' => [
                    'en' => 'services',
                    'ar' => 'الخدمات',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],

            [
                'order' => '4',
                'title' => [
                    'en' => 'projects',
                    'ar' => 'المشاريع',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '5',
                'title' => [
                    'en' => 'our_speciality',
                    'ar' => 'تخصصاتنا',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '6',
                'title' => [
                    'en' => 'statistics',
                    'ar' => 'الاحصائيات والارقام',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],
            [
                'order' => '7',
                'title' => [
                    'en' => 'clients',
                    'ar' => 'العملاء',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],

            [
                'order' => '8',
                'title' => [
                    'en' => 'blogs',
                    'ar' => 'المقالات',
                ],
                'image' => '',
                'alt_image' => '',
                'is_active' => true,
            ],

            [
                'order' => '9',
                'title' => [
                    'en' => 'contact_us',
                    'ar' => 'تواصل معنا',
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
