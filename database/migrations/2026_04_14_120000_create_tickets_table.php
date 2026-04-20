<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tickets')) {
            return;
        }

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('counter_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Informations client
            $table->string('guest_name')->nullable();
            $table->string('guest_phone')->nullable();
            
            // Numéro de ticket (ex: A023)
            $table->string('number', 10);
            $table->string('prefix', 5); // A, B, C...
            $table->integer('sequence'); // 1, 2, 3...
            
            // Statut
            $table->enum('status', [
                'WAITING',
                'CALLED',
                'SERVING',
                'SERVED',
                'MISSED_TEMP',
                'CANCELLED',
                'TRANSFERRED'
            ])->default('WAITING');
            
            // Compteur d'absences
            $table->tinyInteger('missed_count')->default(0);
            $table->timestamp('missed_at')->nullable();
            
            // Timestamps opérationnels
            $table->timestamp('called_at')->nullable();
            $table->timestamp('served_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->integer('service_time_seconds')->nullable(); // Temps de service
            
            // Priorité (pour file prioritaire)
            $table->tinyInteger('priority')->default(0); // 0 = normal, 1-5 = prioritaire
            
            // Notes
            $table->text('notes')->nullable();
            $table->string('cancellation_reason')->nullable();
            
            $table->timestamps();
            
            // Index pour performance
            $table->index(['company_id', 'service_id', 'status', 'created_at']);
            $table->index(['company_id', 'status', 'created_at']);
            $table->index(['counter_id', 'status']);
            $table->index(['number', 'company_id']);
            $table->unique(['company_id', 'service_id', 'prefix', 'sequence', 'created_at'], 'ticket_unique_per_day');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
