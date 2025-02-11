<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];

    // Cek apakah NIK sudah ada
    $stmt = $conn->prepare("SELECT id FROM nasabah WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "NIK sudah terdaftar!";
    } else {
        $stmt = $conn->prepare("INSERT INTO nasabah (nama, nik, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $nik, $alamat);

        if ($stmt->execute()) {
            echo "Data berhasil dimasukkan!";
        } else {
            echo "Gagal memasukkan data!";
        }
    }
    $stmt->close();
}
?>