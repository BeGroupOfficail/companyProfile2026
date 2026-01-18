<?php

namespace App\Models\Dashboard\About;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class AboutValue extends Model
{
    use SoftDeletes,HasTranslations,HandlesTranslationsAndMedia;

    protected $table = 'about_values';

    protected $fillable = [
        'title',
        'description',
        'type',
        'order',
        'image',
        'alt_image',
        'icon',
        'alt_icon',
        'status',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'status' => 'string',
    ];


    public $translatable = ['title','description'];

     const TYPES=[
         'mission_and_vision'=>'mission_and_vision',
         'our_speciality'=>'our_speciality',
//        'benefits'=>'benefits',
//        'working_steps'=>'working_steps',
//        'target_audiance'=>'target_audiance',


    ];
}
