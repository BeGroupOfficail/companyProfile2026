<?php

namespace App\Models\Dashboard\Blog;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogFaq extends Model
{
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'answer',
        'blog_id'
    ];

    public $translatable = ['question','answer']; // translatable attributes

}
