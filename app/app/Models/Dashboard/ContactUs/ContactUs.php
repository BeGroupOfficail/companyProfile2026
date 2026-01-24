<?php

namespace App\Models\Dashboard\ContactUs;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'title',
        'reason_for_connect',
        'seen'
    ];


    public static function new_messages(){
        return ContactUs::where('seen',0)->count();
    }
}
