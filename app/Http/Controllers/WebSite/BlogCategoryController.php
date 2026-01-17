<?php

namespace App\Http\Controllers\WebSite;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Setting\Setting;
use App\Services\Website\SeoService;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BlogCategoryController extends Controller
{
    protected $seoService;
    protected $settings;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
        $this->settings = Setting::firstOrFail();
    }

    protected function handelSeoData($blogCategory)
    {
        $settings = $this->settings;

        $schemaTypes = ['EducationalOrganization', 'LocalBusiness', 'Article'];
        $seoData = $this->seoService->generateElementSeoData(
            elementData: [
                'title' => $blogCategory->meta_title ? $blogCategory->meta_title : $blogCategory->name,
                'description' => $blogCategory->meta_desc ? $blogCategory->meta_desc : $this->settings->site_name . ' | ' . $blogCategory->short_desc,
                'image' => \App\Helper\Path::uploadedImage('blogs', $blogCategory->image),
                'url' => LaravelLocalization::localizeUrl('blog-category/' . $blogCategory->slug),
                'favicon' => \App\Helper\Path::uploadedImage('settings', $this->settings->fav_icon),
                'robots' => $blogCategory->index == 1 ? 'index,follow' : 'noindex,nofollow',
                'model' => $blogCategory,
                'created_at' => $blogCategory->created_at,
                'updated_at' => $blogCategory->updated_at,
            ],

            otherData: [
                'author' => $this->settings->site_name,
                'published_at' => $blogCategory->created_at->toIso8601String(),
                'modified_at' => $blogCategory->updated_at->toIso8601String(),

                'name' => $this->settings->site_name,
                'url' => LaravelLocalization::localizeUrl('blog-category/' . $blogCategory->slug),
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
            ],

            schemaTypes: $schemaTypes,
        );

        return $seoData;
    }

    public function blog_category(BlogCategory $blogCategory, Request $request)
    {
        $categories = $request->input('categories', []); // get categories if present, else empty array
        $blogs = Blog::with('category')->where('status', 'published');
        $blogCategoryModel = $blogCategory->getTranslation('name','ar')=="المدونة";
        $news_category_ids = $blogCategory->where('name->ar','الأخبار و الأنشطة')
            ->orwhere('name->ar','الاخبار')
            ->orwhere('name->ar','الأخبار والفعاليات')
            ->get()->pluck('id')->toArray();
        if($blogCategoryModel){
            if (!empty($categories)) {
                // for blogs in modwana with fiter
                $blogs = $blogs->whereIn('blog_category_id', $categories)
                  ->orderByRaw('(SELECT `created_at` FROM blog_categories WHERE blog_categories.id = blogs.blog_category_id) asc')
                    ->orderBy('order_date', 'desc');
            } elseif(count($news_category_ids)){
                // for blogs in modwana without fiter == not in el akhabra
                $blogs = $blogs->whereNotIn('blog_category_id',[$news_category_ids] )->orderBy('order_date','desc');
            }
        }else{
            $blogs = $blogs->where('blog_category_id', $blogCategory->id)->orderBy('order_date','desc');
        }

        $blogs = $blogs->paginate(12);

        $seoData = $this->handelSeoData($blogCategory);
        $blog_categories = BlogCategory::where('status', 'published')
            ->select('id', 'name')->get();

        return view('designs::blogs', compact('blogs', 'seoData', 'blogCategory', 'blog_categories'));
    }
}
