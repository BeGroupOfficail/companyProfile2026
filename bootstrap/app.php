<?php

use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Register new middleware like this
        $middleware->append(\App\Http\Middleware\ApplyWebsiteDesignMiddleware::class);

        $middleware->prependToGroup('auth-admin', [
            Authenticate::class,
            IsAdminMiddleware::class,
        ]);

        $middleware->alias([
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        ]);

    })

    ->withProviders([
        App\Providers\MailConfigServiceProvider::class,
        // You can add more providers here if needed
    ])

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
