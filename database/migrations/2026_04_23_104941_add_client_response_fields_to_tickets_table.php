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
            // Ajouter seulement les champs qui n'existent pas
            if (!Schema::hasColumn('tickets', 'client_response')) {
                $table->string('client_response')->nullable()->after('status');
            }
            if (!Schema::hasColumn('tickets', 'client_response_at')) {
                $table->timestamp('client_response_at')->nullable()->after('client_response');
            }
            if (!Schema::hasColumn('tickets', 'client_response_code')) {
                $table->string('client_response_code')->nullable()->after('client_response_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'guest_email',
                'client_response',
                'client_response_at',
                'client_response_code'
            ]);
        });
    }
};
