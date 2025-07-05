<?php
namespace Database\Seeders;

use App\Models\Dashboard\Setting\WebsiteDesign;
use Illuminate\Database\Seeder;

class WebsiteDesignSeeder extends Seeder
{
    public function run()
    {
        WebsiteDesign::updateOrCreate([
            'name' => 'Design 1',
            'folder' => 'design1',
            'is_active' => true,
        ]);

        WebsiteDesign::UpdateOrCreate([
            'name' => 'Design 2',
            'folder' => 'design2',
            'is_active' => false,
        ]);
    }
}

