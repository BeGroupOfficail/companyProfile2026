<?php

namespace App\Models\Dashboard\Country;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Country extends Model
{
    use HasTranslations;
    protected $guarded = [];
    public $translatable = ['name']; // translatable attributes

}
