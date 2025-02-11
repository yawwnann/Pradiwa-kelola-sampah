<?php
include('../db.php');

// Cek apakah ID ada
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $berat = $_POST['berat'];
    $tanggal = $_POST['tanggal'];

    // Query untuk mengupdate data
    $query = "UPDATE sampah SET jenis_sampah = ?, berat = ?, tanggal = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdsi", $jenis_sampah, $berat, $tanggal, $id);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui data.";
    }

    $stmt->close();
    $conn->close();
}
?>