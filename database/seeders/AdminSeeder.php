<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@cikaltas.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nomor_telepon' => '081234567890',
            'provinsi_kota' => 'Jakarta',
            'alamat_jalan' => 'Jl. Admin No. 1',
            'detail_lainnya' => 'Kantor Pusat CikalTas',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@cikaltas.com');
        $this->command->info('Password: admin123');
    }
}
