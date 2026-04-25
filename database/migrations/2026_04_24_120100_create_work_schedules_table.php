<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('counter_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Horaires de travail
            $table->time('morning_start')->default('07:00:00')->comment('Heure début matin');
            $table->time('morning_end')->default('12:00:00')->comment('Heure fin matin / début pause');
            $table->time('afternoon_start')->default('14:00:00')->comment('Heure début après-midi / fin pause');
            $table->time('afternoon_end')->default('17:30:00')->comment('Heure fin journée');
            
            // Jours de travail (JSON: [1,2,3,4,5] pour Lundi-Vendredi)
            $table->json('working_days')->default('[1,2,3,4,5]')->comment('Jours de travail: 1=Lundi, 7=Dimanche');
            
            // Configuration et statut
            $table->boolean('is_active')->default(true)->comment('Planning actif ou non');
            $table->string('timezone')->default('Europe/Paris')->comment('Fuseau horaire');
            $table->text('notes')->nullable()->comment('Notes sur le planning');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes pour optimisation
            $table->index(['company_id', 'is_active']);
            $table->index(['service_id', 'is_active']);
            $table->index(['counter_id', 'is_active']);
            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
