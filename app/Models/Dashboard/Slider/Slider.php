<?php

namespace App\Models\Dashboard\Slider;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Slider extends Model
{

    use HasFactory;
    use softDeletes;
    use HandlesTranslationsAndMedia;

    protected $table = 'sliders';

    protected $fillable = [
        'title',
        'text',
        'link',
        'lang',
        'status',
        'image',
        'alt_image',
        'order'
    ];


}
