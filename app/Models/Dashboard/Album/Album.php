<?php

namespace App\Models\Dashboard\Album;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Album extends Model
{

    use HasFactory;
    use softDeletes;
    use HasTranslations;


    const ALBUMTYPES = [
        'general'=>'general',
        'tours'=>'tours',
        'destinations'=>'destinations',
        'services'=>'services'
    ];

    protected $table = 'albums';

    protected $fillable = [
        'image',
        'alt_image',
        'album_id',
        'status',
        'type',
        'type_value_id'
    ];

    protected $casts = [
        'type_value_id' => 'integer'
    ];

    public $translatable = ['title','text']; // translatable attributes


    public function images(){
        return $this->hasMany(AlbumImage::class)->orderBy('order','asc');
    }

    public function videos(){
        return $this->hasMany(AlbumVideo::class)->orderBy('order','asc');
    }

}
