<?php

namespace App\Http\Controllers\WebSite;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Setting\Setting;
use App\Services\Website\SeoService;

class BlogCategoryController extends Controller
{

    protected $seoService;
    protected $settings;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->settings = Setting::firstOrFail();
    }

    public function blog_category(BlogCategory $blogCategory)
    {
        $blogs = $blogCategory->public_blogs()->paginate(9);
        $seoData = $this->seoService->generateSeoData(
            pageType: 'blogs',
            additionalData: [
                'image' => asset('images/custom-home-og.jpg'),
            ],
            schemaType: 'EducationalOrganization'
        );
        return view('designs::blogs', compact('blogs', 'seoData','blogCategory'));     
    }
}
