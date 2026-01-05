<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama_lengkap' => 'Lucinta Luna',
            'email' => 'lucinta@cikaltas.com',
            'password' => bcrypt('password'),
            'nomor_telepon' => '081234567890',
            'provinsi_kota' => 'Jakarta',
            'alamat_jalan' => 'Jl. Contoh No. 123',
        ]);

        // Seed products
        $this->call([
            ProductSeeder::class,
        ]);
    }
}
