<?php
include('../db.php');

// Ambil ID yang akan dihapus
$id = $_POST['id'];

// Query untuk menghapus data nasabah
$query = "DELETE FROM nasabah WHERE id=?";
$stmt = $conn->prepare($query);

// Binding parameter
$stmt->bind_param('i', $id);

// Eksekusi query
if ($stmt->execute()) {
    echo "Data berhasil dihapus";
} else {
    echo "Gagal menghapus data: " . $conn->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>