<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('WAITING','CALLED','PRESENT','SERVING','SERVED','MISSED_TEMP','MISSED','CANCELLED','TRANSFERRED') NOT NULL DEFAULT 'WAITING'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('WAITING','CALLED','PRESENT','SERVING','SERVED','MISSED_TEMP','CANCELLED','TRANSFERRED') NOT NULL DEFAULT 'WAITING'");
    }
};
