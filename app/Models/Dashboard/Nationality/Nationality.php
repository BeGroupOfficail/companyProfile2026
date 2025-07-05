<?php
namespace App\Models\Dashboard\Nationality;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Nationality extends Model
{
    use SoftDeletes,HasTranslations,HandlesTranslationsAndMedia;
    protected $fillable = ['name'];
    public $translatable = ['name']; // translatable attributes
}
