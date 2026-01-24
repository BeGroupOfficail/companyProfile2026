<?php

namespace App\Models\Dashboard\Testimonial;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
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
        'title',
        'text',
        'author_name',
        'author_title',
        'company',
        'alt_image',
        'image',
        'status',
        'rate',
    ];

    public $translatable = ['title','text']; // translatable attributes
}
