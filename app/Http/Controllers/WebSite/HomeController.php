<?php

namespace App\Http\Controllers\WebSite;

use App\Actions\CourseFilter;
use App\Helper\Path;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ContactUsRequest;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\ContactUs;
use App\Models\Dashboard\About\AboutUs;
use App\Models\Dashboard\About\AboutValue;
use App\Models\Dashboard\Client\Client;
use App\Models\Dashboard\Course\Field;
use App\Models\Dashboard\Destination\Destination;
use App\Models\Dashboard\Page\Page;
use App\Models\Dashboard\Region;
use App\Models\Dashboard\Service;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Setting\HomepageSection;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\Testimonial\Testimonial;
use App\Models\Dashboard\Tour\Tour;
use App\Models\User;
use App\Services\Website\SeoService;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends Controller
{

    protected $seoService;
    protected $settings;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->settings = Setting::firstOrFail();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lang = app()->getLocale();

        $sliders = Slider::where('lang',$lang)->where('status','published')->get();
        $aboutUs = AboutUs::firstOrFail();
        $about_values = AboutValue::where('type','mission_and_vision')->where('status', 'published')->limit(3)->get();
        $workingSteps = AboutValue::where('type','working_steps')->where('status', 'published')->limit(3)->get();
        $regions = Region::get();
        $blogs = Blog::with('category')->where('status', 'published')->where('home', 1)->limit(3)->get();
        $tours = Tour::with('destination')->where('status', 'published')->where('home',1)->where('featured',1)->limit(9)->get();
        $homepageSections = HomepageSection::where('is_active', '1')->orderBy('order')->get();
        $homeServices = Service::where('status', 'published')->where('home', 1)->limit(3)->get();
        /**
         * handel seo data and send it your blade
         */
        $settings = $this->settings;
        $seoData = $this->seoService->generateSeoData(
            pageType: 'home',
            additionalData: [
                'image' => Path::uploadedImage('settings', $settings->logo),
            ],
            schemaType: 'EducationalOrganization'
        );

        return view('designs::home', compact('homeServices','sliders', 'homepageSections', 'workingSteps','about_values', 'blogs', 'seoData','aboutUs','regions','tours'));
    }

    public function about_us()
    {
        $aboutUs = AboutUs::first();
        $about_values = AboutValue::where('type','mission_and_vision')->where('status', 'published')->limit(3)->get();
        $workingSteps = AboutValue::where('type','working_steps')->where('status', 'published')->limit(3)->get();
        $testimonials = Testimonial::get();
        $seoData = $this->seoService->generateSeoData(
            pageType: 'about_us',
            additionalData: [
                'image' => asset('images/custom-home-og.jpg'),
            ],
            schemaType: 'EducationalOrganization'
        );
        return view('designs::about_us', compact('seoData', 'aboutUs','about_values','workingSteps','testimonials'));
    }
    public function contact_us()
    {
        $aboutUs = AboutUs::first();
        $seoData = $this->seoService->generateSeoData(
            pageType: 'contact_us',
            additionalData: [
                'image' => asset('images/custom-home-og.jpg'),
            ],
            schemaType: ''
        );
        return view('designs::contact_us', compact('seoData', 'aboutUs'));
    }
    public function contact_us_save(ContactUsRequest $request)
    {
        $validated_data = $request->validated();
        ContactUs::create($validated_data);
        return back()->with(['success' => trans('home.Thank you for contacting us. A customer service officer will contact you soon')]);
    }

    public function page(Page $page)
    {
        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $page->meta_title ? $page->meta_title : $this->settings->site_name . ' | '.$page->name,
                'description' => $page->meta_desc ? $page->meta_desc : $this->settings->site_name . ' | '.$page->short_desc,
                'image' => \App\Helper\Path::uploadedImage('settings',$this->settings->main_logo),
                'url' => LaravelLocalization::localizeUrl('pages/' . $page->slug),
                'favicon' =>  \App\Helper\Path::uploadedImage('settings',$this->settings->fav_icon),
                'robots' => ($page->index == 1) ? 'index,follow' : 'noindex,nofollow',
            ],
            schemaType: ''
        );
        return view('designs::page', compact('page','seoData'));
    }

    public function services(){
        $homeServices = Service::where('status','published')->get();

        /**
         * handel seo data and send it your blade
         */
        $settings = $this->settings;
        $seoData = $this->seoService->generateSeoData(
            pageType: 'services',
            additionalData: [
                'image' => Path::uploadedImage('settings', $settings->logo),
            ],
            schemaType: 'EducationalOrganization'
        );

        return view('designs::services',compact('homeServices','seoData'));
    }
    public function service(Service $service){

        /**
         * handel seo data and send it your blade
         */
        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $service->meta_title ? $page->meta_title : $this->settings->site_name . ' | '.$service->name,
                'description' => $service->meta_desc ? $page->meta_desc : $this->settings->site_name . ' | '.$service->short_desc,
                'image' => \App\Helper\Path::uploadedImage('settings',$this->settings->main_logo),
                'url' => LaravelLocalization::localizeUrl('pages/' . $service->slug),
                'favicon' =>  \App\Helper\Path::uploadedImage('settings',$this->settings->fav_icon),
                'robots' => ($service->index == 1) ? 'index,follow' : 'noindex,nofollow',
            ],
            schemaType: ''
        );

        return view('designs::service',compact('service','seoData'));
    }
    public function destinations(){
        $destinations = Destination::orderBy('id')->where('status','published')->get();

        /**
         * handel seo data and send it your blade
         */
        $settings = $this->settings;
        $seoData = $this->seoService->generateSeoData(
            pageType: 'destinations',
            additionalData: [
                'image' => Path::uploadedImage('settings', $settings->logo),
            ],
            schemaType: 'EducationalOrganization'
        );

        return view('designs::destinations',compact('destinations','seoData'));
    }

    public function destination(Destination $destination){
        $tours = Tour::where('destination_id',$destination->id)->where('status','published')->orderBy('id')->get();

        /**
         * handel seo data and send it your blade
         */
        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $destination->meta_title ? $destination->meta_title : $this->settings->site_name . ' | '.$destination->name,
                'description' => $destination->meta_desc ? $destination->meta_desc : $this->settings->site_name . ' | '.$destination->short_desc,
                'image' => \App\Helper\Path::uploadedImage('settings',$this->settings->main_logo),
                'url' => LaravelLocalization::localizeUrl('pages/' . $destination->slug),
                'favicon' =>  \App\Helper\Path::uploadedImage('settings',$this->settings->fav_icon),
                'robots' => ($destination->index == 1) ? 'index,follow' : 'noindex,nofollow',
            ],
            schemaType: ''
        );

        return view('designs::destination_tours',compact('destination','tours','seoData'));
    }

    public function tours(){
        $tours = Tour::orderBy('id')->where('status','published')->get();

        /**
         * handel seo data and send it your blade
         */
        $settings = $this->settings;
        $seoData = $this->seoService->generateSeoData(
            pageType: 'tours',
            additionalData: [
                'image' => Path::uploadedImage('settings', $settings->logo),
            ],
            schemaType: 'EducationalOrganization'
        );
        return view('designs::tours',compact('tours','seoData'));
    }
    public function Tour(Tour $tour){
        $relatedTours = Tour::where('destination_id',$tour->destination_id)->orderBy('id','DESC')->where('status','published')->limit(9)->get();
        return view('designs::tour_details',compact('tour','relatedTours'));
    }

}
