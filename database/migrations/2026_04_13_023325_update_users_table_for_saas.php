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
        Schema::table('users', function (Blueprint $table) {
            // Rôle global (super_admin = accès à toutes les entreprises)
            $table->enum('global_role', ['super_admin', 'user'])->default('user')->after('email');
            // Entreprise actuellement sélectionnée
            $table->foreignId('current_company_id')->nullable()->after('global_role')->constrained('companies')->onDelete('set null');
            // Soft delete
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['global_role', 'current_company_id', 'deleted_at']);
        });
    }
};
