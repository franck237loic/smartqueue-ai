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
            $table->enum('status', [
                'WAITING',
                'CALLED',
                'PRESENT',
                'SERVING',
                'SERVED',
                'MISSED_TEMP',
                'CANCELLED',
                'TRANSFERRED'
            ])->default('WAITING')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', [
                'WAITING',
                'CALLED',
                'SERVING',
                'SERVED',
                'MISSED_TEMP',
                'CANCELLED',
                'TRANSFERRED'
            ])->default('WAITING')->change();
        });
    }
};
