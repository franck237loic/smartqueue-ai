<?php

namespace App\Console\Commands;

use App\Services\TicketService;
use Illuminate\Console\Command;

class CheckMissedTickets extends Command
{
    protected $signature = 'tickets:check-missed';
    protected $description = 'Vérifie les tickets appelés et marque comme absents ceux qui ont dépassé le délai';

    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        parent::__construct();
        $this->ticketService = $ticketService;
    }

    public function handle(): int
    {
        $this->info('Vérification des tickets absents...');

        $this->ticketService->checkMissedTimeouts();

        $this->info('Vérification terminée.');

        return Command::SUCCESS;
    }
}
