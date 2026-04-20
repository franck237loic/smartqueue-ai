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
        Schema::table('tickets', function (Blueprint $table) {
            // Mettre à jour l'ENUM pour inclure tous les statuts nécessaires
            $table->enum('status', [
                'waiting',
                'called', 
                'serving',
                'served',
                'missed',
                'cancelled',
                'transferred'
            ])->default('waiting')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Revenir à l'ENUM original si nécessaire
            $table->enum('status', [
                'waiting',
                'called', 
                'served',
                'missed'
            ])->default('waiting')->change();
        });
    }
};
