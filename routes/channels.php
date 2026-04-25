<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Company;
use App\Models\Service;
use App\Models\Ticket;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Channel utilisateur privé
Broadcast::channel('user.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel entreprise - tous les employés de l'entreprise
Broadcast::channel('company.{companyId}', function (User $user, $companyId) {
    $company = Company::find($companyId);
    return $company && $user->hasAccessToCompany($company);
});

// Channel service - agents et clients du service
Broadcast::channel('service.{serviceId}', function (User $user, $serviceId) {
    $service = Service::find($serviceId);
    return $service && $user->hasAccessToCompany($service->company);
});

// Channel ticket - client du ticket et agent assigné
Broadcast::channel('ticket.{ticketId}', function (User $user, $ticketId) {
    $ticket = Ticket::find($ticketId);
    if (!$ticket) return false;
    
    // Le client du ticket ou l'agent assigné
    return $user->hasAccessToCompany($ticket->company) && 
           ($user->id === $ticket->user_id || $user->id === $ticket->agent_id);
});

// Channel agents - tous les agents de l'entreprise
Broadcast::channel('agents.{companyId}', function (User $user, $companyId) {
    $company = Company::find($companyId);
    return $company && $user->isAgentInCompany($company);
});

// Channel public display - pour les écrans d'affichage
Broadcast::channel('public.{companyId}', function (User $user, $companyId) {
    $company = Company::find($companyId);
    return $company && $user->hasAccessToCompany($company);
});

// Channel notifications sonores
Broadcast::channel('sounds.{companyId}', function (User $user, $companyId) {
    $company = Company::find($companyId);
    return $company && $user->hasAccessToCompany($company);
});

// Channel statistiques temps réel
Broadcast::channel('stats.{companyId}', function (User $user, $companyId) {
    $company = Company::find($companyId);
    return $company && $user->hasAccessToCompany($company);
});
