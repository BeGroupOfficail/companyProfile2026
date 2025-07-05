<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'title',
        'seen'
    ];


    public static function new_messages(){
        return ContactUs::where('seen',0)->count();
    } 
}
