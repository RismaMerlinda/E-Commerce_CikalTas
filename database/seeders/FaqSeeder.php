<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::truncate();

        $faqs = [
            [
                'question' => 'Apa itu CikalTas?',
                'answer' => 'CikalTas adalah toko online yang menyediakan berbagai koleksi tas premium dengan desain stylish dan harga terjangkau.'
            ],
            [
                'question' => 'Di mana lokasi CikalTas?',
                'answer' => 'CikalTas berlokasi di Karanganyar, Tlaga, Kecamatan Gumelar, Kabupaten Banyumas, Jawa Tengah.'
            ],
            [
                'question' => 'Di mana lokasi Cikal Tas?',
                'answer' => 'CikalTas berlokasi di Karanganyar, Tlaga, Kecamatan Gumelar, Kabupaten Banyumas, Jawa Tengah.'
            ],
            [
                'question' => 'Apakah CikalTas melayani pengiriman ke luar kota?',
                'answer' => 'Ya, kami melayani pengiriman ke seluruh wilayah di Indonesia menggunakan ekspedisi terpercaya.'
            ],
            [
                'question' => 'Bagaimana cara memesan produk?',
                'answer' => 'Pilih produk di Beranda, klik Beli Sekarang atau tambah ke Keranjang, lalu lanjutkan ke Pembayaran.'
            ],
            [
                'question' => 'Bagaimana cara melihat status pesanan?',
                'answer' => 'Buka menu Pesanan untuk melihat daftar pesanan dan status pembayarannya.'
            ],
            [
                'question' => 'Saya gagal bayar atau pembayaran pending, harus bagaimana?',
                'answer' => 'Coba ulangi pembayaran melalui menu Pembayaran atau hubungi Help Desk.'
            ],
            [
                'question' => 'Bagaimana cara mengubah data profil?',
                'answer' => 'Ubah data pada halaman Profil lalu klik Simpan Perubahan.'
            ],
            [
                'question' => 'Apa fungsi menu Beranda?',
                'answer' => 'Untuk melihat katalog produk yang tersedia.'
            ],
            [
                'question' => 'Apa fungsi menu Keranjang?',
                'answer' => 'Untuk menyimpan produk yang akan dibeli.'
            ],
            [
                'question' => 'Apa fungsi menu Pesanan?',
                'answer' => 'Untuk melihat riwayat dan status pesanan.'
            ],
            [
                'question' => 'Apa fungsi menu Pembayaran?',
                'answer' => 'Untuk menyelesaikan transaksi pembelian.'
            ],
            [
                'question' => 'Apa fungsi menu Profil?',
                'answer' => 'Untuk mengelola informasi akun pengguna.'
            ],
            [
                'question' => 'Bagaimana cara mencari produk?',
                'answer' => 'Gunakan kolom Search di bagian atas halaman.'
            ],
            [
                'question' => 'Bagaimana cara melihat detail produk?',
                'answer' => 'Klik tombol Lihat Detail pada produk.'
            ],
            [
                'question' => 'Bagaimana cara membeli produk langsung?',
                'answer' => 'Klik tombol Beli Sekarang pada produk yang dipilih.'
            ],
            [
                'question' => 'Bagaimana cara menambahkan produk ke keranjang?',
                'answer' => 'Klik tombol + Keranjang.'
            ],
            [
                'question' => 'Apa itu Tas Tangan Elegan MaiZura?',
                'answer' => 'Tas tangan elegan berbahan kulit sintetis premium.'
            ],
            [
                'question' => 'Berapa harga Tas Tangan Elegan MaiZura?',
                'answer' => 'Rp120.000.'
            ],
            [
                'question' => 'Apa itu Tas Selempang Cowok Kekinian?',
                'answer' => 'Tas selempang pria dengan desain modern.'
            ],
            [
                'question' => 'Berapa harga Tas Selempang Cowok Kekinian?',
                'answer' => 'Rp99.000.'
            ],
            [
                'question' => 'Apa itu Tas Selempang Wanita Elegan?',
                'answer' => 'Tas selempang wanita dengan tampilan elegan.'
            ],
            [
                'question' => 'Berapa harga Tas Selempang Wanita Elegan?',
                'answer' => 'Rp95.000.'
            ],
            [
                'question' => 'Apa itu Tas Kulit Premium Brown?',
                'answer' => 'Tas kulit premium dengan desain minimalis.'
            ],
            [
                'question' => 'Berapa harga Tas Kulit Premium Brown?',
                'answer' => 'Rp150.000.'
            ],
            [
                'question' => 'Apa itu Tas Selempang Multi Pocket?',
                'answer' => 'Tas dengan banyak kantong penyimpanan.'
            ],
            [
                'question' => 'Berapa harga Tas Selempang Multi Pocket?',
                'answer' => 'Rp85.000.'
            ],
            [
                'question' => 'Apa itu Tas Clutch Elegant?',
                'answer' => 'Tas clutch yang cocok digunakan untuk acara formal.'
            ],
            [
                'question' => 'Berapa harga Tas Clutch Elegant?',
                'answer' => 'Rp110.000.'
            ],
            [
                'question' => 'Produk mana yang paling murah?',
                'answer' => 'Tas Selempang Multi Pocket dengan harga Rp85.000.'
            ],
            [
                'question' => 'Produk mana yang paling mahal?',
                'answer' => 'Tas Kulit Premium Brown dengan harga Rp150.000.'
            ],
            [
                'question' => 'Tas apa yang cocok untuk wanita?',
                'answer' => 'Tas Tangan Elegan MaiZura and Tas Selempang Wanita Elegan.'
            ],
            [
                'question' => 'Tas apa yang cocok untuk pria?',
                'answer' => 'Tas Selempang Cowok Kekinian and Tas Kulit Premium Brown.'
            ],
            [
                'question' => 'Tas apa yang cocok untuk aktivitas harian?',
                'answer' => 'Tas Selempang Multi Pocket.'
            ],
            [
                'question' => 'Tas apa yang cocok untuk acara formal?',
                'answer' => 'Tas Clutch Elegant.'
            ],
            [
                'question' => 'Apakah semua produk memiliki gambar?',
                'answer' => 'Ya, setiap produk dilengkapi gambar.'
            ],
            [
                'question' => 'Apakah semua produk memiliki deskripsi?',
                'answer' => 'Ya, setiap produk memiliki deskripsi singkat.'
            ],
            [
                'question' => 'Apakah harga produk ditampilkan di beranda?',
                'answer' => 'Ya, harga dapat dilihat langsung pada halaman beranda.'
            ],
            [
                'question' => 'Apakah produk menggunakan bahan premium?',
                'answer' => 'Ya, sebagian besar menggunakan bahan premium.'
            ],
            [
                'question' => 'Apakah stok produk selalu tersedia?',
                'answer' => 'Stok dapat berubah sesuai ketersediaan.'
            ],
            [
                'question' => 'Bagaimana cara mengetahui stok produk?',
                'answer' => 'Informasi stok dapat dilihat pada halaman detail produk.'
            ],
            [
                'question' => 'Apakah tersedia fitur pencarian?',
                'answer' => 'Ya, tersedia fitur pencarian untuk membantu menemukan produk.'
            ],
            [
                'question' => 'Bagaimana cara menemukan tas wanita?',
                'answer' => 'Gunakan fitur pencarian atau lihat kategori produk wanita.'
            ],
            [
                'question' => 'Bagaimana cara menemukan tas pria?',
                'answer' => 'Gunakan fitur pencarian atau lihat kategori produk pria.'
            ],
            [
                'question' => 'Bagaimana cara mengetahui produk terbaru?',
                'answer' => 'Produk terbaru dapat dilihat pada halaman Beranda.'
            ],
            [
                'question' => 'Bagaimana cara melihat isi keranjang?',
                'answer' => 'Klik menu Keranjang pada navigasi website.'
            ],
            [
                'question' => 'Bagaimana cara mengubah jumlah produk?',
                'answer' => 'Ubah nilai pada kolom jumlah produk di halaman keranjang.'
            ],
            [
                'question' => 'Bagaimana cara menghapus produk dari keranjang?',
                'answer' => 'Kurangi jumlah menjadi nol atau gunakan fitur hapus.'
            ],
            [
                'question' => 'Apa fungsi tombol Kosongkan Keranjang?',
                'answer' => 'Untuk menghapus seluruh produk dari keranjang.'
            ],
            [
                'question' => 'Apakah saya bisa membeli lebih dari satu produk?',
                'answer' => 'Ya, Anda dapat membeli beberapa produk sekaligus.'
            ],
            [
                'question' => 'Bagaimana cara melihat subtotal belanja?',
                'answer' => 'Lihat pada bagian Ringkasan Pesanan.'
            ],
            [
                'question' => 'Apakah keranjang tersimpan setelah login kembali?',
                'answer' => 'Ya, selama data keranjang belum dihapus.'
            ],
            [
                'question' => 'Bagaimana cara melanjutkan checkout?',
                'answer' => 'Klik tombol Lanjut ke Pembayaran.'
            ],
            [
                'question' => 'Apa fungsi tombol Lanjut ke Pembayaran?',
                'answer' => 'Untuk melanjutkan proses checkout dan pembayaran.'
            ],
            [
                'question' => 'Apakah produk di keranjang otomatis menjadi pesanan?',
                'answer' => 'Tidak, produk baru menjadi pesanan setelah checkout.'
            ],
            [
                'question' => 'Mengapa total belanja berubah?',
                'answer' => 'Karena menyesuaikan jumlah produk yang dipilih.'
            ],
            [
                'question' => 'Apakah ongkir dihitung di keranjang?',
                'answer' => 'Ya, informasi ongkir ditampilkan pada ringkasan pesanan.'
            ],
            [
                'question' => 'Bagaimana jika keranjang kosong?',
                'answer' => 'Tambahkan produk terlebih dahulu sebelum checkout.'
            ],
            [
                'question' => 'Bisakah saya menyimpan produk di keranjang terlebih dahulu?',
                'answer' => 'Ya, produk dapat disimpan di keranjang sebelum dibeli.'
            ],
            [
                'question' => 'Apa saja metode pembayaran yang tersedia?',
                'answer' => 'Virtual Account, QRIS, GoPay, ShopeePay, Alfamart, dan kartu kredit/debit.'
            ],
            [
                'question' => 'Apakah pembayaran aman?',
                'answer' => 'Ya, pembayaran diproses melalui Midtrans.'
            ],
            [
                'question' => 'Apa itu Midtrans?',
                'answer' => 'Midtrans adalah payment gateway untuk memproses pembayaran online.'
            ],
            [
                'question' => 'Bagaimana cara membayar menggunakan QRIS?',
                'answer' => 'Pilih QRIS lalu scan kode QR yang tersedia.'
            ],
            [
                'question' => 'Bagaimana cara membayar menggunakan GoPay?',
                'answer' => 'Pilih GoPay lalu ikuti instruksi pembayaran.'
            ],
            [
                'question' => 'Bagaimana cara membayar menggunakan ShopeePay?',
                'answer' => 'Pilih ShopeePay lalu konfirmasi pembayaran.'
            ],
            [
                'question' => 'Bagaimana cara membayar menggunakan Virtual Account?',
                'answer' => 'Transfer ke nomor Virtual Account yang diberikan.'
            ],
            [
                'question' => 'Bagaimana cara membayar menggunakan Alfamart?',
                'answer' => 'Tunjukkan kode pembayaran kepada kasir Alfamart.'
            ],
            [
                'question' => 'Bagaimana cara membayar menggunakan kartu kredit?',
                'answer' => 'Masukkan nomor kartu, masa berlaku, dan CVV.'
            ],
            [
                'question' => 'Apakah tersedia pembayaran BCA VA?',
                'answer' => 'Ya, tersedia.'
            ],
            [
                'question' => 'Apakah tersedia pembayaran Mandiri Bill?',
                'answer' => 'Ya, tersedia.'
            ],
            [
                'question' => 'Apakah tersedia pembayaran Permata VA?',
                'answer' => 'Ya, tersedia.'
            ],
            [
                'question' => 'Apakah tersedia pembayaran debit online?',
                'answer' => 'Ya, tersedia.'
            ],
            [
                'question' => 'Apakah ada biaya admin?',
                'answer' => 'Saat ini biaya admin gratis.'
            ],
            [
                'question' => 'Apakah ada ongkos kirim?',
                'answer' => 'Saat ini ongkos kirim gratis.'
            ],
            [
                'question' => 'Bagaimana cara melihat rincian pembayaran?',
                'answer' => 'Lihat pada Ringkasan Pembayaran.'
            ],
            [
                'question' => 'Bagaimana cara melihat total pembayaran?',
                'answer' => 'Total pembayaran ditampilkan pada halaman pembayaran.'
            ],
            [
                'question' => 'Bagaimana jika pembayaran gagal?',
                'answer' => 'Silakan ulangi pembayaran atau hubungi Help Desk.'
            ],
            [
                'question' => 'Bagaimana jika pembayaran pending?',
                'answer' => 'Tunggu beberapa saat hingga status diperbarui.'
            ],
            [
                'question' => 'Bagaimana jika pembayaran terduplikasi?',
                'answer' => 'Hubungi Help Desk untuk pengecekan.'
            ],
            [
                'question' => 'Apakah saya mendapatkan bukti pembayaran?',
                'answer' => 'Ya, status pembayaran tercatat pada sistem.'
            ],
            [
                'question' => 'Apakah data kartu kredit aman?',
                'answer' => 'Ya, data kartu ditokenisasi oleh Midtrans.'
            ],
            [
                'question' => 'Siapa yang memproses pembayaran?',
                'answer' => 'Midtrans.'
            ],
            [
                'question' => 'Apakah saya bisa mencoba pembayaran ulang?',
                'answer' => 'Ya, jika transaksi sebelumnya gagal.'
            ],
            [
                'question' => 'Apakah pembayaran tersedia 24 jam?',
                'answer' => 'Ya, pembayaran online tersedia 24 jam.'
            ],
            [
                'question' => 'Bagaimana cara melihat pesanan saya?',
                'answer' => 'Buka menu Pesanan.'
            ],
            [
                'question' => 'Bagaimana cara melihat status pesanan?',
                'answer' => 'Status dapat dilihat pada halaman Pesanan.'
            ],
            [
                'question' => 'Apa arti status Menunggu Pembayaran?',
                'answer' => 'Pesanan belum dibayar.'
            ],
            [
                'question' => 'Apa arti status Diproses?',
                'answer' => 'Pesanan sedang diproses.'
            ],
            [
                'question' => 'Apa arti status Selesai?',
                'answer' => 'Pesanan telah selesai diproses.'
            ],
            [
                'question' => 'Apakah saya bisa melihat riwayat pesanan?',
                'answer' => 'Ya, melalui menu Pesanan.'
            ],
            [
                'question' => 'Bagaimana jika pesanan tidak muncul?',
                'answer' => 'Pastikan login menggunakan akun yang benar.'
            ],
            [
                'question' => 'Bisakah saya membatalkan pesanan?',
                'answer' => 'Ya, selama belum dibayar atau diproses.'
            ],
            [
                'question' => 'Bagaimana jika saya salah memilih produk?',
                'answer' => 'Hapus produk dari keranjang sebelum checkout.'
            ],
            [
                'question' => 'Bisakah saya memesan ulang produk yang sama?',
                'answer' => 'Ya, Anda dapat membeli kembali produk yang sama.'
            ],
            [
                'question' => 'Bagaimana cara mengubah nama lengkap?',
                'answer' => 'Edit data pada halaman Profil lalu simpan perubahan.'
            ],
            [
                'question' => 'Bagaimana cara mengubah email?',
                'answer' => 'Ubah email pada halaman Profil.'
            ],
            [
                'question' => 'Bagaimana cara mengubah nomor telepon?',
                'answer' => 'Edit nomor telepon pada halaman Profil.'
            ],
            [
                'question' => 'Bagaimana cara mengubah alamat pengiriman?',
                'answer' => 'Perbarui alamat pada bagian Alamat Pengiriman.'
            ],
            [
                'question' => 'Bagaimana cara mengubah password?',
                'answer' => 'Isi password lama dan password baru lalu klik Simpan Perubahan.'
            ],
            [
                'question' => 'Apakah saya bisa upload foto profil?',
                'answer' => 'Ya, gunakan fitur Upload Foto Profil.'
            ],
            [
                'question' => 'Berapa nomor WhatsApp Help Desk?',
                'answer' => '085175397197.'
            ],
            // === PENGIRIMAN ===
            [
                'question' => 'Berapa lama waktu pengiriman untuk tas yang dipesan?',
                'answer' => 'Waktu pengiriman tergantung pada lokasi Anda. Pengiriman reguler biasanya memakan waktu 2-5 hari kerja.'
            ],
            [
                'question' => 'Estimasi pengiriman berapa lama?',
                'answer' => 'Waktu pengiriman tergantung pada lokasi Anda. Pengiriman reguler biasanya memakan waktu 2-5 hari kerja.'
            ],
            [
                'question' => 'Berapa lama proses pengiriman barang?',
                'answer' => 'Waktu pengiriman tergantung pada lokasi Anda. Pengiriman reguler biasanya memakan waktu 2-5 hari kerja.'
            ],
            [
                'question' => 'Apa saja pilihan pengiriman yang tersedia?',
                'answer' => 'Kami menawarkan berbagai pilihan pengiriman termasuk reguler, ekspres, dan same-day delivery untuk beberapa lokasi.'
            ],
            [
                'question' => 'Apakah ada pengiriman gratis?',
                'answer' => 'Pengiriman gratis tersedia untuk pembelian di atas Rp500.000, berlaku untuk wilayah tertentu.'
            ],
            // Ekspedisi
            [
                'question' => 'Ekspedisi apa yang digunakan CikalTas?',
                'answer' => 'CikalTas menggunakan jasa ekspedisi JNE, J&T Express, SiCepat, dan Pos Indonesia. Pilih sesuai kebutuhan Kakak!',
            ],
            // === REGION ESTIMASI PENGIRIMAN ===
            [
                'question' => 'Berapa lama pengiriman ke Bandung?',
                'answer' => 'Pengiriman ke Bandung biasanya memakan waktu 2-4 hari kerja.',
            ],
            [
                'question' => 'Berapa lama pengiriman ke Solo?',
                'answer' => 'Pengiriman ke Solo biasanya memakan waktu 2-4 hari kerja.',
            ],
            [
                'question' => 'Berapa lama pengiriman ke Semarang?',
                'answer' => 'Pengiriman ke Semarang biasanya memakan waktu 2-4 hari kerja.',
            ],
            [
                'question' => 'Berapa lama pengiriman ke Jawa Timur?',
                'answer' => 'Pengiriman ke Jawa Timur biasanya memakan waktu 2-4 hari kerja.',
            ],
            [
                'question' => 'Berapa lama pengiriman ke Surabaya?',
                'answer' => 'Pengiriman ke Surabaya biasanya memakan waktu 2-4 hari kerja.',
            ],
            [
                'question' => 'Berapa lama pengiriman ke Kalimantan?',
                'answer' => 'Pengiriman ke Kalimantan biasanya memakan waktu 5-7 hari kerja.',
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
