<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('prefix', 5)->default('A');
            $table->integer('current_number')->default(0);
            $table->enum('status', ['active', 'paused', 'closed'])->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('estimated_service_time')->default(5);
            $table->integer('missed_timeout')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
