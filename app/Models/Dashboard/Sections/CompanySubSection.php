<?php

namespace App\Models\Dashboard\Sections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Traits\HandlesTranslationsAndMedia;

class CompanySubSection extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, HandlesTranslationsAndMedia;

    protected $guarded = [];

    public $translatable = ['title', 'description'];

    /**
     * Parent section
     */
    public function section()
    {
        return $this->belongsTo(CompanySection::class, 'section_id');
    }

    /**
     * Sub section items
     */
    public function items()
    {
        return $this->hasMany(CompanySubSectionItem::class, 'sub_section_id')
                    ->orderBy('sort_order');
    }
}