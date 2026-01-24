<?php

namespace App\Models\Dashboard\Seo;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
    use HasFactory,HandlesTranslationsAndMedia,HasTranslations;

    protected $table = 'seo';

    public const PAGETYPES = [
        "home"=> "home",
        "about_us"=> "about_us",
        "contact_us"=> "contact_us",
        'courses'=>'courses',
        'fellowships'=>'fellowships',
        'accreditations' => 'accreditations',
        'programs'=>'programs',
        'fields'=>'fields',
        'success_partners'=>'success_partners',
        'blogs'=>'blogs',
        'categories'=>'categories',
        'album_images'=>'album_images',
        'album_videos'=>'album_videos',
        'featured_courses'=>'featured_courses',
        'profile'=>'profile',
        'wish_list'=>'wish_list',
        'cart'=>'cart',
        'account_settings'=>'account_settings',
        'my_trainings'=>'my_trainings',
        'my_diplomas'=>'my_diplomas',
        'my_fellowships'=>'my_fellowships',
        'faqs'=>'faqs',
        'my_courses'=>'my_courses',
        'my_certificates'=>'my_certificates',
        'my_statements'=>'my_statements',
        'my_orders'=>'my_orders',
        'client_request'=>'client_request',
        'company_request'=>'company_request',
        'instructor_request'=>'instructor_request',
        'employee_request'=>'employee_request',
        'cooperative_traning' => 'cooperative_traning',
        'certificate_verfication'=>'certificate_verfication',
        'login'=>'login',
        'register'=>'register',
        'instructors'=>'instructors',
        'services'=>'services',
        'service'=>'service',
        'cooperativeـtraining'=>'cooperativeـtraining',
        'images_gallery'=>'images_gallery',
        'joining_requests' => 'joining_requests',
        'create' => 'create',
        'show' => 'show',
        'job-seeker-request' => 'job-seeker-request',
        'reset_password'=>'reset_password',
        'marketer_request'=>'marketer_request',
    ];

    const SCHEMATPES = [
        "Course"=> "Course",
        "CourseInstance"=> "CourseInstance",
        "EducationalOrganization"=> "EducationalOrganization",
        "Person"=> "Person",
        "EducationalOccupationalProgram"=> "EducationalOccupationalProgram",
        "CreativeWork"=> "CreativeWork",
        "ItemList"=> "ItemList",
        "Offer"=> "Offer",
        "LocalBusiness "=> "LocalBusiness",
        "Article"=> "Article",
        'FAQPage'=>'FAQPage',
        'AggregateRating'=>'AggregateRating',
    ];

    protected $fillable = [
        'page_type',
        'schema_types',
        'title',
        'slug',
        'meta_title',
        'meta_desc',
        'index',
    ];

    protected $casts = [
        'schema_types' => 'array',
        'title' => 'array',
        'slug' => 'array',
        'meta_title' => 'array',
        'meta_desc' => 'array',
        'index' => 'boolean',
    ];

    public $translatable = ['title','slug','meta_title','meta_desc']; // translatable attributes

}
