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
            // Rename 'name' to 'nama_lengkap'
            $table->renameColumn('name', 'nama_lengkap');

            // Add new columns
            $table->string('role')->default('user')->after('password');
            $table->string('nomor_telepon')->nullable()->after('role');
            $table->string('provinsi_kota')->nullable()->after('nomor_telepon');
            $table->text('alamat_jalan')->nullable()->after('provinsi_kota');
            $table->text('detail_lainnya')->nullable()->after('alamat_jalan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn(['role', 'nomor_telepon', 'provinsi_kota', 'alamat_jalan', 'detail_lainnya']);

            // Rename back to 'name'
            $table->renameColumn('nama_lengkap', 'name');
        });
    }
};
