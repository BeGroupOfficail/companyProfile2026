<?php

namespace App\Models\Dashboard\Setting;

use App\Models\Dashboard\Course\Course;
use App\Models\Dashboard\Training\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Statment extends Model
{
    const TYPES = [
        'training' => 'Training',
        'fellowship' => 'Fellowship',
        'diploma' => 'Diploma'
    ];

    const STATUS = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected'
    ];

    const LEARNING_TYPES = [
        'online' => 'Online',
        'offline' => 'Offline',
        'self-learning' => 'Self Learning',
        'mixed' => 'Mixed'
    ];

    protected $fillable = [
        'organization_name',
        'name',
        'phone',
        'ssn',
        'type',
        'type_value_id',
        'learning_type',
        'user_id',
        'status'

    ];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->locale('ar')->isoFormat('YYYY-MM-DD');
    }

    public function getTypeValueNameAttribute()
    {
        if (!$this->type || !$this->type_value_id) {
            return null;
        }

        $training = Training::with('course')->find($this->type_value_id);
        return $training?->course?->name ?? $training?->name;
    }

    public function getTypeValueAttribute()
    {
        if (!$this->type || !$this->type_value_id) {
            return null;
        }
        return Training::with('course')->find($this->type_value_id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'type_value_id');
    }

}