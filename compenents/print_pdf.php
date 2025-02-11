<?php
require '../vendor/autoload.php'; // Load library Dompdf
include('../db.php'); // Koneksi ke database

use Dompdf\Dompdf;
use Dompdf\Options;

// Konfigurasi Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

// Ambil data dari database
$result = $conn->query("SELECT * FROM nasabah ORDER BY id ASC");

// Mulai membangun tampilan PDF
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Nasabah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #FFF; color: black; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Data Nasabah</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>';

// Tambahkan data dari database ke tabel
while ($row = $result->fetch_assoc()) {
    $html .= "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['nik']}</td>
            <td>{$row['alamat']}</td>
        </tr>";
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Load HTML ke Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Set ukuran dan orientasi kertas
$dompdf->render();

// Kirim output PDF ke browser
$dompdf->stream("Data_Nasabah.pdf", ["Attachment" => false]); // false: agar langsung tampil di browser
?>