<?php include('config.php');
include 'navbar.php'; ?>

<div class="container bg-gradient-to-r from-emerald-600 to-teal-700 mx-auto px-6 py-12 pt-20">
    <!-- Section Gambar dan Deskripsi -->
    <div class="flex flex-col md:flex-row items-center justify-between">
        <!-- Deskripsi -->
        <div class="md:w-1/2" data-aos="fade-right" data-aos-delay="500">
            <h1 class="text-4xl font-bold text-gray-50 mb-4">Sistem Manajemen Pengelolaan Sampah</h1>
            <p class="text-lg text-gray-50 mb-6">
                Selamat datang di sistem pengelolaan sampah modern. Dengan teknologi ini, Anda dapat memonitor
                proses pengumpulan sampah, mengelola data nasabah, serta mendukung lingkungan yang lebih bersih.
            </p>
            <a href="input_sampah.php"
                class="bg-gray-50 text-black px-6 py-2 rounded-lg hover:bg-green-100 transition duration-300 hover:scale-105">Mulai
                Sekarang</a>

        </div>

        <!-- Gambar -->
        <div class="md:w-1/2 flex justify-center " data-aos="fade-left" data-aos-delay="500">
            <img src="asset/sampah_dashboard.png" alt="Pengelolaan Sampah"
                class="w-full max-w-lg transition-transform duration-300 hover:scale-105 ">
        </div>
    </div>

    <!-- Fitur Utama -->
    <div class="mt-12">
        <h2 class="text-3xl font-bold text-center text-gray-50 mb-6" data-aos="fade-up">Fitur Utama</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Fitur 1 -->
            <div class="bg-gray-300 p-6 rounded-lg shadow-lg text-center transition duration-300 hover:scale-105"
                data-aos="zoom-in">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Input Sampah</h3>
                <p class="text-gray-600">Pantau proses pengumpulan dan pengelolaan sampah secara real-time.</p>
            </div>
            <!-- Fitur 2 -->
            <div class="bg-gray-300 p-6 rounded-lg shadow-lg text-center" data-aos="zoom-in" data-aos-delay="200">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Data Nasabah</h3>
                <p class="text-gray-600">Kelola data nasabah yang berkontribusi dalam sistem pengelolaan sampah.</p>
            </div>
            <!-- Fitur 3 -->
            <div class="bg-gray-300 p-6 rounded-lg shadow-lg text-center" data-aos="zoom-in" data-aos-delay="400">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Laporan dan Statistik</h3>
                <p class="text-gray-600">Lihat laporan pengelolaan sampah dan analisis untuk perbaikan layanan.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>