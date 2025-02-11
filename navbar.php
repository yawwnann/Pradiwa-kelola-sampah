<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradiwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        * {
            border: 2px solid red;
        }
    </style>

</head>

<body class="bg-gradient-to-r from-emerald-600 to-teal-700">
    <!-- Navbar -->
    <nav class="bg-gray-50 text-black py-3 px-6 h-14 shadow-lg  w-full flex justify-between items-center fixed">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo dan Teks -->
            <div class="flex items-center space-x-2">
                <span class="font-bold text-xl">Pradiwa</span>
            </div>

            <!-- Menu Navigasi -->
            <div class="flex space-x-8">
                <a href="dashboard.php"
                    class="text-lg font-medium text-black hover:text-green-300  transition duration-300 ease-in-out">Dashboard</a>
                <a href="about.php"
                    class="text-lg font-medium text-black hover:text-green-300  transition duration-300 ease-in-out">Tentang</a>
                <a href="input_sampah.php"
                    class="text-lg font-medium text-black hover:text-green-300  transition duration-300 ease-in-out">Input
                    Sampah</a>
                <a href="data_nasabah.php"
                    class="text-lg font-medium text-black hover:text-green-300  transition duration-300 ease-in-out">Data
                    Nasabah</a>
                <a href="data_sampah.php"
                    class="text-lg font-medium text-black hover:text-green-300  transition duration-300 ease-in-out">Data
                    Sampah</a>
                <a href="statistik.php"
                    class="text-lg font-medium text-black hover:text-green-300  transition duration-300 ease-in-out">Data
                    Statistik</a>

            </div>

            <!-- User Profile dan Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-black text-lg">Admin</span>
                <a href="logout.php"
                    class="flex items-center space-x-2 text-black hover:text-green-300  transition duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v7m0 0l3-3m-3 3l-3-3m9 10H3" />
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto p-8">
        <!-- Add your page content here -->
    </div>
</body>

</html>