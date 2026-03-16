<?php

namespace App\Models\Dashboard\Seo;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CompanySeo extends Model
{
    use HasFactory,HandlesTranslationsAndMedia,HasTranslations;

    protected $table = 'company_seo';
    protected $fillable = [
        'title',
        'author',
        'description',
        'canonical',
        'robots',
        'content_type',
        'open_graph',
        'twitter_card',
        'hreflang_tags',
        'schema',
    ];

    protected $casts = [
        'title' => 'array',
        'author' => 'array',
        'description' => 'array',
        'canonical' => 'array',
        'open_graph' => 'array',
        'twitter_card' => 'array',
        'hreflang_tags' => 'array',
        'schema' => 'array',
    ];

    public $translatable = [
        'title',
        'author',
        'description',
        'canonical',
    ];
}
