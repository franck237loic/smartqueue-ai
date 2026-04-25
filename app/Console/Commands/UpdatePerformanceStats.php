<?php

namespace App\Console\Commands;

use App\Services\TicketIntelligenceService;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UpdatePerformanceStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartqueue:update-performance-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update performance statistics for all companies';

    /**
     * Execute the console command.
     */
    public function handle(TicketIntelligenceService $intelligenceService): int
    {
        $this->info('Updating performance statistics...');

        try {
            $companies = Company::where('status', 'active')->get();
            
            $updatedCount = 0;
            foreach ($companies as $company) {
                $stats = $intelligenceService->getCompanyPerformanceStats($company);
                
                // Mettre en cache pour 5 minutes
                Cache::put("company_stats_{$company->id}", $stats, 300);
                
                $updatedCount++;
                
                $this->line("Updated stats for company: {$company->name}");
                
                // Afficher le score global
                $globalScore = $stats['global_score']['overall'] ?? 0;
                $grade = $stats['global_score']['grade'] ?? 'F';
                $this->info("  Global Score: {$globalScore}/100 (Grade: {$grade})");
            }

            $this->info("Performance statistics updated for {$updatedCount} companies");
            Log::info('Performance statistics updated', ['companies_count' => $updatedCount]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to update performance statistics: ' . $e->getMessage());
            Log::error('Performance statistics update failed', ['error' => $e->getMessage()]);
            
            return Command::FAILURE;
        }
    }
}
