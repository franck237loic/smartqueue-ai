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
        Schema::table('company_user', function (Blueprint $table) {
            // Index pour accélérer les recherches par user_id
            $table->index('user_id');
            // Index pour accélérer les recherches par is_default
            $table->index('is_default');
            // Index composite pour la requête fréquente user_id + is_default
            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_user', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_default']);
            $table->dropIndex(['user_id', 'is_default']);
        });
    }
};
