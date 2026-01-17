<?php

namespace App\Http\Controllers\WebSite;

use App\Helper\Path;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Setting\Setting;
use App\Services\Website\SeoService;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BlogController extends Controller
{

    protected $seoService;
    protected $settings;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->settings = Setting::firstOrFail();
    }

    protected function handelSeoData($blog) {
        $settings = $this->settings;

        $schemaTypes = ['EducationalOrganization', 'LocalBusiness', 'Article'];
        if (count($blog->blogFaqs) > 0) {
            $schemaTypes = ['EducationalOrganization', 'LocalBusiness', 'Article','FAQPage'];
        }

        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $blog->meta_title ? $blog->meta_title : $blog->name,
                'description' => $blog->meta_desc ? $blog->meta_desc : $this->settings->site_name . ' | ' . $blog->short_desc,
                'image' => \App\Helper\Path::uploadedImage('blogs', $blog->image),
                'url' => LaravelLocalization::localizeUrl('blog/' . $blog->slug),
                'favicon' => \App\Helper\Path::uploadedImage('settings', $this->settings->fav_icon),
                'robots' => ($blog->index == 1) ? 'index,follow' : 'noindex,nofollow',
                'created_at'=>$blog->created_at,
                'updated_at'=>$blog->updated_at,
                'model' => $blog,
            ],

            otherData: [
                'author' => $blog->author->name ?? $this->settings->site_name,
                'published_at' => $blog->created_at->toIso8601String(),
                'modified_at' => $blog->updated_at->toIso8601String(),

                'name' => $blog->author->name ?? $this->settings->site_name,
                'url' =>  LaravelLocalization::localizeUrl('blog/' . $blog->slug),
                'logo' => \App\Helper\Path::uploadedImage('settings', $settings->logo),
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
                'opening_hours' => $settings->working_hours ?? null,
                'faq_data' => $blog->blogFaqs
            ],

            schemaTypes: $schemaTypes
        );

        return $seoData;
    }

     public function blogs(Request $request)
    {
        $blogs = Blog::with('category')->where('status', 'published')
        ->orderBy('order_date', 'desc');
        if($request->categories){
            $blogs = $blogs->whereIn('blog_category_id',$request->categories);
        }
        $blogs = $blogs->paginate(12);
        $blog_categories = BlogCategory::where('status', 'published')->select('id','name')->get();
        $seoData = $this->seoService->handelSeoData('blogs');
        return view('designs::blogs', compact('blogs', 'seoData','blog_categories'));
    }


    public function blog(Blog $blog)
    {
        $blogs = Blog::with('category')->where('status', 'published')->orderBy('order_date', 'desc')->paginate(3);
        $relatedBlogs = $blog->relatedBlogs();
        $previousBlog = Blog::where('id', '<', $blog->id)
            ->orderBy('id', 'desc')
            ->first();

        // Get next blog (older one with larger ID)
        $nextBlog = Blog::where('id', '>', $blog->id)
            ->orderBy('id', 'asc')
            ->first();
        $blogFaq = Blog::with('blogFaqs')->find($blog->id);
        $settings = Setting::first();
        $blog_categories = BlogCategory::where('status', 'published')->select('id','name','slug')->paginate(5);
        // dd($settings);
        $blog->{'long_desc'} = str_replace('#call#', view('designs::call-buttons',compact('settings'))->render(), $blog->{'long_desc' });

        /**
         * handel seo data and send it your blade
         */
        $seoData = $this->handelSeoData($blog);


        return view('designs::blog', compact('blog', 'seoData', 'relatedBlogs', 'previousBlog', 'nextBlog','blogFaq','blogs','blog_categories'));
    }
}
