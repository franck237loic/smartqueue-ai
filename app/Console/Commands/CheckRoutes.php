<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CheckRoutes extends Command
{
    protected $signature = 'check:routes';
    protected $description = 'Check for duplicate route names and redirect loops';

    public function handle(): void
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'methods' => implode('|', $route->methods()),
                'action' => $route->getActionName(),
            ];
        });

        // Check for duplicate names
        $names = $routes->pluck('name')->filter();
        $duplicates = $names->duplicates();

        if ($duplicates->isNotEmpty()) {
            $this->error('DUPLICATE ROUTE NAMES FOUND:');
            foreach ($duplicates as $name) {
                $this->error("  - {$name}");
                $matching = $routes->where('name', $name);
                foreach ($matching as $route) {
                    $this->warn("    {$route['methods']} {$route['uri']} => {$route['action']}");
                }
            }
        } else {
            $this->info('No duplicate route names found.');
        }

        // Check for redirect chains
        $this->info("\nAll routes:");
        foreach ($routes as $route) {
            if (str_contains($route['action'], 'Redirect') || str_contains($route['action'], 'dashboard')) {
                $this->warn("{$route['methods']} {$route['uri']} => {$route['action']}");
            }
        }
    }
}
