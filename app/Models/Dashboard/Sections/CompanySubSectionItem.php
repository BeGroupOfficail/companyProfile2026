<?php

namespace App\Models\Dashboard\Sections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Traits\HandlesTranslationsAndMedia;

class CompanySubSectionItem extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, HandlesTranslationsAndMedia;

    protected $guarded = [];

    public $translatable = ['title', 'description'];

    /**
     * Parent sub-section
     */
    public function subSection()
    {
        return $this->belongsTo(CompanySubSection::class, 'sub_section_id');
    }
}