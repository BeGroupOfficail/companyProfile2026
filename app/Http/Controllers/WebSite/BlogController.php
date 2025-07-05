<?php

namespace App\Http\Controllers\WebSite;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Setting\Setting;
use App\Services\Website\SeoService;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Helper\WebsiteHelper;

class BlogController extends Controller
{

    protected $seoService;
    protected $settings;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->settings = Setting::firstOrFail();
    }

    public function blogs()
    {
        $blogs = Blog::with('category')->where('status', 'published')->paginate(9);
        $seoData = $this->seoService->generateSeoData(
            pageType: 'blogs',
            additionalData: [],
            schemaType: 'EducationalOrganization'
        );
        return view('designs::blogs', compact('blogs', 'seoData'));
    }


    public function blog(Blog $blog)
    {
        $relatedBlogs = $blog->relatedBlogs();
        $previousBlog = Blog::where('id', '<', $blog->id)
            ->orderBy('id', 'desc')
            ->first();

        // Get next blog (older one with larger ID)
        $nextBlog = Blog::where('id', '>', $blog->id)
            ->orderBy('id', 'asc')
            ->first();

        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $blog->meta_title ? $blog->meta_title : $this->settings->site_name . ' | '.$blog->name,
                'description' => $blog->meta_desc ? $blog->meta_desc : $this->settings->site_name . ' | '.$blog->short_desc,
                'image' => \App\Helper\Path::uploadedImage('settings',$this->settings->main_logo),
                'url' => LaravelLocalization::localizeUrl('blogs/' . $blog->slug),
                'favicon' =>  \App\Helper\Path::uploadedImage('settings',$this->settings->fav_icon),
                'robots' => ($blog->index == 1) ? 'index,follow' : 'noindex,nofollow',
            ],
            schemaType: 'Blog'
        );

        return view('designs::blog', compact('blog', 'seoData', 'relatedBlogs','previousBlog','nextBlog'));
    }
}
