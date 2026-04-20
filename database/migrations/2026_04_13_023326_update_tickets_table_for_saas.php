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
            // Clés étrangères SaaS (avec vérification)
            if (!Schema::hasColumn('tickets', 'company_id')) {
                $table->foreignId('company_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('tickets', 'service_id')) {
                $table->foreignId('service_id')->nullable()->after('company_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('tickets', 'counter_id')) {
                $table->foreignId('counter_id')->nullable()->after('service_id')->constrained()->nullOnDelete();
            }

            // Nouveaux champs (avec vérification)
            if (!Schema::hasColumn('tickets', 'client_name')) {
                $table->string('client_name', 150)->nullable()->after('number');
            }
            if (!Schema::hasColumn('tickets', 'client_phone')) {
                $table->string('client_phone', 20)->nullable()->after('client_name');
            }
            if (!Schema::hasColumn('tickets', 'estimated_wait_time')) {
                $table->integer('estimated_wait_time')->nullable()->comment('Minutes');
            }
            if (!Schema::hasColumn('tickets', 'actual_service_time')) {
                $table->integer('actual_service_time')->nullable()->comment('Minutes');
            }
            if (!Schema::hasColumn('tickets', 'served_at')) {
                $table->timestamp('served_at')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'transfer_reason')) {
                $table->string('transfer_reason', 255)->nullable();
            }

            // Modifier les timestamps existants
            if (Schema::hasColumn('tickets', 'called_at')) {
                $table->timestamp('called_at')->nullable()->change();
            }

            // Supprimer queue_id s'il existe
            if (Schema::hasColumn('tickets', 'queue_id')) {
                $table->dropForeign(['queue_id']);
                $table->dropColumn('queue_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('queue_id')->nullable()->constrained()->nullOnDelete();

            $table->dropForeign(['company_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['counter_id']);

            $table->dropColumn([
                'company_id',
                'service_id',
                'counter_id',
                'client_name',
                'client_phone',
                'estimated_wait_time',
                'actual_service_time',
                'served_at',
                'transfer_reason',
            ]);
        });
    }
};
