<?php

namespace App\Models\Dashboard\Page;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{

    use HasFactory;
    use softDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    protected $table = 'pages';

    protected $fillable = [
        'name',
        'short_desc',
        'long_text',
        'status',
        'slug',
        'meta_title',
        'meta_desc',
        'index',
        'home',
        'menu',
    ];

    //protected $casts = [
    //    'name' => 'array',
    //    'short_desc' => 'array',
    //    'long_text' => 'array',
    //    'slug' => 'array',
    //    'meta_title' => 'array',
    //    'meta_desc' => 'array',
    //    'index' => 'boolean'
    //];

    public $translatable = ['name','short_desc','long_text','slug','meta_title','meta_desc']; // translatable attributes


    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
        ->orWhere('slug->en', $value)
            ->orWhere('slug->ar', $value)
            ->firstOrFail();
    }

    protected static function booted()
    {
        static::saved(function ($page) {
            if ($page->status == 'published') {
                Cache::forget('pages');
                if ($page->menu == 1) {
                    Cache::forget('header_pages');
                }
            }
        });

        static::deleted(function ($page) {
            if ($page->status == 'published') {
                Cache::forget('pages');
                if ($page->menu == 1) {
                    Cache::forget('header_pages');
                }
            }
        });
    }
}
