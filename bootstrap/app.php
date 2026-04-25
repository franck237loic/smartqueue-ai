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
    ->withSchedule(function ($schedule): void {
        // Notifications de queue toutes les 2 minutes
        $schedule->command('smartqueue:process-notifications')
            ->everyTwoMinutes()
            ->withoutOverlapping()
            ->runInBackground()
            ->description('Process queue notifications');

        // Mise à jour des statistiques toutes les 5 minutes
        $schedule->command('smartqueue:update-performance-stats')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground()
            ->description('Update performance statistics');

        // Gestion automatique des guichets chaque minute
        $schedule->command('smartqueue:auto-manage-counters')
            ->everyMinute()
            ->withoutOverlapping()
            ->runInBackground()
            ->description('Auto manage counters based on work schedules');

        // Nettoyage des anciens tickets annulés (tous les jours à minuit)
        $schedule->command('smartqueue:cleanup-old-tickets')
            ->daily()
            ->at('00:00')
            ->withoutOverlapping()
            ->description('Cleanup old cancelled tickets');
    })
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
        $middleware->group('saas', [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\EnsureBelongsToCompany::class,
        ]);

        // Middleware group pour agents uniquement
        $middleware->group('agent.only', [
            \App\Http\Middleware\AgentOnly::class,
        ]);

        // Middleware group pour les invités (non authentifiés)
        $middleware->group('guest', [
            \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
