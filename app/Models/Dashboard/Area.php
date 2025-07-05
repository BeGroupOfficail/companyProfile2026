<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasTranslations;
    protected $guarded = [];
    public $translatable = ['name']; // translatable attributes

    public function region()
    {
        return $this->belongsTo(Region::class)->with('country');
    }

}
