<?php

namespace App\Models\Dashboard\Destination;

use App\Models\Dashboard\Country;
use App\Models\Dashboard\Region;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Destination extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    protected $guarded = [];
    public $translatable = ['name','desc','slug','meta_title','meta_desc']; // translatable attributes


    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class)->with('country');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('slug->en', $value)
            ->orWhere('slug->ar', $value)
            ->firstOrFail();
    }

}
