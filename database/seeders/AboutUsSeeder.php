<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Using updateOrInsert (DB facade equivalent of Eloquent's updateOrCreate)
        DB::table('about_us')->updateOrInsert(
            ['id' => 1], // Assuming we want to work with record ID 1
            [
                'title' => json_encode([
                    'ar' => 'عن الموقع',
                    'en' => 'about us',
                ]),
                'description' => json_encode([
                    'ar' => 'نص عن الموقع',
                    'en' => 'about us description',
                ]),
                'why_choose_us' => json_encode([
                    'ar' => 'نص لماذا يتم اختيارنا من قبل العملاء',
                    'en' => 'why choose us description',
                ]),
                'image' => null,
                'alt_image' => null,
                'banner' => null,
                'alt_banner' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
