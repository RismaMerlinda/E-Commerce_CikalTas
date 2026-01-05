<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Tas Tangan Elegan MaiZura',
                'description' => 'Terbuat dari kulit sintetis premium',
                'price' => 120000,
                'stock' => 10,
                'category' => 'Tas Tangan',
            ],
            [
                'name' => 'Tas Selempang Cowok Kekinian',
                'description' => 'Terbuat dari kulit sintetis premium',
                'price' => 99000,
                'stock' => 15,
                'category' => 'Tas Selempang',
            ],
            [
                'name' => 'Tas Selempang Wanita Elegan',
                'description' => 'Terbuat dari kulit sintetis premium',
                'price' => 95000,
                'stock' => 12,
                'category' => 'Tas Selempang',
            ],
            [
                'name' => 'Tas Kulit Premium Brown',
                'description' => 'Tas kulit premium dengan desain minimalis',
                'price' => 150000,
                'stock' => 8,
                'category' => 'Tas Kulit',
            ],
            [
                'name' => 'Tas Selempang Multi Pocket',
                'description' => 'Tas dengan banyak kantong untuk penyimpanan optimal',
                'price' => 85000,
                'stock' => 20,
                'category' => 'Tas Selempang',
            ],
            [
                'name' => 'Tas Clutch Elegant',
                'description' => 'Tas clutch elegan untuk acara formal',
                'price' => 110000,
                'stock' => 7,
                'category' => 'Tas Clutch',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
