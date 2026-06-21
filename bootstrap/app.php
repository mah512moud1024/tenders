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
        $middleware->redirectTo(
            guests: '/login',
            users: function () {
                $user = auth()->user();
                if ($user) {
                    return $user->hasRole('admin')
                        ? route('filament.admin.pages.dashboard', absolute: false)
                        : route('filament.account.pages.dashboard', absolute: false);
                }
                return '/';
            }
        );
        $middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);
        $middleware->alias([
            'approved' => \App\Http\Middleware\CheckServiceProviderApproval::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
