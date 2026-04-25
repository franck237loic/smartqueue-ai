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
        // First, drop the existing enum column
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Then add the enhanced enum with all required states
        Schema::table('counters', function (Blueprint $table) {
            $table->enum('status', ['closed', 'open', 'paused', 'auto_closed', 'offline'])
                  ->default('closed')
                  ->after('location');
        });

        // Add new timestamp fields for enhanced tracking
        Schema::table('counters', function (Blueprint $table) {
            $table->timestamp('paused_at')->nullable()->after('opened_at');
            $table->timestamp('auto_closed_at')->nullable()->after('closed_at');
            $table->timestamp('offline_at')->nullable()->after('auto_closed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the new timestamp fields
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn(['paused_at', 'auto_closed_at', 'offline_at']);
        });

        // Drop the enhanced enum
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Restore the original enum (backward compatibility)
        Schema::table('counters', function (Blueprint $table) {
            $table->enum('status', ['open', 'closed', 'busy'])->default('closed')->after('location');
        });
    }
};
