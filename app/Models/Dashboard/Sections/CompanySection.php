<?php

namespace App\Models\Dashboard\Sections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Traits\HandlesTranslationsAndMedia;

class CompanySection extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, HandlesTranslationsAndMedia;

    protected $guarded = [];

    // fields that are translatable
    public $translatable = ['title', 'description'];

    /**
     * Get the sub sections for this section.
     */
    public function subSections()
    {
        return $this->hasMany(CompanySubSection::class, 'section_id')
                    ->orderBy('sort_order');
    }
}
