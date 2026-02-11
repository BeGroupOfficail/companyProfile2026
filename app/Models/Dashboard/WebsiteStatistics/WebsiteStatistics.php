<?php

namespace App\Models\Dashboard\WebsiteStatistics;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class WebsiteStatistics extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, HandlesTranslationsAndMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'count',
        'image',
        'alt_image',
        'status',
    ];

    public $translatable = ['title'];
}
