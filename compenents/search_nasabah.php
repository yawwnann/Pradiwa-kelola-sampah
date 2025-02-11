<?php
include('../db.php');

$nama = isset($_GET['nama']) ? $_GET['nama'] : '';

if (!empty($nama)) {
    $stmt = $conn->prepare("SELECT nama, nik, alamat FROM nasabah WHERE nama LIKE ? LIMIT 5");
    $searchTerm = "%" . $nama . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $nasabahList = [];
    while ($row = $result->fetch_assoc()) {
        $nasabahList[] = $row;
    }

    echo json_encode($nasabahList);
}
?>