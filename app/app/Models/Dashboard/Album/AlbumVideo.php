<?php

namespace App\Models\Dashboard\Album;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumVideo extends Model
{

    use HasFactory;
    //use softDeletes;

    protected $table = 'album_videos';

    protected $fillable = [
        'video_url',
        'album_id',
        'status',
        'order'
    ];

    public function album(){
        return $this->belongsTo(Album::class);
    }

}
