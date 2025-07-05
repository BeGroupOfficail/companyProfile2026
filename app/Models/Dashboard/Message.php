<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'training_id',
        'type',
        'n_sent',
        'n_failed',
        'n_delivered'
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public static function getTypes()
    {
        return [
            'sms' => __('dash.sms'),
            'email' => __('dash.email'),
            'whatsapp' => __('dash.whatsapp'),
        ];
    }

}
