<?php

namespace App\Models\Dashboard\Client;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Client extends Model
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
        'name',
        'desc',
        'types',
        'alt_image',
        'image',
        'status',
        'home',
        'link',
    ];

    const TYPES = [
        'clients'=>'clients',
//        'partners'=>'partners',
//        'accreditations'=>'accreditations'
    ];

    public $translatable = ['name','desc']; // translatable attributes
}
