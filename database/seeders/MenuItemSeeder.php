<?php

namespace Database\Seeders;

use App\Models\Dashboard\Course\Field;
use App\Models\Dashboard\Menu\Menu;
use App\Models\Dashboard\Menu\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuitems = [
            ['name'=>['en' => 'Home', 'ar' => 'الرئيسية'],'types'=>'home','link'=>''],
            ['name'=>['en' => 'Services', 'ar' => 'الخدمات'],'types'=>'services','link'=>''],
            ['name'=>['en' => 'About Us', 'ar' => 'عن حلال'],'types'=>'about-us','link'=>''],
            ['name'=>['en' => 'Blogs', 'ar' => 'المقالات'],'types'=>'blogs','link'=>''],
            ['name'=>['en' => 'Contact Us', 'ar' => 'تواصل معنا'],'types'=>'contact-us','link'=>''],
        ];
        foreach($menuitems as $index=>$menu){
            MenuItem::updateOrCreate([
                'name'=>$menu['name']
            ],[
                'order'=>$index+1,
                'link'=>$menu['link'],
                'types'=>$menu['types'],
                'status'=>'published',
                'menu_id'=>1,
            ]);
        }
    }
}