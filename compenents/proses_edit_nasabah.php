<?php
include('../db.php');

// Ambil data dari form edit
$id = $_POST['id'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$alamat = $_POST['alamat'];

// Query untuk mengupdate data nasabah
$query = "UPDATE nasabah SET nama=?, nik=?, alamat=? WHERE id=?";
$stmt = $conn->prepare($query);

// Binding parameter
$stmt->bind_param('sssi', $nama, $nik, $alamat, $id);

// Eksekusi query
if ($stmt->execute()) {
    echo "Data berhasil diperbarui";
} else {
    echo "Gagal memperbarui data: " . $conn->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>