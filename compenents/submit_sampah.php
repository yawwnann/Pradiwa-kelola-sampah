<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $kategori = str_replace(array('(', ')'), '', $_POST['kategori']);
    $jenis_sampah_lainnya = $_POST['jenis_sampah_lainnya'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];

    // Jika jenis sampah lainnya diisi, ganti dengan inputan pengguna
    if (!empty($jenis_sampah_lainnya)) {
        $jenis_sampah = $jenis_sampah_lainnya;
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
            echo "Gagal memasukkan data!";
        }
        $stmt->close();
    } else {
        echo "Nama tidak ditemukan dalam database!";
    }
}
?>