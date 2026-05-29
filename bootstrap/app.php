<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenant' => \App\Http\Middleware\IdentifyTenant::class,
            'super_admin_auth' => \App\Http\Middleware\SuperAdminAuth::class,
            'cache.store' => \App\Http\Middleware\CacheStoreResponse::class,
            'plan.business' => \App\Http\Middleware\EnsureBusinessPlanModules::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
