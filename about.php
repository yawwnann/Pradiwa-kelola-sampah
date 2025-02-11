<?php include('config.php');
include 'navbar.php';
?>


<div class="container mx-auto px-6 py-12 mt-20">
    <!-- Section Gambar dan Deskripsi -->
    <div class="flex flex-col md:flex-row items-center justify-between">

        <!-- Gambar -->
        <div class="md:w-1/2 flex justify-center" data-aos="fade-right" data-aos-delay="500">
            <img src="asset/About_user.png" alt="Tentang Kami" class="w-full max-w-lg ">
        </div>

        <!-- Deskripsi -->
        <div class="md:w-1/2 text-left text-white px-6" data-aos="fade-left" data-aos-delay="500">
            <h1 class="text-4xl font-bold mb-4">Tentang Kami</h1>
            <p class="text-lg mb-6">
                Sistem Informasi Manajemen Bank Sampah Notoprajan adalah sistem manajemen online yang
                diinisiasi oleh pengurus bank sampah Notoprajan. Dengan sistem ini, nasabah dan petugas
                dapat mencatat dan memantau transaksi dengan lebih mudah, serta membantu menjaga kebersihan
                lingkungan sekitar.
            </p>
            <p class="text-lg">
                Kami berkomitmen untuk meningkatkan efisiensi pengelolaan sampah dengan teknologi modern dan
                menciptakan ekosistem yang lebih hijau dan ramah lingkungan.
            </p>
        </div>

    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>