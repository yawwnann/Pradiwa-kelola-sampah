<?php
include('../db.php');

// Cek apakah ID ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM sampah WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    // Eksekusi query dan cek hasilnya
    if ($stmt->execute()) {
        // Menutup koneksi
        $stmt->close();
        $conn->close();
        echo "<script>window.location.href='../data_sampah.php'; showSuccessDeleteModal();</script>";
    } else {
        // Menampilkan pesan jika gagal menghapus
        echo "<script>alert('Gagal menghapus data.'); window.location.href='../data_sampah.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='../data_sampah.php';</script>";
}
?>