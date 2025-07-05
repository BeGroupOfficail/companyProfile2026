<?php
namespace App\Http\Middleware;

use App\Models\Dashboard\Setting\WebsiteDesign;
use Closure;
use Illuminate\Support\Facades\View;

class ApplyWebsiteDesignMiddleware
{
    public function handle($request, Closure $next)
    {
        $design = WebsiteDesign::getActiveDesign();
        $designFolder = $design ? $design->folder : 'design1'; // Fallback design
        View::addNamespace('designs', resource_path('views/website-designs/' . $designFolder));
        View::addNamespace('designs.auth', resource_path('views/auth/website-designs/' . $designFolder));
        view()->share('currentDesign', $designFolder);
        return $next($request);
    }
}
