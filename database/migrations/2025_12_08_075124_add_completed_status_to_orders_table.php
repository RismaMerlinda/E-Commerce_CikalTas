<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note: SQLite tidak mendukung MODIFY COLUMN. Status sudah didefinisikan
     * lengkap di create_orders_table migration.
     */
    public function up(): void
    {
        // SQLite tidak support ALTER TABLE MODIFY COLUMN.
        // Status 'processing' dan 'completed' sudah ditambahkan ke migration awal.
        // Migration ini dibiarkan kosong agar kompatibel dengan SQLite.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
