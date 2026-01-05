<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter ENUM to add 'completed' and 'processing' status
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending', 'paid', 'processing', 'completed', 'failed', 'expired', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending', 'paid', 'failed', 'expired', 'cancelled') DEFAULT 'pending'");
    }
};
