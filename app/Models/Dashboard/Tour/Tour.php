<?php

namespace App\Models\Dashboard\Tour;

use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Destination\Destination;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
class Tour extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    const TOURTPES = [
        'healthy'=> 'healthy',

    ];

    protected $guarded = [];
    public $translatable = ['name','short_desc','long_desc','tour_plan','slug','meta_title','meta_desc']; // translatable attributes

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('slug->en', $value)
            ->orWhere('slug->ar', $value)
            ->firstOrFail();
    }

    public function album()
    {
        return $this->hasOne(Album::class, 'type_value_id')->where('type', 'tours')->with('images');
    }

}
