<?php

namespace App\Models\Dashboard\Setting;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\HandlesTranslationsAndMedia;

class CertificateTemplate extends Model
{
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    const TYPES = [
        'certificate' => 'certificate',
        'statement' => 'statement'
    ];
    protected $fillable = ['name', 'image_path', 'fields','status','type'];

    protected $casts = [
        'name'=> 'array',
        'fields' => 'array',
    ];

    public $translatable = ['name'];

}
