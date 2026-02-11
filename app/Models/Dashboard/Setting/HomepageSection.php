<?php

namespace App\Models\Dashboard\Setting;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class HomepageSection extends Model
{
    use HasFactory, SoftDeletes,HasTranslations,HandlesTranslationsAndMedia;

    protected $fillable = [
        'title',
        'image',
        'alt_image',
        'order',
        'is_active',
    ];

    public $translatable = ['title'];
}
