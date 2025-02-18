<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradiwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Efek underline animasi */
        .nav-link {
            position: relative;
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: rgb(77, 158, 107);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-in-out;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .nav-link:hover {
            color: #16a34a;
        }
    </style>
</head>

<body class="bg-gray-300">
    <!-- Navbar -->
    <nav
        class="bg-gray-50 text-black py-3 px-6 h-14 shadow-lg w-full fixed top-0 left-0 z-50 flex items-center justify-between">
        <!-- Logo -->
        <span class="font-bold text-xl text-teal-600">Pradiwa</span>

        <!-- Tombol Toggle untuk Mobile -->
        <button id="menu-toggle" class="md:hidden text-black text-2xl focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Sidebar Mobile -->
        <div id="sidebar"
            class="fixed top-0 left-0 w-64 h-full bg-gray-800 text-white p-6 transform -translate-x-full transition-transform duration-300 md:hidden">
            <button id="close-menu" class="absolute top-4 right-4 text-white text-2xl">
                <i class="fa-solid fa-times"></i>
            </button>
            <nav class="mt-10 space-y-4">
                <a href="dashboard.php" id="dashboard" class="block text-lg nav-link">Dashboard</a>
                <a href="about.php" id="about" class="block text-lg nav-link">Tentang</a>
                <a href="input_sampah.php" id="input_sampah" class="block text-lg nav-link">Input Sampah</a>
                <a href="data_nasabah.php" id="data_nasabah" class="block text-lg nav-link">Data Nasabah</a>
                <a href="tampil_data_sampah.php" id="data_sampah" class="block text-lg nav-link">Data Sampah</a>
                <a href="statistik.php" id="statistik" class="block text-lg nav-link">Data Statistik</a>
            </nav>
        </div>

        <!-- Menu Navigasi untuk Desktop -->
        <div class="hidden md:flex space-x-6">
            <a href="dashboard.php" id="dashboard" class="text-lg font-regular text-black nav-link">Dashboard</a>
            <a href="about.php" id="about" class="text-lg font-regular text-black nav-link">Tentang</a>
            <a href="input_sampah.php" id="input_sampah" class="text-lg font-regular text-black nav-link">Input
                Sampah</a>
            <a href="data_nasabah.php" id="data_nasabah" class="text-lg font-regular text-black nav-link">Data
                Nasabah</a>
            <a href="tampil_data_sampah.php" id="data_sampah" class="text-lg font-regular text-black nav-link">Data
                Sampah</a>
            <a href="statistik.php" id="statistik" class="text-lg font-regular text-black nav-link">Data Statistik</a>
        </div>
    </nav>

    <script>
        document.getElementById('menu-toggle').addEventListener('click',function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
        });

        document.getElementById('close-menu').addEventListener('click',function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
        });

        // Aktifkan Navbar berdasarkan halaman aktif
        window.addEventListener('DOMContentLoaded',function() {
            const currentPath=window.location.pathname;
            const navbarLinks=document.querySelectorAll('.nav-link');

            navbarLinks.forEach(link => {
                if(currentPath.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>