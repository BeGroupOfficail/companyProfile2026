<?php

namespace App\Http\Controllers\WebSite;

use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Setting\WebsiteDesign;
use Carbon\Carbon;
use App\Helper\Path;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Actions\CourseFilter;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Page\Page;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Course\Field;
use App\Models\Dashboard\About\AboutUs;
use App\Models\Dashboard\Client\Client;
use App\Models\Dashboard\Course\Course;
use App\Models\Dashboard\Package\Package;
use App\Models\Dashboard\Service\Service;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\Testimonial\Testimonial;
use App\Models\Dashboard\Training\Training;
use App\Models\Dashboard\Video\Video;
use App\Services\Website\SeoService;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Dashboard\About\AboutValue;
use App\Models\Dashboard\ContactUs\ContactUs;
use App\Models\Dashboard\Training\TrainingDay;
use App\Http\Requests\Website\ContactUsRequest;
use App\Models\Dashboard\Course\Category;
use App\Models\Dashboard\Faq\Faq;
use App\Models\Dashboard\Setting\HomepageSection;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\GoogleTagManager\GoogleTagManagerFacade as GTM;

class HomeController extends Controller
{

    protected $seoService;
    protected $settings;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->settings = Setting::firstOrFail();
    }

    protected function handelSeoData($page){
        $settings = $this->settings;

        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $page->meta_title ? $page->meta_title : $this->settings->site_name . ' | ' . $page->name,
                'description' => $page->meta_desc ? $page->meta_desc : $this->settings->site_name . ' | ' . $page->short_desc,
                'image' => \App\Helper\Path::uploadedImage('settings', $this->settings->logo),
                'url' => LaravelLocalization::localizeUrl('page/' . $page->slug),
                'favicon' => \App\Helper\Path::uploadedImage('settings', $this->settings->fav_icon),
                'robots' => ($page->index == 1) ? 'index,follow' : 'noindex,nofollow',
                'model'=>$page,
                'created_at'=>$page->created_at,
                'updated_at'=>$page->updated_at,
            ],

            otherData: [
                'author' => $this->settings->site_name,
                'published_at' => $page->created_at->toIso8601String(),
                'modified_at' => $page->updated_at->toIso8601String(),

                'name' => $this->settings->site_name,
                'url' => url('/'),
                'logo' => Path::uploadedImage('settings', $settings->logo),
                'social_links' => [
                    'facebook' => $settings->facebook_address,
                    'twitter' => $settings->twitter_address,
                    'threads' => $settings->threads_address,
                    'youtube' => $settings->youtube_address,
                    'instagram' => $settings->instagram_address,
                    'linkedin' => $settings->linkedin_address,
                ],
                'address' => [
                    'street' => $settings->address1,
                    'area' => $settings->area->name ?? null,
                    'region' => $settings->region->name ?? null,
                    'postal_code' => $settings->postal_code ?? null,
                    'country' => $settings->country->name ?? null,
                ],
                'phone' => $settings->phone1 ?? null,
                'telephone' => $settings->telephone ?? null,
                'opening_hours'=>$settings->working_hours ?? null,
            ],

            schemaTypes: ['EducationalOrganization', 'LocalBusiness' , 'Article']
        );

        return $seoData;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $settings = $this->settings;
        $lang = app()->getLocale();
        //$home_categories = Category::withCount('published_course')->where('status', 'published')->where('home', 1)->get();
        $home_fields = Field::where('status', 'published')->where('type','course')->where('home', 1)->get();
        $fellowship_fields = Field::where('status', 'published')->where('type','fellowship')->where('home', 1)->get();
        $fellowship_categories = Category::where('status', 'published')->where('type','fellowship')->where('home', 1)->get();
        $fellowships = Training::with('training_courses')->where('status', 'published')->where('main_type','fellowship')->latest()->limit(8)->get();
        $featureCourses = Course::with('category', 'public_reviews', 'public_chapters')->where('status', 'published')
            ->where('home', 1)
            ->orderBy('order')
            ->limit(12)
            ->get();
        $sliders = Slider::where('lang', $lang)->where('status', 'published')->get();
        $clients = Client::where('status', 'published')->where('home', 'published')->get();
        $blogs = Blog::with('category')->where('status', 'published')->where('home', 1)->latest()->limit(3)->get();
        $activeDesign = WebsiteDesign::getActiveDesign();
        $allBlogsRoute = LaravelLocalization::localizeUrl('/blogs');
    
        if ($activeDesign && $activeDesign->name === 'BeTraining') {
            $category = BlogCategory::find(2);
            if ($category) {
                $allBlogsRoute = LaravelLocalization::localizeUrl("blog-category/{$category->slug}");
            }
        }
        $testimonials = Testimonial::where('status', 'published')->get();
        $homepageSections = HomepageSection::where('is_active', '1')->orderBy('order')->get();
        $services = Service::where('status', 'published')->where('home', 1)->limit(3)->get();
        $videos = Video::get();
        $about_album = Album::with('images')->where('status', 'published')
            ->where('type', 'about_album')
            ->first();
        $all_about_values = AboutValue::where('status', 'published')->get();

        $about_values = $all_about_values->where('type', 'mission_and_vision')->sortBy('order') ->take(3);
        $benefits = $all_about_values->where('type', 'benefits')->sortBy('order');
        if(in_array($settings->getTranslation('site_name', $lang), ['MDIT', 'معهد التطوير الكلي للتدريب']))
        {
            $benefits = $all_about_values->where('type', 'benefits')->sortBy('order')->take(6);
        }
        $howToWorks = $all_about_values->where('type', 'working_steps')->take(3);
        $trainings = Training::with('course')->get();
        $diplomas = Training::where('main_type','diploma')->with('training_semesters')->get();
        $targetAudiances = $all_about_values->where('type', 'target_audiance')->take(6);
        $aboutUs = AboutUs::first();
        $packages = Package::where('home',1)->where('status', 'published')->get();
        $websiteStatistics = WebsiteStatistics::where('status', 'published')->get();
        $next_courses = Course::with('category')
            ->where('status', 'published')
            ->whereHas('trainings', function (Builder $q) {
                $q->where('start_date', '>', Carbon::today());
            })
            ->withMin(['trainings as next_training_start_date' => function ($q) {
                $q->where('start_date', '>', Carbon::today());
            }], 'start_date')
            ->orderBy('next_training_start_date', 'asc')->take(3)->get();

        $faqs = Faq::where('status', 'published')->where('home',1)->get();

        /**
         * handel seo data and send it your blade
         */
        $seoData = $this->seoService->handelSeoData('home');
        $course_types =  Course::COURSETYPES;

        return view('designs::home', compact('home_fields','course_types','fellowship_categories','fellowships','next_courses','packages', 'howToWorks', 'about_album', 'services', 'videos', 'sliders', 'homepageSections', 'benefits', 'clients', 'testimonials', 'featureCourses', 'about_values', 'blogs', 'seoData', 'aboutUs', 'targetAudiances', 'trainings','diplomas','websiteStatistics','faqs','fellowship_fields','allBlogsRoute'));
    }

    public function about_us()
    {
        $settings = $this->settings;
        $lang = app()->getLocale();
        $aboutUs = AboutUs::first();
        $websiteStatistics = WebsiteStatistics::where('status', 'published')->get();
        $benefits = AboutValue::where('type', 'benefits')->where('status', 'published')->limit(3)->get();
        if(in_array($settings->getTranslation('site_name', $lang), ['MDIT', 'معهد التطوير الكلي للتدريب']))
        {
            $benefits = AboutValue::where('type', 'benefits')->where('status', 'published')->limit(6)->get();
        }

        /**
         * handel seo data and send it your blade
         */
        $seoData = $this->seoService->handelSeoData('about_us');

        return view('designs::about_us', compact('seoData', 'aboutUs', 'benefits','websiteStatistics'));
    }
    public function contact_us()
    {
        $aboutUs = AboutUs::first();

        /**
         * handel seo data and send it your blade
         */
        $seoData = $this->seoService->handelSeoData('contact_us');

        return view('designs::contact_us', compact('seoData', 'aboutUs'));
    }
    public function contact_us_save(ContactUsRequest $request)
    {
        $validated_data = $request->validated();
        ContactUs::create($validated_data);
        // session()->flash('contact_form_submitted', true);
        GTM::push([
            'event' => 'generate_lead',
            'form_id' => 'contact_us',
        ]);

        return back()->with(['success' => trans('home.Thank you for contacting us. A customer service officer will contact you soon')]);
    }


    public function searchResult(Request $request, CourseFilter $filter, SeoService $seoService, FieldController $fieldController, CourseController $courseController)
    {
        if ($request->field_slug) {
            $field = Field::where('slug->en', 'like', '%' . $request->field_slug . '%')
                ->orWhere('slug->ar', 'like', '%' . $request->field_slug . '%')
                ->first();
            return $fieldController->field($field, $request, $filter, seoService: $seoService);
        } else {
            return $courseController->courses($request, $filter, seoService: $seoService);
        }
    }


    // public function instructor(User $instructor)
    // {
    //     $instructor->load('instructor_info', 'instructor_info.specialization', 'instructor_info.subSpecialization', 'instructor_info.nationality');
    //     return view('designs::instructor', compact('instructor'));
    // }

    public function page(Page $page)
    {
        $cleanSlug = Str::slug($page->slug);

        $duplicate = Page::where('id', '!=', $page->id)
            ->whereRaw('LOWER(REPLACE(slug, " ", "-")) = ?', [Str::lower($cleanSlug)])
            ->first();

        if ($duplicate) {
            // Optionally redirect or throw 404 if this slug already exists
            abort(404, 'Page URL is not unique');
        }

        $settings = $this->settings;
        $page->long_text = str_replace(
            '#call#',
            view('designs::call-buttons', compact('settings'))->render(),
            $page->long_text
        );

        $seoData = $this->handelSeoData($page);

        return view('designs::page', compact('page', 'seoData'));
    }

    public function joinZoom($id)
    {
        $trainingDay = TrainingDay::findOrFail($id);
        $description = $trainingDay->description;
        // Extract meeting ID
        preg_match('/zoom\.us\/j\/(\d+)/', $description, $idMatch);
        preg_match('/pwd=([^&]+)/', $description, $pwdMatch);

        if (!isset($idMatch[1])) {
            abort(404, 'Invalid Zoom link in description');
        }
        $meetingNumber = $idMatch[1];
        $password = $pwdMatch[1] ?? '';
        $userName = auth()->user()->name ?? 'Guest';
        $role = 0;
        // dd($password);
        return view('website-designs.HalalCenter.zoom_join', [
            'meetingNumber' => $meetingNumber,
            'password' => $password,
            'userName' => $userName,
            'role' => $role,
            'apiKey' => config('services.zoom.sdk_key'),
            'signature' => generateZoomSignature($meetingNumber, $role),
            'leaveUrl' => redirect()->back(), // Where user is redirected after leaving
        ]);
    }

    public function success_partners()
    {

        $clients = Client::where('status', 'published')->where('types','partners')->get();

        $seoData = $this->seoService->handelSeoData('success_partners');


        return view('designs::success_partners', compact('seoData', 'clients'));
    }

    public  function accreditations(SeoService $seoService)
    {
        $accreditations = Client::where('types', 'accreditations')->get();
        $pageType ='accreditations';
        $seoData = $this->seoService->handelSeoData($pageType);
        return view('designs::accrediations', compact('accreditations','seoData'));
    }


    public function thankYou()
    {

        return view('designs::ThanksPages.thanks');
    }

    // public function getInstructors()
    // {
    //     $instructors = User::where('job_role','instructor')->with('instructor_info')->paginate(18);
    //     $seoData = $this->seoService->handelSeoData('instructors');

    //     return view('designs::instructors',compact('instructors','seoData'));
    // }

    public function socialLinks(){
        $settings = $this->settings;
        $socialLinks = [
            'facebook' => $settings->facebook_address,
            'twitter' => $settings->twitter_address,
            'threads' => $settings->threads_address,
            'youtube' => $settings->youtube_address,
            'instagram' => $settings->instagram_address,
            'pinterest' => $settings->pinterest_address,
            'linkedin' => $settings->linkedin_address,
            'tiktok' => $settings->tiktok_address,
            'snapchat' => $settings->snapchat_address,
            'tumblr'  =>$settings->tumblr_address,
            'flickr' => $settings->flickr_address,
            'whatsapp' => $settings->phone2,
            'google_map' => $settings->google_map,
            'whatsapp_address' => $settings->whatsapp_address
        ];
        return view('designs::social_links', compact('socialLinks'));
    }

}
