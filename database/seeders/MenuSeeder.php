<?php

namespace Database\Seeders;

use App\Models\Dashboard\Course\Field;
use App\Models\Dashboard\Menu\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['name'=>['en' => 'Header', 'ar' => 'القائمة الرئيسية'],'status'=>'published'],
            ['name'=>['en' => 'Footer', 'ar' => 'الفوتر'],'status'=>'published']
        ];
        foreach($menus as $menu){
            Menu::updateOrCreate([
                'name'=>$menu['name']
            ],[
                'status'=>$menu['status']
            ]);
        }
    }
}