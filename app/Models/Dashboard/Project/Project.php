<?php

namespace App\Models\Dashboard\Project;

use App\Models\Dashboard\Service\Service;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasFactory, HasTranslations, HandlesTranslationsAndMedia, SoftDeletes;

    protected $guarded = [];
    public $translatable = ['name', 'short_desc', 'long_desc', 'slug'];

    public function service()
    {
        return $this->belongsTo(Service::class);
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
        return LaravelLocalization::localizeUrl('projects/' . $this->slug);
    }

}
