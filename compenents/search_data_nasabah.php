<?php
include('../db.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM nasabah WHERE nama LIKE ? OR nik LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$nasabahList = [];
while ($row = $result->fetch_assoc()) {
    $nasabahList[] = $row;
}

echo json_encode($nasabahList);
?>