<?php

namespace App\Models\Dashboard\About;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AboutUs extends Model
{
    use HasTranslations,HandlesTranslationsAndMedia;
  
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'about_us';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'why_choose_us',
        'image',
        'image_en',
        'banner_en',
        'alt_image',
        'alt_image_en',
        'alt_banner_en',
        'banner',
        'alt_banner',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'why_choose_us' => 'array',
    ];

    public $translatable = ['title','description','why_choose_us','slug','meta_title','meta_desc'];
}
