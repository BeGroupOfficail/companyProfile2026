<?php

namespace App\Models\Dashboard;

use App\Models\Dashboard\Destination\Destination;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasTranslations;
    protected $guarded =[];
    public $translatable = ['name']; // translatable attributes

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function destinations(){
        return $this->hasMany(Destination::class);
    }

}
