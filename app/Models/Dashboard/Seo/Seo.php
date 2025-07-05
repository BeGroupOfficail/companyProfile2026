<?php

namespace App\Models\Dashboard\Seo;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
    use HasFactory,HandlesTranslationsAndMedia,HasTranslations;

    protected $table = 'seo';

    public const PAGETYPES = [
        "home"=> "home",
        "about_us"=> "about_us",
        "contact_us"=> "contact_us",
        'blogs'=>'blogs',
        'album_images'=>'album_images',
        'album_videos'=>'album_videos',
        'destinations'=>'destinations',
        'tours'=>'tours',
        'services'=>'services',
    ];

    const SCHEMATPES = [

    ];

    protected $fillable = [
        'page_type',
        'schema_types',
        'title',
        'slug',
        'meta_title',
        'meta_desc',
        'index',
    ];

    protected $casts = [
        'schema_types' => 'array',
        'title' => 'array',
        'slug' => 'array',
        'meta_title' => 'array',
        'meta_desc' => 'array',
        'index' => 'boolean',
    ];

    public $translatable = ['title','slug','meta_title','meta_desc']; // translatable attributes
}
