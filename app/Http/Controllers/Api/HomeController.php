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

        // ── Sections ─────────────────────────────────────────────
        $sections = CompanySection::where('is_active', 1)
            ->with(['subSections' => function($query) {
                $query->orderBy('sort_order')->with(['items' => function($q) {
                    $q->orderBy('sort_order');
                }]);
            }])
            ->orderBy('sort_order')
            ->get();

        // ── Build response ───────────────────────────────────────
        $data = [
            'home'      => ["description" => $settings->site_desc,"sliders"=>SliderResource::collection($sliders)],
            'about'        => $about ? AboutResource::make($about) : null,
            'statistics'   => StatisticResource::collection($statistics),
            'services'     => ServiceResource::collection($services),
            'projects'     => ProjectResource::collection($projects),
            'sections'     => SectionResource::collection($sections),
            'contact'      => $settings ? ContactInfoResource::make($settings) : null,
            'social_links' => $settings ? SocialLinksResource::make($settings) : [],
        ];

        return apiResponse(200, $data, __('dash.Home data loaded successfully'));
    }
}
