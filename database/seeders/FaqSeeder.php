<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // 1. Pertanyaan Umum
            ['question' => 'Apa saja jenis tas yang dijual di Cikal Tas?', 'answer' => 'Kami menjual berbagai jenis tas, termasuk tas ransel, sling bag, tas kulit, tote bag, tas laptop, dan banyak lagi.'],
            ['question' => 'Apakah ada tas untuk wanita?', 'answer' => 'Ya, kami memiliki berbagai tas wanita, termasuk tas tangan, tote bag, dan tas ransel fashion.'],
            ['question' => 'Apakah tas ransel tersedia?', 'answer' => 'Ya, kami memiliki berbagai model tas ransel dengan berbagai ukuran dan desain.'],
            ['question' => 'Apa yang membedakan tas ransel dan sling bag?', 'answer' => 'Tas ransel biasanya memiliki dua tali untuk dipakai di punggung, sementara sling bag hanya memiliki satu tali yang digunakan di bahu atau silang di tubuh.'],
            ['question' => 'Apakah tas laptop tersedia?', 'answer' => 'Ya, kami menyediakan tas ransel yang khusus untuk laptop, tersedia dalam berbagai ukuran.'],
            ['question' => 'Tas apa yang cocok untuk traveling?', 'answer' => 'Kami merekomendasikan tas ransel traveling dan tas koper untuk kebutuhan traveling Anda.'],
            
            // 2. Harga dan Pembayaran
            ['question' => 'Berapa harga tas ransel di Cikal Tas?', 'answer' => 'Harga tas ransel di Cikal Tas mulai dari Rp200.000 hingga Rp500.000, tergantung pada model dan bahan.'],
            ['question' => 'Apakah ada diskon atau promo untuk tas?', 'answer' => 'Kami sering mengadakan promo diskon, Anda dapat memeriksa bagian "Promo" di website kami untuk melihat penawaran terbaru.'],
            ['question' => 'Bagaimana cara mengetahui harga tas terbaru?', 'answer' => 'Harga tas terbaru dapat dilihat langsung di halaman produk atau melalui notifikasi promo yang kami kirimkan melalui email.'],
            
            // 3. Metode Pengiriman
            ['question' => 'Apa saja pilihan pengiriman yang tersedia?', 'answer' => 'Kami menawarkan berbagai pilihan pengiriman termasuk reguler, ekspres, dan same-day delivery untuk beberapa lokasi.'],
            ['question' => 'Apakah ada pengiriman gratis?', 'answer' => 'Pengiriman gratis tersedia untuk pembelian di atas Rp500.000, berlaku untuk wilayah Jakarta dan sekitarnya.'],
            ['question' => 'Berapa lama waktu pengiriman untuk tas yang dipesan?', 'answer' => 'Waktu pengiriman tergantung pada lokasi Anda. Pengiriman reguler biasanya memakan waktu 2-5 hari kerja.'],
            
            // 4. Stok dan Ketersediaan
            ['question' => 'Apakah tas sling bag warna hitam tersedia?', 'answer' => 'Kami sedang memeriksa ketersediaan stok tas sling bag warna hitam. Stok produk kami selalu diperbarui secara berkala.'],
            ['question' => 'Bagaimana cara mengecek stok produk yang saya inginkan?', 'answer' => 'Anda dapat mengecek stok produk dengan mencarinya di halaman produk atau melalui chatbot ini dengan menyebutkan nama produk.'],
            ['question' => 'Apakah tas ransel masih tersedia?', 'answer' => 'Ya, tas ransel yang Anda cari masih tersedia. Stok produk kami saat ini tersedia cukup banyak.'],
            
            // 5. Proses Pemesanan
            ['question' => 'Bagaimana cara memesan tas di Cikal Tas?', 'answer' => 'Pilih tas yang Anda inginkan, klik "Tambah ke Keranjang", lalu lanjutkan ke checkout untuk menyelesaikan pembayaran.'],
            ['question' => 'Apakah saya bisa membeli tas secara langsung di website?', 'answer' => 'Ya, Anda dapat membeli tas langsung di website dengan mengikuti proses checkout dan memilih metode pembayaran.'],
            
            // 6. Kebijakan Pengembalian
            ['question' => 'Apakah Cikal Tas menerima pengembalian produk?', 'answer' => 'Ya, kami menerima pengembalian produk dalam waktu 1 hari setelah pembelian jika produk dalam kondisi tidak terpakai dan kemasan asli.'],
            ['question' => 'Apakah ada garansi untuk tas yang dibeli?', 'answer' => 'Ya, kami memberikan garansi 1 bulan untuk tas dengan kerusakan yang disebabkan oleh cacat produksi.'],
            
            // 7. Custom Tas
            ['question' => 'Apakah saya bisa membuat tas custom di Cikal Tas?', 'answer' => 'Ya, kami menyediakan layanan custom tas. Anda bisa memilih bahan, warna, ukuran, dan desain tas sesuai keinginan.'],
            ['question' => 'Bagaimana cara memesan tas custom?', 'answer' => 'Anda bisa mengisi formulir spesifikasi untuk menentukan desain tas custom Anda. Formulir ini mencakup pilihan bahan, ukuran, warna, dan fitur khusus.'],
            ['question' => 'Apakah saya bisa mendesain tas sendiri?', 'answer' => 'Tentu! Setelah mengisi formulir spesifikasi, tim kami akan menghubungi Anda untuk membahas desain lebih lanjut.'],
            
            // 8. Lokasi
            ['question' => 'Apakah saya bisa membeli tas langsung di toko?', 'answer' => 'Ya, Anda dapat mengunjungi toko fisik kami di Jakarta, atau menghubungi kami untuk informasi lebih lanjut.'],
            ['question' => 'Di mana lokasi Cikal Tas?', 'answer' => 'Kami memiliki toko di Jakarta. Silakan hubungi kami jika Anda ingin datang langsung.'],
        ];

        foreach ($faqs as $faq) {
            \App\Models\Faq::create($faq);
        }
    }
}
