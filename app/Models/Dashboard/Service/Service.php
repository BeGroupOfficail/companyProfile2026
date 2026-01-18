<?php

namespace App\Models\Dashboard\Service;

use App\Models\Dashboard\Album\Album;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations, HandlesTranslationsAndMedia, SoftDeletes;

    protected $guarded = [];
    public $translatable = ['name', 'short_desc', 'long_desc', 'slug'];

    public function getParentAttribute()
    {
        return $this->public_childs()->count()>0;
    }

    public function childs()
    {
        return $this->hasMany(Service::class, 'parent_id');
    }
    public function public_childs()
    {
        return $this->hasMany(Service::class, 'parent_id')->where('status', 'published');
    }
    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('slug->en', $value)
            ->orWhere('slug->ar', $value)
            ->firstOrFail();
    }
    public function getCustomLinkAttribute()
    {
        return LaravelLocalization::localizeUrl('service/' . $this->slug);
    }


    public function albums(){
        return $this->hasmany(Album::class, 'type_value_id')->where('type', 'services')->with('images');
    }

}
