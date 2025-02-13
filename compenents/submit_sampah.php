<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan semua input yang dibutuhkan ada
    if (isset($_POST['nama']) && isset($_POST['jenis_sampah']) && isset($_POST['kategori']) && isset($_POST['berat']) && isset($_POST['harga']) && isset($_POST['tanggal'])) {

        $nama = $_POST['nama'];
        $jenis_sampah = $_POST['jenis_sampah'];
        $kategori = str_replace(array('(', ')'), '', $_POST['kategori']);
        $jenis_sampah_lainnya = $_POST['jenis_sampah_lainnya'] ?? ''; // Menggunakan null coalescing operator
        $berat = $_POST['berat'];
        $harga = $_POST['harga'];
        $tanggal = $_POST['tanggal'];

        // Jika jenis sampah lainnya diisi, ganti dengan inputan pengguna
        if (!empty($jenis_sampah_lainnya)) {
            $jenis_sampah = $jenis_sampah_lainnya;
        }

        // Tentukan kategori berdasarkan jenis sampah
        if (in_array($jenis_sampah, ['Duplex', 'Kardus', 'Koran', 'Majalah'])) {
            $kategori = 'Kertas';
        } elseif (in_array($jenis_sampah, ['Aluminium', 'Tembaga', 'Kuningan'])) {
            $kategori = 'Logam';
        } elseif (in_array($jenis_sampah, ['Botol Plastik', 'Gelas Plastik'])) {
            $kategori = 'Plastik';
        }

        // Ambil ID nasabah berdasarkan nama
        $stmt = $conn->prepare("SELECT id FROM nasabah WHERE nama = ?");
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $stmt->bind_result($nasabah_id);
        $stmt->fetch();
        $stmt->close();

        if ($nasabah_id) {
            // Menambahkan data ke database
            $stmt = $conn->prepare("INSERT INTO sampah (nasabah_id, jenis_sampah, kategori, berat, harga, tanggal) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issdss", $nasabah_id, $jenis_sampah, $kategori, $berat, $harga, $tanggal);

            if ($stmt->execute()) {
                echo "Data berhasil dimasukkan!";
            } else {
                echo "Gagal memasukkan data! Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Nama tidak ditemukan dalam database!";
        }
    } else {
        echo "Semua field harus diisi!";
    }
}
?>