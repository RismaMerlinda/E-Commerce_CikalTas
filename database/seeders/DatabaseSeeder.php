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

        User::updateOrCreate(
            ['email' => 'lucinta@cikaltas.com'],
            [
                'nama_lengkap' => 'Lucinta Luna',
                'password' => bcrypt('password'),
                'nomor_telepon' => '081234567890',
                'provinsi_kota' => 'Jakarta',
                'alamat_jalan' => 'Jl. Contoh No. 123',
            ]
        );

        // Seed products, admins, dan FAQs
        $this->call([
            AdminSeeder::class,
            ProductSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
