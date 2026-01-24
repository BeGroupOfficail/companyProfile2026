<?php

namespace App\Providers;

use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Menu\Menu;
use App\Models\Dashboard\Page\Page;
use App\Models\Dashboard\Service\Service;
use App\Models\Dashboard\Setting\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);

        // Share data with all views
        view()->composer('*', function ($view) {
            $lang = app()->getLocale();

            // Cache settings
            $settings = Cache::remember('settings', now()->addHours(24), function () {
                return Setting::first();
            });

            // Cache menus (only necessary fields)
            $headMenu = Cache::remember('head_menu', now()->addHours(24), function () {
                return Menu::with('published_items')->where('id', 1)->where('status', 'published')->select('id', 'name')->first();
            });

            $footerMenu = Cache::remember('footer_menu', now()->addHours(24), function () {
                return Menu::with('published_items')->where('id', 2)->where('status', 'published')->select('id', 'name')->first();
            });

            // Cache blogs
            $header_blogs = Cache::remember('header_blogs', now()->addHours(24), function () {
                return Blog::where('status', 'published')->where('menu', 1)->select('id', 'name')
                    ->orderBy('order_date','desc')->get();
            });

            // Cache blog categories
            $header_blog_categories = Cache::remember('header_blog_categories', now()->addHours(24), function () {
                return BlogCategory::where('status', 'published')->where('menu', 1)
                    ->select('id', 'name', 'slug')->get();
            });

            $header_pages = Page::where('status', 'published')->where('menu', 1)->select('id', 'name')->get();
            $menu_services = Service::where('status', 'published')->where('menu', 1)->select('id', 'name','slug')->get();
            $pages = Page::where('status', 'published')->get();

            // Share all data with views
            $view->with([
                'lang' => $lang,
                'settings' => $settings,
                'headMenu' => $headMenu,
                'footerMenu' => $footerMenu,
                'header_blogs' => $header_blogs,
                'header_blog_categories' => $header_blog_categories,
                'header_pages' => $header_pages,
                'pages' => $pages,
                'menu_services'=>$menu_services,
            ]);
        });

        // Custom Blade directive to get substrings
        Blade::directive('substr', function ($expression) {
            return "<?php echo substr($expression); ?>";
        });

    }
}
