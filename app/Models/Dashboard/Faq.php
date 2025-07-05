<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    const MENUTPES = ['general', 'courses'];

    protected $fillable = [
        'question',
        'answer',
        'lang',
        'types',
        'type_value_id',
        'status'
    ];

    protected $casts = [
        'question' => 'array',
        'answer' => 'array'
    ];

}
