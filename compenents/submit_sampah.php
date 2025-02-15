<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan semua input yang dibutuhkan ada
    if (isset($_POST['nama']) && isset($_POST['jenis_sampah']) && isset($_POST['kategori']) && isset($_POST['berat']) && isset($_POST['harga']) && isset($_POST['tanggal'])) {

        $nama = trim($_POST['nama']);
        $jenis_sampah = trim($_POST['jenis_sampah']);
        $kategori = trim(str_replace(array('(', ')'), '', $_POST['kategori']));
        $jenis_sampah_lainnya = trim($_POST['jenis_sampah_lainnya'] ?? ''); // Jika tidak diisi, default kosong
        $berat = floatval($_POST['berat']);
        $harga = floatval($_POST['harga']);
        $tanggal = $_POST['tanggal'];

        // Jika jenis sampah lainnya diisi, gunakan input pengguna
        if (!empty($jenis_sampah_lainnya)) {
            $jenis_sampah = $jenis_sampah_lainnya;
        }

        // Menentukan kategori berdasarkan jenis sampah
        if (in_array($jenis_sampah, ['Duplex', 'Kardus', 'Koran', 'Majalah', 'Arsip', 'Buram'])) {
            $kategori = 'Kertas';
        } elseif (in_array($jenis_sampah, ['Aluminium', 'Tembaga', 'Kuningan', 'Kaleng', 'Besi A', 'Besi B', 'Besi C'])) {
            $kategori = 'Logam';
        } elseif (in_array($jenis_sampah, ['Botol Plastik', 'Gelas Plastik', 'Plastik Bening', 'Le Minerale', 'Kerasan'])) {
            $kategori = 'Plastik';
        } elseif (in_array($jenis_sampah, ['Botol Sirup', 'Botol Beling Kecil', 'Kaca Jendela', 'Gelas Kaca', 'Piring Kaca'])) {
            $kategori = 'Kaca';
        } elseif (in_array($jenis_sampah, ['Elektronik Rusak', 'Baterai Bekas', 'Aki Bekas', 'Lainnya'])) {
            $kategori = 'Lain-lain';
        } elseif (strpos($jenis_sampah, 'Lainnya') !== false) {
            // Jika ada kata "Lainnya" di jenis sampah, tentukan kategori sesuai
            if (strpos($jenis_sampah, 'Kertas') !== false) {
                $kategori = 'Kertas';
            } elseif (strpos($jenis_sampah, 'Logam') !== false) {
                $kategori = 'Logam';
            } elseif (strpos($jenis_sampah, 'Plastik') !== false) {
                $kategori = 'Plastik';
            } elseif (strpos($jenis_sampah, 'Kaca') !== false) {
                $kategori = 'Kaca';
            } elseif (strpos($jenis_sampah, 'Lain-lain') !== false) {
                $kategori = 'Lain-lain';
            }
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