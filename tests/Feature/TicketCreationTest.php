<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Models\Service;
use App\Models\Counter;

class TicketCreationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test ticket creation to diagnose 500 error
     */
    public function test_ticket_creation_debug(): void
    {
        // Get first company
        $company = Company::first();
        if (!$company) {
            $this->markTestSkipped('No company found');
        }

        // Get first service
        $service = $company->services->first();
        if (!$service) {
            $this->markTestSkipped('No service found for company');
        }

        echo "Company: {$company->name} (ID: {$company->id})\n";
        echo "Service: {$service->name} (ID: {$service->id})\n";

        // Check counter
        $counter = Counter::where('service_id', $service->id)
            ->where('company_id', $company->id)
            ->first();
        echo "Counter: " . ($counter ? $counter->name : 'None') . "\n";

        // Test data
        $ticketData = [
            'service' => $service->id,
            'name' => 'Test User',
            'phone' => '123456789',
            'email' => 'test@example.com',
            'priority' => 'normal',
            '_token' => csrf_token(),
        ];

        try {
            // Test POST request
            $response = $this->post("/ticket/{$company->id}", $ticketData);
            
            echo "Response Status: " . $response->status() . "\n";
            
            if ($response->status() === 500) {
                echo "Response Content: " . $response->content() . "\n";
            }
            
            $response->assertStatus(200);
        } catch (\Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        }
    }
}
