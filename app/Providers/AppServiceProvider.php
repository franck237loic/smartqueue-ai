<?php

namespace App\Providers;

use App\Services\AIEstimationService;
use App\Services\QueueService;
use App\Services\TicketService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TicketService::class);
        $this->app->singleton(QueueService::class);
        $this->app->singleton(AIEstimationService::class);
    }

    public function boot(): void
    {
        //
    }
}
