<?php

namespace App\Models\Dashboard\Menu;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    protected $fillable = [
        'name',
        'status'
    ];

    public $translatable = ['name']; // translatable attributes


    public function items(){
        return $this->hasMany(MenuItem::class)->with('page','blog_category','blog')->orderBy('order','ASC');
    }
    public function published_items(){
        return $this->hasMany(MenuItem::class)->where('status', 'published')->with('page','blog_category','blog')->orderBy('order','ASC');
    }

    protected static function booted()
    {
        static::saved(function ($menu) {
            if (in_array($menu->id, [1, 2])) {
                Cache::forget($menu->id == 1 ? 'head_menu' : 'footer_menu');
            }
        });

        static::deleted(function ($menu) {
            if (in_array($menu->id, [1, 2])) {
                Cache::forget($menu->id == 1 ? 'head_menu' : 'footer_menu');
            }
        });
    }

}
