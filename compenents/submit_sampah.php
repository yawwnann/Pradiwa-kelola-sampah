<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $berat = $_POST['berat'];
    $tanggal = $_POST['tanggal'];

    // Ambil ID nasabah berdasarkan nama
    $stmt = $conn->prepare("SELECT id FROM nasabah WHERE nama = ?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $stmt->bind_result($nasabah_id);
    $stmt->fetch();
    $stmt->close();

    if ($nasabah_id) {
        $stmt = $conn->prepare("INSERT INTO sampah (nasabah_id, jenis_sampah, berat, tanggal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $nasabah_id, $jenis_sampah, $berat, $tanggal);

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