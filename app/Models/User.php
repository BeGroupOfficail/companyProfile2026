<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helper\WebsiteHelper;
use App\Models\Dashboard\Course\Course;
use App\Models\Dashboard\Course\InstructorInfo;
use App\Models\Dashboard\Crm\CrmEmployee;
use App\Models\Dashboard\Crm\CrmTargetHistory;
use App\Models\Dashboard\Nationality\Nationality;
use App\Models\Dashboard\Training;
use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HandlesTranslationsAndMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    use HasRoles;

    const JOBRoles = [
        // super admin will not render value is empty
        'super_admin' => '',
        'admin' => 'admin',
        'student' => 'student',
        'instructor' => 'instructor'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->f_name . ' ' . $this->l_name;
    }
    public function getUserImageAttribute()
    {
        return $this->image
        ? asset('uploads/users/' . $this->image)
        : WebsiteHelper::getAsset('img/user/user-01.jpg');
    }


    public function employee()
    {
        return $this->hasOne(CrmEmployee::class);
    }

    public function getCurrentTargetAttribute(): string
    {
        return CrmTargetHistory::where('user_id', $this->id)->latest();
    }
    public function getStudentInfoAttribute()
    {
        return $this->hasOne(StudentInfo::class, 'user_id');
    }
    public function instructor_info()
    {
        return $this->hasOne(InstructorInfo::class, 'user_id');
    }

    //for instructor only
    public function my_trainings()
    {
        return $this->belongsToMany(Training::class, 'training_instructors', 'user_id', 'training_id');
    }

    // user redirection depend on job_role

    public function isSuperAdmin(): bool
    {
        return $this->job_role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === 1;
    }

    public function isStudent(): bool
    {
        return $this->job_role === 'student';
    }

    public function isInstructor(): bool
    {
        return $this->job_role === 'instructor';
    }

    public function my_wishlist()
    {
        if(auth()->check()){
            return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id');
        }else{
            $session_id = session()->get('session_id');
            if (!$session_id) {
                $session_id = Str::uuid();
                session()->put('session_id', $session_id);
            }
            return Wishlist::where('session_id', $session_id)->get();
        }
    }
    public function my_cart()
    {
        return $this->hasOne(Cart::class)->with('items');
    }
    public function my_courses()
    {
        return $this->hasMany(OrderItem::class)->with('course')->where('type','self_learning');
    }
 
    // for student
    public function student_trainings()
    {
        return $this->hasMany(OrderItem::class)->with('course')->whereNot('type','self_learning')->with('training');
    }

    public function student_exams()
    {
        return $this->hasMany(StudentExam::class,'student_id')->with('exam');
    }

    // for student orders
    public function my_orders()
    {
        return $this->hasMany(Order::class)->with('items');
    }


     public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }



}
