<?php

use Faker\Guesser\Name;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
    
        },

    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'IsOTPVerified' => \App\Http\Middleware\IsOTPVerified::class,
            'RevalidateBackHistory' => \App\Http\Middleware\RevalidateBackHistory::class
        ]);
        
        $middleware->validateCsrfTokens(except: [
            //'property/*',
        ]);
        // $middleware->alias([
        //     'IsOTPVerified' => \App\Http\Middleware\IsOTPVerified::class,
        //     'role'  =>  \App\Http\Middleware\RoleMiddleware::class,
        //     'RevalidateBackHistory' => \App\Http\Middleware\RevalidateBackHistory::class
        // ]);
        // $middleware->alias([
        //     'RevalidateBackHistory' => \App\Http\Middleware\RevalidateBackHistory::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
