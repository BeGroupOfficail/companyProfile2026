<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use App\Models\Website\Cart;
use App\Helper\WebsiteHelper;
use App\Models\Website\Order;
use App\Models\Website\Wishlist;
use App\Models\Website\OrderItem;
use App\Models\Dashboard\Area\Area;
use App\Models\Website\StudentExam;
use Illuminate\Support\Facades\URL;
use App\Models\Dashboard\Ads\Modrator;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Dashboard\Center\Center;
use App\Models\Dashboard\Course\Course;
use App\Models\Dashboard\Crm\CrmClient;
use App\Models\Dashboard\Refund\Refund;
use App\Models\Dashboard\Region\Region;
use App\Models\Website\StudentTraining;
use Illuminate\Notifications\Notifiable;
use App\Models\Dashboard\Ads\AdsModrator;
use App\Models\Dashboard\Crm\CrmEmployee;
use App\Models\Dashboard\InstructorCenter;
use App\Models\Dashboard\Lesson\LessonNote;
use App\Models\Dashboard\Training\Training;
use App\Traits\HandlesTranslationsAndMedia;
use App\Models\Dashboard\Student\StudentInfo;
use App\Models\Dashboard\User\UserDisability;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Dashboard\Crm\CrmTargetHistory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dashboard\Course\InstructorInfo;
use App\Models\Dashboard\Marketer\MarketerInfo;
use App\Models\Dashboard\Request\ClientRequest;
use App\Models\Dashboard\Setting\WebsiteDesign;
use App\Models\Dashboard\Request\CompanyRequest;
use App\Models\Dashboard\Student\StudentRequest;
use App\Models\Dashboard\Center\CenterInstructor;
use App\Models\Dashboard\Nationality\Nationality;
use App\Models\Dashboard\Center\CenterResponsible;
use App\Models\Dashboard\Student\StudentAttendance;
use App\Factories\MessageSender\MessageSenderFactory;
use App\Models\Dashboard\Marketer\MarketerResponsible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HandlesTranslationsAndMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    use HasRoles;

    const JOBRoles = [
        // super admin will not render value is empty
        'super_admin' => 'super_admin',
        'admin' => 'admin',
        'student' => 'student',
        'instructor' => 'instructor',
        'moderator' => 'moderator',
        'coordinator' => 'coordinator',
        'reviewer' => 'reviewer',
        'CrmEmployee' => 'CrmEmployee',
        'company' => 'company',
        'CrmEmployeeManager' => 'CrmEmployeeManager',
        'marketer' => 'marketer',
        'coordinator' => 'coordinator',
    ];
    // jobs used in crm module as normal crm employees
    const JOBSFORCRM = ['CrmEmployee','CrmEmployeeManager','marketer'];
    const DISABILITY = [
        'exam_support' => ['extra_time', 'quite_exam_hall', 'helper_devices', 'large_font_size', 'exame_soft_copy'],
        'hearing_support' => ['sign_translator', 'hearing_helper_devices', 'hearing_copies_writen'],
        'visual_support' => ['large_print_materials', 'audio_version_of_materials', 'screen_reader_or_magnifier'],
        'mobility_support' => ['wheelchair_accessible_seating', 'accessible_seating_arrangement', 'allow_personal_assistant'],
        'learning_support' => ['additional_explanation', 'split_exam_with_breaks', 'supervisor_or_assistant_support'],
        'other' => ['other'],
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

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
        if ($this->image) {
            return asset('uploads/users/' . $this->image);
        }
        $website = WebsiteDesign::where('name', 'Ipa')->where('is_active', 1)->first();
        if (isset($website)) {
            return WebsiteHelper::getAsset('img/user/default.jpeg');
        } else {
            // If no custom image, return gender-based default avatar
            if ($this->gender === 'male') {
                return WebsiteHelper::getAsset('img/user/male.jpeg');
            } elseif ($this->gender === 'female') {
                return WebsiteHelper::getAsset('img/user/female.jpeg');
            }
        }
        // Fallback generic avatar
        return WebsiteHelper::getAsset('img/user/male.jpeg');
    }

    public function employee()
    {
        return $this->hasOne(CrmEmployee::class);
    }

    public function getCurrentTargetAttribute(): string
    {
        return CrmTargetHistory::where('user_id', $this->id)->latest();
    }

    public function instructor_info()
    {
        return $this->hasOne(InstructorInfo::class, 'user_id')->with('specialization', 'subSpecialization');
    }

   public function marketer_info()
{
    return $this->hasOneThrough(
        MarketerInfo::class,
        MarketerResponsible::class,
        'user_id',
        'id',
        'id',
        'marketer_id'            
    );
}

    public function modrator()
    {
        return $this->hasOne(AdsModrator::class, 'user_id');
    }

    //for instructor only
    public function my_trainings()
    {
        return $this->belongsToMany(Training::class, 'training_instructors', 'user_id', 'training_id');
    }

    // for marketers only
    public function marketerInstructors()
    {
        return $this->belongsToMany(User::class, 'marketer_instructors', 'marketer_id', 'instructor_id');
    }

    public function marketerCoordinators()
    {
        return $this->belongsToMany(User::class, 'marketer_coordinators', 'marketer_id', 'coordinator_id');
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
        if (auth()->check()) {
            return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id');
        } else {
            $session_id = session()->get('session_id');
            if (!$session_id) {
                $session_id = Str::uuid();
                session()->put('session_id', $session_id);
            }
            return Wishlist::where('session_id', $session_id)->get();
        }
    }

    public function my_courseWishlist()
    {
        if (auth()->check()) {
            return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id');
        } else {
            $session_id = session()->get('session_id');
            if (!$session_id) {
                $session_id = Str::uuid();
                session()->put('session_id', $session_id);
            }
            return Wishlist::where('session_id', $session_id)->get();
        }
    }

    public function my_trainingWishlist()
    {
        if (auth()->check()) {
            return $this->belongsToMany(Training::class, 'wishlists', 'user_id', 'training_id');
        } else {
            $session_id = session()->get('session_id');
            if (!$session_id) {
                $session_id = Str::uuid();
                session()->put('session_id', $session_id);
            }
            return Wishlist::where('session_id', $session_id)->get();
        }
    }

    public function my_diploma_wishlist()
    {
        if (auth()->check()) {
            return $this->belongsToMany(Training::class, 'wishlists', 'user_id', 'training_id')
                ->where('main_type', 'diploma');
        } else {
            $session_id = session()->get('session_id');
            if (!$session_id) {
                $session_id = Str::uuid();
                session()->put('session_id', $session_id);
            }

            return Wishlist::where('session_id', $session_id)
                ->whereHas('training', function ($query) {
                    $query->where('main_type', 'diploma');
                })
                ->get();
        }
    }

    public function my_fellowship_wishlist()
    {
        if (auth()->check()) {
            return $this->belongsToMany(Training::class, 'wishlists', 'user_id', 'training_id')
                ->where('main_type', 'fellowship');
        } else {
            $session_id = session()->get('session_id');
            if (!$session_id) {
                $session_id = Str::uuid();
                session()->put('session_id', $session_id);
            }

            return Wishlist::where('session_id', $session_id)
                ->whereHas('training', function ($query) {
                    $query->where('main_type', 'fellowship');
                })
                ->get();
        }
    }


    public function my_cart()
    {
        return $this->hasOne(Cart::class)->with('items');
    }
    public function my_courses()
    {
        return $this->hasMany(OrderItem::class)->with('course')->where('type', 'self_learning');
    }

    // for student
    public function studentInfo()
    {
        return $this->hasOne(StudentInfo::class, 'user_id');
    }

    public function student_trainings()
    {
        return $this->hasMany(OrderItem::class)
            ->where('type', '!=', 'self_learning')->where('item_type', 'course')
            ->with(['course', 'training']);
    }

    public function StudentTrainings()
    {
        return $this->hasMany(StudentTraining::class, 'user_id')->with('surveyAnswers', 'training');
    }

    public function lesson_notes()
    {
        return $this->hasMany(LessonNote::class, 'student_id');
    }

    public function all_student_trainings()
    {
        return $this->hasMany(OrderItem::class)
            ->where('type', '!=', 'self_learning')
            ->with(['course', 'training']);
    }
    public function student_diplomas()
    {
        return $this->all_student_trainings()
            ->whereHas('training', function ($q) {
                $q->where('main_type', 'diploma');
            });
    }
    public function student_fellowships()
    {
        return $this->all_student_trainings()
            ->whereHas('training', function ($q) {
                $q->where('main_type', 'fellowship');
            });
    }
    public function hasJoinedTraining($trainingId): bool
    {
        return $this->all_student_trainings()->where('training_id', $trainingId)->exists();
    }

    public function student_exams()
    {
        return $this->hasMany(StudentExam::class, 'student_id')->with('exam');
    }

    // student attendences
    public function attendance()
    {
        return $this->hasMany(StudentAttendance::class,'student_id', 'id');
    }

    // for student orders
    public function my_orders()
    {
        return $this->hasMany(Order::class)->with('items');
    }
    public function my_refunds()
    {
        return $this->hasMany(Refund::class)->with('orderItem');
    }
    public function my_order_items()
    {
        return $this->hasMany(OrderItem::class)->with('course');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function instructorCourses()
    {
        return $this->belongsToMany(Course::class, 'course_instructors', 'instructor_id', 'course_id');
    }

    public function readyForPaymentStudentRequests()
    {
        return $this->hasManyThrough(
            StudentRequest::class,
            StudentInfo::class,
            'user_id', // Foreign key on StudentInfo table
            'student_id', // Foreign key on StudentRequest table
            'id', // Local key on User table
            'id', // Local key on StudentInfo table
        )->where('payment_status', 'ready');
    }

    public function sendCustomEmailVerification()
    {
        $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $this->id, 'hash' => sha1($this->email)]);

        $emailSender = MessageSenderFactory::make('email');
        $emailSender->send([$this], 'emails.verifyEmail', __('home.Verify Your Email Address'), $verificationUrl);
    }

    public function sendOTPVerification()
    {
        $new_otp = rand(100000, 999999);
        $this->otp = $new_otp;
        $this->save();

        $emailSender = MessageSenderFactory::make('sms');
        $emailSender->send([$this], null, '', 'رمز التحقق الخاص بحسابك هو  ' . $new_otp);
    }

    public function studentRequests()
    {
        return $this->hasManyThrough(
            StudentRequest::class,
            StudentInfo::class,
            'user_id', // Foreign key on StudentInfo table
            'student_id', // Foreign key on StudentRequest table
            'id', // Local key on User table
            'id', // Local key on StudentInfo table
        );
    }

    public function centerResponsibles()
    {
        return $this->hasMany(CenterResponsible::class, 'user_id');
    }

    public function centerInstructors()
    {
        return $this->hasMany(CenterInstructor::class, 'user_id');
    }

    public function centers()
    {
        return $this->hasManyThrough(Center::class, CenterResponsible::class, 'user_id', 'id', 'id', 'center_id');
    }

    public function refusedStudentRequests()
    {
        return $this->studentRequests()->where('status', 'refused');
    }

    public function acceptedStudentRequests()
    {
        return $this->studentRequests()->where('status', 'accepted');
    }
    public function mainRequest()
    {
        return $this->hasOne(ClientRequest::class, 'email', 'email')->withTrashed();
    }
    public function companyMainRequest()
    {
        return $this->hasOne(CompanyRequest::class, 'responsible_email', 'email')->withTrashed();
    }

    public function getHasDisabilityAttribute()
    {
        return $this->disabilities->count() > 0;
    }
    public function disabilities()
    {
        return $this->hasMany(UserDisability::class);
    }


    public function crm_client()
    {
        return $this->hasOne(CrmClient::class, 'user_id')->with('region', 'area', 'company');
    }

    public function my_centers()
    {
        return $this->belongsToMany(Center::class, 'instructor_centers', 'user_id', 'center_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
