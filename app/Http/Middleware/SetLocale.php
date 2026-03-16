<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Set the application locale based on the {lang} route parameter.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('lang');

        if ($locale && in_array($locale, ['en', 'ar'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
