<?php

namespace App\Http\Controllers\WebSite;

use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Setting\WebsiteDesign;
use Carbon\Carbon;
use App\Helper\Path;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Page\Page;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\About\AboutUs;
use App\Models\Dashboard\Client\Client;
use App\Models\Dashboard\Service\Service;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\Testimonial\Testimonial;
use App\Models\Dashboard\Video\Video;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Dashboard\About\AboutValue;
use App\Models\Dashboard\ContactUs\ContactUs;
use App\Http\Requests\Website\ContactUsRequest;
use App\Models\Dashboard\Setting\HomepageSection;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class HomeController extends Controller
{
    protected $settings;
    public function __construct()
    {
        $this->settings = Setting::firstOrFail();
    }

    public function index()
    {
        $lang = app()->getLocale();

        $homepageSections = HomepageSection::where('is_active', '1')->orderBy('order')->get();
        $sliders = Slider::where('lang', $lang)->where('status', 'published')->get();
        $services = Service::where('status', 'published')->where('home',1)->take(4)->get();
        $clients = Client::where('status', 'published')->where('home', 'published')->get();
        $recentProjectAlbums = Album::where('status', 'published')->where('type','projects')->take(6)->get();
        $projects_album = Album::with('images')->where('status', 'published')->where('type', 'project')->first();
        $aboutUs = AboutUs::first();
        $about_values = AboutValue::where('status', 'published')->get();
        $websiteStatistics = WebsiteStatistics::where('status', 'published')->get();
        $blogs = Blog::with('category')->where('status', 'published')->where('home', 1)->latest()->limit(3)->get();
        $testimonials = Testimonial::where('status', 'published')->get();

        return view('website.home',compact('homepageSections','sliders','services','projects_album','clients','aboutUs','about_values','websiteStatistics','testimonials','recentProjectAlbums','projects_album'));
    }

    public function about_us()
    {
        $aboutUs = AboutUs::first();
        $websiteStatistics = WebsiteStatistics::where('status', 'published')->get();
        $about_values = AboutValue::where('status', 'published')->get();

        return view('website.about_us', compact('aboutUs', 'about_values','websiteStatistics'));
    }

    public function contact_us()
    {
        return view('website.contact_us');
    }

    public function contact_us_save(ContactUsRequest $request)
    {
        $validated_data = $request->validated();
        ContactUs::create($validated_data);
        return back()->with(['success' => trans('home.Thank you for contacting us. A customer service officer will contact you soon')]);
    }

    public function services()
    {
        $services = Service::where('status', 'published')->get();
        return view('website.services', compact('services'));
    }

    public function serviceDetails(Service $service)
    {
        $relatedServices =Service::where('status', 'published')->get();
        return view('website.service_details', compact('service','relatedServices'));
    }

    public function projects()
    {
        $services = Service::where('status', 'published')->get();
        return view('website.projects', compact('services'));
    }

    public function projectDetails(Project $project)
    {
        return view('website.service_details', compact('project'));
    }

    public function pageDetails(Page $page)
    {
        return view('website.page_details', compact('page'));
    }

    public function clients()
    {
        $clients = Client::where('status', 'published')->get();
        return view('website.clients', compact('clients'));
    }

    public  function portfolio()
    {
        return view('website.portfolio');
    }
}
