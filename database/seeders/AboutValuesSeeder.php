<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AboutValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $records = [
            [
                'title' => [
                    'en' => 'Our Mission',
                    'ar' => 'مهمتنا',
                ],
                'description' => [
                    'en' => 'To empower communities through innovative solutions and sustainable practices.',
                    'ar' => 'تمكين المجتمعات من خلال حلول مبتكرة وممارسات مستدامة.',
                ],
                'type' => 'mission_and_vision',
                'image' => null,
                'alt_image' => null,
                'icon' => null,
                'alt_icon' => null,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => [
                    'en' => 'Our Vision',
                    'ar' => 'رؤيتنا',
                ],
                'description' => [
                    'en' => 'A world where innovation drives progress and equality for all.',
                    'ar' => 'عالم تتحرك فيه الابتكار نحو التقدم والمساواة للجميع.',
                ],
                'type' => 'mission_and_vision',
                'image' => null,
                'alt_image' => null,
                'icon' => null,
                'alt_icon' => null,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => [
                    'en' => 'Our Goals',
                    'ar' => 'أهدافنا',
                ],
                'description' => [
                    'en' => 'To achieve sustainability, global impact, and community empowerment by 2030.',
                    'ar' => 'تحقيق الاستدامة والتأثير العالمي وتمكين المجتمع بحلول عام 2030.',
                ],
                'type' => 'mission_and_vision',
                'image' => null,
                'alt_image' => null,
                'icon' => null,
                'alt_icon' => null,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($records as $record) {
            // First check if a record exists with this English title
            $exists = DB::table('about_values')
                ->whereRaw("JSON_EXTRACT(title, '$.en') = ?", [$record['title']['en']])
                ->exists();

            if ($exists) {
                DB::table('about_values')
                    ->whereRaw("JSON_EXTRACT(title, '$.en') = ?", [$record['title']['en']])
                    ->update([
                        'title' => json_encode($record['title']),
                        'description' => json_encode($record['description']),
                        'type' => $record['type'],
                        'image' => $record['image'],
                        'alt_image' => $record['alt_image'],
                        'icon' => $record['icon'],
                        'alt_icon' => $record['alt_icon'],
                        'status' => $record['status'],
                        'updated_at' => $now,
                    ]);
            } else {
                DB::table('about_values')->insert([
                    'title' => json_encode($record['title']),
                    'description' => json_encode($record['description']),
                    'type' => $record['type'],
                    'image' => $record['image'],
                    'alt_image' => $record['alt_image'],
                    'icon' => $record['icon'],
                    'alt_icon' => $record['alt_icon'],
                    'status' => $record['status'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
