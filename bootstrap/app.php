<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware aliases pour les routes SaaS
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureHasRole::class,
            'belongs.to.company' => \App\Http\Middleware\EnsureBelongsToCompany::class,
            'isSuperAdmin' => \App\Http\Middleware\IsSuperAdmin::class,
            'isCompanyAdmin' => \App\Http\Middleware\IsCompanyAdmin::class,
            'isAgent' => \App\Http\Middleware\IsAgent::class,
        ]);

        // Middleware group pour SaaS authentifié
        $middleware->appendToGroup('saas', [
            'auth',
            'belongs.to.company',
        ]);

        // Middleware group pour agents uniquement
        $middleware->appendToGroup('agent.only', [
            \App\Http\Middleware\AgentOnly::class,
        ]);

        // Middleware group pour les invités (non authentifiés)
        $middleware->appendToGroup('guest', [
            \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
