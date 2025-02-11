<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradiwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Mengatur efek underline animasi */
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
            /* Warna hijau */
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-in-out;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Menandai link aktif dengan garis bawah */
        .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .nav-link:hover {
            color: #16a34a;
            /* Mengubah warna teks saat hover */
        }
    </style>
</head>

<body class="bg-gradient-to-r from-emerald-600 to-teal-700">
    <!-- Navbar -->
    <nav
        class="bg-gray-50 text-black py-3 px-6 h-14 shadow-lg w-full fixed top-0 left-0 z-50 flex justify-between items-center">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo dan Teks -->
            <div class="flex items-center space-x-2">
                <span class="font-bold text-xl text-teal-600">Pradiwa</span>
            </div>

            <!-- Menu Navigasi -->
            <div class="flex space-x-8">
                <a href="dashboard.php" id="dashboard" class="text-lg font-regular text-black nav-link">Dashboard</a>
                <a href="about.php" id="about" class="text-lg font-regular text-black nav-link">Tentang</a>
                <a href="input_sampah.php" id="input_sampah" class="text-lg font-regular text-black nav-link">Input
                    Sampah</a>
                <a href="data_nasabah.php" id="data_nasabah" class="text-lg font-regular text-black nav-link">Data
                    Nasabah</a>
                <a href="data_sampah.php" id="data_sampah" class="text-lg font-regular text-black nav-link">Data
                    Sampah</a>
                <a href="statistik.php" id="statistik" class="text-lg font-regular text-black nav-link">Data
                    Statistik</a>
            </div>

            <!-- User Profile dan Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-black text-lg">Admin</span>
                <a href="logout.php"
                    class="flex items-center space-x-2 text-black hover:text-red-600 transition duration-300 ease-in-out">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </nav>

    <script>
        // Mengaktifkan item navbar berdasarkan halaman aktif
        window.addEventListener('DOMContentLoaded',(event) => {
            // Mendapatkan URL halaman
            const currentPath=window.location.pathname;

            // Cek setiap link navbar dan beri kelas 'active' jika link sesuai dengan halaman aktif
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