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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('prefix', 10);
            $table->text('description')->nullable();
            $table->integer('estimated_service_time')->default(5); // minutes
            $table->integer('missed_timeout')->default(3); // minutes
            $table->integer('max_daily_tickets')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('working_hours')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'prefix']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
