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
        // Index pour la recherche rapide des agents
        Schema::table('company_user', function (Blueprint $table) {
            $table->index(['user_id', 'role'], 'idx_company_user_role');
            $table->index(['company_id', 'role'], 'idx_company_role');
        });

        // Index pour les requêtes tickets de l'agent
        Schema::table('tickets', function (Blueprint $table) {
            $table->index(['agent_id', 'company_id'], 'idx_ticket_agent_company');
            $table->index(['agent_id', 'status'], 'idx_ticket_agent_status');
            $table->index(['agent_id', 'company_id', 'status'], 'idx_ticket_agent_company_status');
            $table->index(['company_id', 'service_id', 'status'], 'idx_ticket_company_service_status');
            $table->index(['agent_id', 'served_at'], 'idx_ticket_agent_served');
            $table->index(['agent_id', 'updated_at', 'status'], 'idx_ticket_agent_updated_status');
        });

        // Index pour les requêtes de services
        Schema::table('services', function (Blueprint $table) {
            $table->index(['company_id', 'deleted_at'], 'idx_service_company_deleted');
        });

        // Index pour les requêtes de guichets
        Schema::table('counters', function (Blueprint $table) {
            $table->index(['company_id', 'user_id'], 'idx_counter_company_user');
            $table->index(['service_id', 'user_id'], 'idx_counter_service_user');
        });

        // Index pour les sessions (si ce n'est pas déjà fait)
        Schema::table('sessions', function (Blueprint $table) {
            $table->index('user_id', 'idx_sessions_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_user', function (Blueprint $table) {
            $table->dropIndex('idx_company_user_role');
            $table->dropIndex('idx_company_role');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex('idx_ticket_agent_company');
            $table->dropIndex('idx_ticket_agent_status');
            $table->dropIndex('idx_ticket_agent_company_status');
            $table->dropIndex('idx_ticket_company_service_status');
            $table->dropIndex('idx_ticket_agent_served');
            $table->dropIndex('idx_ticket_agent_updated_status');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('idx_service_company_deleted');
        });

        Schema::table('counters', function (Blueprint $table) {
            $table->dropIndex('idx_counter_company_user');
            $table->dropIndex('idx_counter_service_user');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex('idx_sessions_user');
        });
    }
};
