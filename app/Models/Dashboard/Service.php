<?php

namespace App\Models\Dashboard;

use App\Models\Dashboard\Album\Album;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use function PHPUnit\Framework\isNull;

class Service extends Model
{
    use HasFactory, HasTranslations, HandlesTranslationsAndMedia;

    protected $guarded = [];
    public $translatable = ['name', 'short_desc', 'long_desc', 'slug', 'meta_title', 'meta_desc'];

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

    public function album()
    {
        return $this->hasOne(Album::class, 'type_value_id')->where('type', 'services')->with('images');
    }

}
