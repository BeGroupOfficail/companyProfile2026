<?php

namespace App\Models\Dashboard\Blog;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_desc',
        'long_desc',
        'image',
        'alt_image',
        'slug',
        'meta_title',
        'meta_desc',
        'status',
        'index',
        'home',
        'menu',
    ];

    public $translatable = ['name','short_desc','long_desc','slug','meta_title','meta_desc']; // translatable attributes

    protected static function booted()
    {
        static::saved(function ($category) {
            if ($category->status == 'published' || $category->menu == 1) {
                Cache::forget('header_blog_categories');
            }
        });

        static::deleted(function ($category) {
            if ($category->status == 'published' || $category->menu == 1) {
                Cache::forget('header_blog_categories');
            }
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
        ->orWhere('slug->en', $value)
            ->orWhere('slug->ar', $value)
            ->firstOrFail();
    }

    public function public_blogs(){
        return $this->hasMany(Blog::class)->where('status','published')->with('category');
    }
}
