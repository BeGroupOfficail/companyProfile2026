<?php

namespace App\Models\Dashboard\Faq;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
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
        'question',
        'answer',
        'status',
    ];

    public $translatable = ['question','answer']; // translatable attributes
}
