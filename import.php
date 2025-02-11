<?php

// Konfigurasi database
$host = "localhost";
$dbname = "pradiwa";
$username = "root";
$password = "";

try {
    // Membuat koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Membaca file JSON
$jsonFile = 'data_nasabah.json';
$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

// Mengecek apakah data berhasil di-decode
if (!$data) {
    die("Gagal membaca JSON");
}

// Memasukkan data ke dalam tabel
$sql = "INSERT INTO nasabah (id, nama, nik, alamat) VALUES (:id, :nama, :nik, :alamat)";
$stmt = $pdo->prepare($sql);

foreach ($data['users'] as $id => $user) {
    $stmt->execute([
        ':id' => $id,
        ':nama' => $user['nama'],
        ':nik' => $user['nik'],
        ':alamat' => $user['alamat']
    ]);
}

echo "Data berhasil dimasukkan ke database.";

// Menampilkan data dari database
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Alamat</th>
        </tr>";

$query = $pdo->query("SELECT * FROM nasabah");
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['nik']}</td>
            <td>{$row['alamat']}</td>
          </tr>";
}

echo "</table>";
?>