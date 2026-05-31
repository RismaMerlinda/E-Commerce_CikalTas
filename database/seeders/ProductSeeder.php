<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $products = [

            // ==================== RANSEL DEWASA PRIA ====================
            [
                'name'        => 'Ransel Pria Urban Tactical Hitam',
                'description' => 'Tas ransel pria dewasa dengan desain urban tactical modern. Material nylon 900D anti air, dilengkapi 3 kompartemen utama, 2 kantong samping botol, slot laptop 15.6 inch, port USB eksternal, tali bahu ergonomis berpadding tebal. Cocok untuk kerja, kuliah, dan traveling harian. Dimensi: 45x30x18cm, kapasitas 30L.',
                'price'       => 189000,
                'stock'       => 25,
                'category'    => 'Ransel Pria Dewasa',
                'color'       => 'Hitam',
                'image'       => 'produk/ransel-pria-hitam.jpg',
            ],
            [
                'name'        => 'Ransel Pria Casual Navy Minimalis',
                'description' => 'Ransel pria dewasa gaya casual minimalis warna navy elegan. Bahan polyester premium 600D tahan lama, kompartemen laptop 14 inch terpadding, kantong organizer depan, back panel berlubang untuk sirkulasi udara. Desain simpel cocok untuk kerja kantoran maupun santai. Dimensi: 43x28x16cm, kapasitas 25L.',
                'price'       => 159000,
                'stock'       => 30,
                'category'    => 'Ransel Pria Dewasa',
                'color'       => 'Navy',
                'image'       => 'produk/ransel-pria-navy.jpg',
            ],
            [
                'name'        => 'Ransel Pria Outdoor Olive Green',
                'description' => 'Ransel pria dewasa seri outdoor dengan warna olive green maskulin. Konstruksi militer-inspired, material ripstop nylon tahan goresan, sistem MOLLE di bagian depan, frame internal aluminium ringan, tali pinggang berpadding. Ideal untuk hiking ringan, camping, atau aktivitas outdoor. Dimensi: 50x32x20cm, kapasitas 40L.',
                'price'       => 225000,
                'stock'       => 18,
                'category'    => 'Ransel Pria Dewasa',
                'color'       => 'Olive Green',
                'image'       => 'produk/ransel-pria-olive.jpg',
            ],

            // ==================== RANSEL ANAK LAKI-LAKI ====================
            [
                'name'        => 'Ransel Anak Cowok Dinosaurus Biru',
                'description' => 'Tas ransel anak laki-laki motif dinosaurus yang lucu dan imut. Bahan polyester lembut dan ringan, dilengkapi tali dada pengaman, back panel ergonomis berpadding untuk kenyamanan punggung anak, kompartemen utama + kantong depan, kantong samping botol minum. Aman untuk anak usia 4-10 tahun. Dimensi: 36x25x12cm, kapasitas 15L.',
                'price'       => 119000,
                'stock'       => 40,
                'category'    => 'Ransel Anak Laki-laki',
                'color'       => 'Biru',
                'image'       => 'produk/ransel-anak-cowo-biru.jpg',
            ],
            [
                'name'        => 'Ransel Anak Cowok Superhero Merah',
                'description' => 'Ransel sekolah anak laki-laki tema superhero keren warna merah. Material nylon ringan dan kuat, ritsleting ganda anti bocor, tali bahu adjustable dengan padding lembut, kantong samping termos, cermin reflektif untuk keselamatan. Cocok untuk TK hingga SD kelas 3. Dimensi: 34x24x12cm, kapasitas 13L.',
                'price'       => 109000,
                'stock'       => 35,
                'category'    => 'Ransel Anak Laki-laki',
                'color'       => 'Merah',
                'image'       => 'produk/ransel-anak-cowo-merah.jpg',
            ],

            // ==================== RANSEL ANAK PEREMPUAN ====================
            [
                'name'        => 'Ransel Anak Cewek Bunga Pink Manis',
                'description' => 'Tas ransel anak perempuan motif bunga-bunga cantik warna pink soft. Bahan polyester premium anti gores, tali bahu ergonomis adjustable, kompartemen luas untuk buku sekolah + kantong depan organizer, kantong samping untuk botol minum, gantungan kunci imut sudah termasuk. Untuk anak usia 4-10 tahun. Dimensi: 36x25x12cm, kapasitas 15L.',
                'price'       => 115000,
                'stock'       => 38,
                'category'    => 'Ransel Anak Perempuan',
                'color'       => 'Pink',
                'image'       => 'produk/ransel-anak-cewe-pink.jpg',
            ],
            [
                'name'        => 'Ransel Anak Cewek Unicorn Ungu',
                'description' => 'Ransel sekolah anak perempuan tema unicorn warna ungu pastel menggemaskan. Dilengkapi hiasan glitter halus, sequin reversible di bagian depan, tali bahu berpadding lembut, saku organizer depan, sangat ringan hanya 350 gram. Untuk anak usia 5-12 tahun. Dimensi: 38x26x13cm, kapasitas 16L.',
                'price'       => 125000,
                'stock'       => 32,
                'category'    => 'Ransel Anak Perempuan',
                'color'       => 'Ungu',
                'image'       => 'produk/ransel-anak-cewe-ungu.jpg',
            ],

            // ==================== TAS LAPTOP ====================
            [
                'name'        => 'Tas Laptop Profesional Abu 15.6"',
                'description' => 'Tas ransel laptop profesional untuk pria/wanita dewasa, cocok untuk pekerja kantoran dan mahasiswa. Kompartemen laptop berpadding khusus muat hingga 15.6 inch, kompartemen tablet terpisah, kantong organizer lengkap untuk charger, mouse, kabel, port USB charging eksternal, bahan polyester anti air. Dimensi: 48x30x18cm, kapasitas 28L.',
                'price'       => 245000,
                'stock'       => 20,
                'category'    => 'Tas Laptop',
                'color'       => 'Abu-abu',
                'image'       => 'produk/tas-laptop-abu.jpg',
            ],
            [
                'name'        => 'Tas Laptop Slim Hitam 14"',
                'description' => 'Tas laptop slim dan ringan untuk profesional muda. Desain ramping namun muat laptop 14 inch dengan bantalan anti-shock, kompartemen dokumen A4, tali bahu adjustable, handle kulit sintetis premium, material nylon hitam elegan. Bobot sangat ringan hanya 450 gram. Dimensi: 38x28x8cm.',
                'price'       => 195000,
                'stock'       => 22,
                'category'    => 'Tas Laptop',
                'color'       => 'Hitam',
                'image'       => 'produk/tas-laptop-hitam.jpg',
            ],

            // ==================== TAS SELEMPANG ====================
            [
                'name'        => 'Tas Selempang Pria Kulit Coklat',
                'description' => 'Tas selempang pria crossbody berbahan kulit sintetis premium warna coklat elegan. Desain compact namun muat smartphone, dompet, powerbank, kunci. Satu kompartemen utama + saku depan ritsleting, tali adjustable panjang, aksesoris logam antik. Cocok untuk hangout, traveling kota, dan kerja casual. Dimensi: 22x16x6cm.',
                'price'       => 129000,
                'stock'       => 28,
                'category'    => 'Tas Selempang',
                'color'       => 'Coklat',
                'image'       => 'produk/tas-selempang-pria-coklat.jpg',
            ],
            [
                'name'        => 'Tas Selempang Wanita Hitam Elegan',
                'description' => 'Tas selempang wanita serbaguna dan elegan warna hitam klasik. Bahan PU leather premium, desain minimalis modern, kompartemen dalam berlapis dengan cermin kecil and kantong kartu, tali rantai logam adjustable bisa dilepas. Cocok untuk kerja, belanja, maupun acara semi-formal. Dimensi: 25x18x8cm.',
                'price'       => 135000,
                'stock'       => 25,
                'category'    => 'Tas Selempang',
                'color'       => 'Hitam',
                'image'       => 'produk/tas-selempang-wanita-hitam.jpg',
            ],

            // ==================== TAS WANITA ====================
            [
                'name'        => 'Tas Tote Wanita Canvas Krem',
                'description' => 'Tas tote wanita ukuran besar berbahan canvas premium warna krem natural. Sangat spacious muat laptop 13", buku, kosmetik, dan kebutuhan harian. Handle kulit asli yang kuat, inner pocket ritsleting, pocket depan luar. Desain minimalis Skandinavian yang timeless. Dimensi: 40x35x12cm.',
                'price'       => 165000,
                'stock'       => 22,
                'category'    => 'Tas Tote',
                'color'       => 'Krem',
                'image'       => 'produk/tas-tote-krem.jpg',
            ],
            [
                'name'        => 'Tas Kulit Wanita Shoulder Brown',
                'description' => 'Tas bahu wanita premium berbahan kulit sintetis berkualitas tinggi warna coklat tua. Desain structured semi-formal dengan hardware gold mewah, kompartemen berlapis dengan tempat kartu, ritsleting atas, tali bahu adjustable+detachable. Cocok untuk kantor dan acara formal. Dimensi: 32x22x10cm.',
                'price'       => 210000,
                'stock'       => 15,
                'category'    => 'Tas Wanita',
                'color'       => 'Coklat',
                'image'       => 'produk/tas-kulit-coklat.jpg',
            ],

            // ==================== TAS CLUTCH ====================
            [
                'name'        => 'Tas Clutch Wanita Hitam Mewah',
                'description' => 'Tas clutch wanita elegan untuk malam dan acara formal. Bahan PU leather glossy hitam, penutup flap magnetic, strap tangan detachable, dalam berlapis dengan saku cermin dan kartu. Aksesoris gold hardware. Muat smartphone, lipstik, kartu, dan uang kecil. Dimensi: 22x12x4cm.',
                'price'       => 99000,
                'stock'       => 20,
                'category'    => 'Tas Clutch',
                'color'       => 'Hitam',
                'image'       => 'produk/tas-clutch-hitam.jpg',
            ],
            [
                'name'        => 'Tas Wanita Sling Mini Elegan',
                'description' => 'Tas mini sling wanita gaya terkini yang cute dan fungsional. Bahan velvet premium warna hijau emerald, gesper emas vintage, tali panjang adjustable, kompartemen dalam + kantong ritsleting. Ukuran mini namun tetap muat essentials: HP, kartu, lipstik. Dimensi: 18x13x5cm.',
                'price'       => 89000,
                'stock'       => 30,
                'category'    => 'Tas Wanita',
                'color'       => 'Hijau Emerald',
                'image'       => 'produk/tas-wanita-elegan.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✅ ' . count($products) . ' produk CikalTas berhasil ditambahkan!');
    }
}
