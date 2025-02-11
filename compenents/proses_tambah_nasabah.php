<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];

    $conn->query("INSERT INTO nasabah (nama, nik, alamat) VALUES ('$nama', '$nik', '$alamat')");
    echo "success";
}
?>