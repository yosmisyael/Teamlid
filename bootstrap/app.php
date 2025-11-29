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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'company.setup' => \App\Http\Middleware\EnsureAdminHasCompany::class,
            'admin.auth' => \App\Http\Middleware\AuthenticateAdmin::class,
            'admin.redirect' => \App\Http\Middleware\RejectAuthenticatedAdmin::class,
            'employee.redirect' => \App\Http\Middleware\RedirectAuthenticatedEmployees::class,
            'employee.auth' => \App\Http\Middleware\EnsureEmployeeAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
