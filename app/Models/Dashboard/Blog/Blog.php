<?php

namespace App\Models\Dashboard\Blog;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
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
        'blog_category_id',
        'short_desc',
        'long_desc',
        'image',
        'alt_image',
        'slug',
        'meta_title',
        'meta_desc',
        'status',
        'index',
        'order_date',
        'home',
        'menu',

    ];

    public $translatable = ['name', 'short_desc', 'long_desc', 'slug', 'meta_title', 'meta_desc', 'question', 'answer']; // translatable attributes

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function dashboard_blogFaqs()
    {
        return $this->hasMany(BlogFaq::class);
    }
    public function blogFaqs()
    {
        return $this->hasMany(BlogFaq::class);
    }

    public function relatedBlogs()
    {
        return Blog::with('category')->whereNot('id', $this->id)->where('blog_category_id', $this->blog_category_id)->where('status', 'published')->get();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('slug->en', $value)
            ->orWhere('slug->ar', $value)
            ->firstOrFail();
    }

    protected static function booted()
    {
        static::creating(function ($blog) {
            if (empty($blog->order_date)) {
                $blog->order_date = $blog->created_at ?? now();
            }
        });

        static::saved(function ($blog) {
            if ($blog->status == 'published' || $blog->menu == 1) {
                Cache::forget('header_blogs');
            }
        });

        static::deleted(function ($blog) {
            if ($blog->status == 'published' || $blog->menu == 1) {
                Cache::forget('header_blogs');
            }
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }


    public function getCustomLinkAttribute()
    {
        return LaravelLocalization::localizeUrl('blog/' . $this->slug);
    }
}
