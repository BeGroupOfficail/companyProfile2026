<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\ContactInfoResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SocialLinksResource;
use App\Http\Resources\StatisticResource;
use App\Models\Dashboard\About\AboutUs;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Service\Service;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use App\Models\Dashboard\Sections\CompanySection;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SubSectionResource;
use App\Models\Dashboard\Sections\CompanySubSection;
use Illuminate\Support\Facades\Cache;

use function App\Helper\apiResponse;

class HomeController extends Controller
{
    public function index()
    {
        // ── Sliders ──────────────────────────────────────────────
        $sliders = Slider::where('status', 'published')
            ->orderBy('order')
            ->get();

        // ── About ────────────────────────────────────────────────
        $about = AboutUs::first();

        // ── Statistics ───────────────────────────────────────────
        $statistics = WebsiteStatistics::where('status', 'published')->get();

        // ── Services (top-level only) ────────────────────────────
        $services = Service::where('status', 'published')
            ->whereNull('parent_id')
            ->get();

        // ── Projects (eager load images — avoids N+1) ────────────
        $projects = Project::where('status', 'published')
            ->with(['images' => fn($q) => $q->orderBy('sort_order')])
            ->latest()
            ->get();

        // ── Settings (contact + social) ──────────────────────────
        $settings = Cache::rememberForever('settings', fn() => Setting::first());

        // ── SEO ──────────────────────────────────────────────────
        $seoService = app(\App\Services\Dashboard\Seo\CompanySeoService::class);
        $seo = $seoService->getSeo();
        $seoData = [
            'meta_tags' => [
                'content_type' => $seo->content_type,
                'title' => $seo->getTranslation('title', app()->getLocale()) ?? '',
                'author' => $seo->getTranslation('author', app()->getLocale()) ?? '',
                'description' => $seo->getTranslation('description', app()->getLocale()) ?? '',
                'canonical' => $seo->getTranslation('canonical', app()->getLocale()) ?? '',
                'robots' => $seo->robots,
            ],
            'open_graph' => $seo->open_graph ?? new \stdClass(),
            'twitter_card' => $seo->twitter_card ?? new \stdClass(),
            'hreflang_tags' => $seo->hreflang_tags ?? new \stdClass(),
            'schema' => $seo->schema ?? [],
        ];

        // ── Sections ─────────────────────────────────────────────
        // $sections = CompanySection::where('is_active', 1)
        //     ->with(['subSections' => function($query) {
        //         $query->orderBy('sort_order')->with(['items' => function($q) {
        //             $q->orderBy('sort_order');
        //         }]);
        //     }])
        //     ->orderBy('sort_order')
        //     ->get();
        // get collection
        $subSections = CompanySubSection::with('items')
            ->orderBy('sort_order')
            ->get();

        // group by keys
        $grouped = [
            'standards'       => SubSectionResource::collection($subSections->where('key', 'standards')->values()),
            'step_by_step'    => SubSectionResource::collection($subSections->where('key', 'step_by_step')->values()),
            'quality_control' => SubSectionResource::collection($subSections->where('key', 'quality_control')->values()),
            'project_risks'   => SubSectionResource::collection($subSections->where('key', 'project_risks')->values()),
        ];

        // ── Build response ───────────────────────────────────────
        $data = [
            'home'      => ["description" => $settings->site_desc,"sliders"=>SliderResource::collection($sliders)],
            'about'        => $about ? AboutResource::make($about) : null,
            'statistics'   => StatisticResource::collection($statistics),
            'services'     => ServiceResource::collection($services),
            'projects'     => ProjectResource::collection($projects),
            // 'sections'     => SectionResource::collection($sections),
            'sections'     => $grouped,
            'contact'      => $settings ? ContactInfoResource::make($settings) : null,
            'social_links' => $settings ? SocialLinksResource::make($settings) : [],
            'seo'          => $seoData,
        ];

        return apiResponse(200, $data, __('dash.Home data loaded successfully'));
    }
}
