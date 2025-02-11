<?php
session_start();
include('db.php');  // Pastikan file db.php sudah benar untuk koneksi ke database

$error = '';  // Untuk menyimpan pesan kesalahan login

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Memastikan password aman dengan md5 (disarankan untuk menggunakan bcrypt di produksi)

    // Query untuk mencari username dan password di database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Jika login berhasil, simpan session dan redirect ke dashboard
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");  // Redirect ke halaman dashboard
        exit();
    } else {
        // Jika login gagal, tampilkan pesan kesalahan
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <!-- Halaman Login -->
    <div class="flex min-h-screen items-center justify-center relative">
        <div class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-lg flex items-center">
            <!-- Form Login -->
            <div class="w-1/2 pr-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Masuk</h2>
                <?php if ($error): ?>
                    <div class="mb-4 text-red-600 text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form id="login-form" method="POST" action="">
                    <div class="mb-4">
                        <input type="text" name="username" placeholder="Masukkan alamat username Anda"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                            required>
                    </div>
                    <div class="mb-4 relative">
                        <input id="password" type="password" name="password" placeholder="Masukkan Password Anda"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 pr-10"
                            required>
                        <img id="password-icon" src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/solid/eye-off.svg"
                            alt="show/hide password" class="absolute top-3 right-4 w-6 text-gray-600 cursor-pointer"
                            onclick="togglePassword()">
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" name="submit"
                        class="w-full py-2 bg-teal-500 text-white font-bold rounded-lg hover:bg-teal-600 transition duration-300">
                        Masuk
                    </button>

                </form>
            </div>

            <!-- Gambar Man -->
            <div class="w-1/2">
                <img src="asset/man.png" alt="Man" class="w-full h-full object-cover rounded-lg">
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk toggle visibility password
        function togglePassword() {
            const passwordField=document.getElementById("password");
            const icon=document.getElementById("password-icon");

            if(passwordField.type==="password") {
                passwordField.type="text";
                icon.src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/solid/eye.svg"; // Ikon mata terbuka
            } else {
                passwordField.type="password";
                icon.src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/solid/eye-off.svg"; // Ikon mata tertutup
            }
        }
    </script>
</body>

</html>