<?php

namespace App\Providers;

use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Destination\Destination;
use App\Models\Dashboard\Menu\Menu;
use App\Models\Dashboard\Page\Page;
use App\Models\Dashboard\Service;
use App\Models\SystemFile;
use App\Services\Website\SeoService;
use App\Models\Dashboard\Setting\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register seo service to be used
        $this->app->singleton(SeoService::class, function ($app) {
            return new SeoService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);

        // Share data with all views
        view()->composer('*', function($view) {
            $lang = app()->getLocale();

            // Cache all the queries with appropriate durations
            $settings = Cache::remember('settings', now()->addHours(48), function () {
                return Setting::first();
            });

            $headMenu = Cache::remember('head_menu', now()->addHours(48), function () {
                return Menu::with('items')->where('id', 1)->where('status', 'published')->first();
            });

            $footerMenu = Cache::remember('footer_menu', now()->addHours(48), function () {
                return Menu::with('items')->where('id', 2)->where('status', 'published')->first();
            });

            $header_services =  Service::where('status', 'published')->where('menu', 1)->get();

            $header_blogs =  Blog::where('status', 'published')->where('menu', 1)->select('id', 'name', 'slug')->get();

            $header_blog_categories =BlogCategory::where('status', 'published')->where('menu', 1)->select('id', 'name', 'slug')->get();

            $header_pages =Page::where('status', 'published')->where('menu', 1)->select('id', 'name', 'slug')->get();

            $pages =  Page::where('status', 'published')->get();

            $headerDestinations = Destination::where('status', 'published')->where('menu', 1)->get();
            $headerTours = Destination::where('status', 'published')->where('menu', 1)->get();

            // Share all data with views
            $view->with([
                'lang' => $lang,
                'settings' => $settings,
                'headMenu' => $headMenu,
                'footerMenu' => $footerMenu,
                'header_services' => $header_services,
                'header_blogs' => $header_blogs,
                'header_blog_categories' => $header_blog_categories,
                'header_pages' => $header_pages,
                'pages' => $pages,
                'headerDestinations' => $headerDestinations,
                'headerTours' => $headerTours,
            ]);
        });


        // Custom directive to get substrings
        Blade::directive('substr', function ($expression) {
            return "<?php echo substr($expression); ?>";
        });
    }
}
