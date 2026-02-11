<?php

namespace App\Models\Dashboard\Menu;

use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Page\Page;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    const MENUTPES = [
        'home' => 'home',
        'about-us' => 'about-us',
        'contact-us' => 'contact-us',
        'clients' => 'clients',
        'service' => 'service',
        'services' => 'services',
        'project' => 'project',
        'projects' => 'projects',
        'portfolio' => 'portfolio',
        'blogs' => 'blogs',
        'link' => 'link',

//        'blog-categories' => 'blog-categories',
//        'blog-category' => 'blog-category',
//        'blogs' => 'blogs',
//        'blog' => 'blog',
//        'pages' => 'pages',
//        'page' => 'page',
//        'main-menu' => 'main-menu',
//        'images-gallery' => 'images-gallery',
    ];

    protected $fillable = ['name', 'types', 'type_value_id', 'status', 'menu_id', 'parent_id', 'order', 'link'];

    protected $casts = [
        'name' => 'array',
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
        return $this->hasMany(MenuItem::class, 'parent_id')->where('status','published')->orderBy('order', 'ASC');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'type_value_id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'type_value_id');
    }

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'type_value_id');
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('head_menu');
        });

        static::deleting(function ($menuItem) {
            Cache::forget('head_menu');
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

    public function getCustomLinkAttribute()
    {
        switch ($this->types) {
            case 'home':
                return route('website.home');
            case 'about-us':
                return route('website.about_us');
            case 'contact-us':
                return LaravelLocalization::localizeUrl('/contact-us');
            case 'link':
                return LaravelLocalization::localizeUrl($this->link);
            case 'clients':
                return LaravelLocalization::localizeUrl('clients');
            case 'projects':
                return LaravelLocalization::localizeUrl('projects');
            case 'portfolio':
                return LaravelLocalization::localizeUrl('portfolio');
            case 'page':
                return LaravelLocalization::localizeUrl('page/' . $this->page?->slug);
            case 'blog-category':
                return LaravelLocalization::localizeUrl('blog-category/' . $this->blog_category?->slug);
            case 'blogs':
                return LaravelLocalization::localizeUrl('blogs');
            case 'images-gallery':
                return LaravelLocalization::localizeUrl('images-gallery');
            case 'services':
                return 'javascript:void(0)';
            case 'pages':
                return 'javascript:void(0)';
            case 'blog-categories':
                return 'javascript:void(0)';
            case 'main-menu':
                return 'javascript:void(0)';
        }
    }

    public function getCustomNameAttribute()
    {
        switch ($this->types) {
            case 'home':
                return __('home.home');
            case 'about-us':
                return __('home.about_us');
            case 'contact-us':
                return __('home.contact_us');
            case 'field':
                return $this->field?->name;
            case 'course':
                return $this->course?->name;
            case 'page':
                return $this->page?->name;
            case 'blog-category':
                return $this->blog_category?->name;
            default:
                return $this->name;
        }
    }
    public function getIsActiveAttribute()
    {
        $currentUrl = urldecode(Request::url());
        $link = urldecode($this->custom_link);

        // Always active if exact match
        if ($currentUrl === $link) {
            return true;
        }
        $type = $this->types;
        switch ($type) {
            case 'home':
                return Request::is('/');
            case 'about-us':
                return Request::is('about-us');
            case 'contact-us':
                return Request::is('contact-us');
            case 'categories':
                return Request::is('categories') || Request::segment(2) == 'category';
            case 'blogs':
                return Request::is('blogs') || Request::segment(2) == 'blog';
            case 'blog-category':
                return Request::is('blog-category/*');
            case 'blog-categories':
                return Request::is('blog-categories') || Request::segment(2) == 'blog-category';
            case 'images-gallery':
                return Request::is('images-gallery') || Request::segment(2) == 'images-gallery';
            case 'services':
                return Request::is('services') || Request::segment(2) == 'service';
            case 'page':
                return Request::segment(2) == 'page';
            case 'pages':
                return Request::is('pages') || Request::segment(2) == 'page';
            case 'main-menu':
                if ($this->subMenus->count() > 0) {
                    foreach ($this->subMenus as $subMenu) {
                        if ($subMenu->is_active) {
                            return true;
                        }
                    }
                }
            default:
                // fallback: exact URL match
                return $currentUrl === $link;
        }
    }
}
