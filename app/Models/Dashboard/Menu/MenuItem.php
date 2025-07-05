<?php

namespace App\Models\Dashboard\Menu;

use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Page\Page;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    const MENUTPES = [
        'home'=> 'home',
        'about-us'=> 'about-us',
        'contact-us'=> 'contact-us',
        'destination'=>'destination',
        'destinations'=>'destinations',
        'tour'=>'tour',
        'tours'=>'tours',
        'blogs'=>'blogs',
        'blog'=>'blog',
        'service'=>'service',
        'services'=>'services',
        'blog-categories'=>'blog-categories',
        'blog-category'=>'blog-category',
        'pages'=>'pages',
        'page'=>'page',
        'link'=>'link',
        'main-menu'=>'main-menu',
    ];

    protected $fillable = [
        'name',
        'types',
        'type_value_id',
        'status',
        'menu_id',
        'parent_id',
        'order',
        'link'
    ];

    protected $casts = [
        'name' => 'array'
    ];

    public $translatable = ['name']; // translatable attributes

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function subMenus()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }
    public function page()
    {
        return $this->belongsTo(Page::class, 'type_value_id');
    }
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'type_value_id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'type_value_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'type_value_id');
    }

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'type_value_id');
    }

    protected static function booted(){
        static::saved(function ($menuItem) {
            if ($menuItem->status == 'published'){
                Cache::forget($menuItem->menu_id == 1 ? 'head_menu' : 'footer_menu');
            }
        });

        static::deleted(function ($menuItem) {
            if ($menuItem->status == 'published'){
                Cache::forget($menuItem->menu_id == 1 ? 'head_menu' : 'footer_menu');
            }
        });
    }
}
