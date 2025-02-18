<?php
include('../db.php'); // Pastikan koneksi database aktif

// Query untuk mengambil data sampah berdasarkan kategori
$query = "SELECT * FROM sampah ORDER BY kategori, jenis_sampah";
$result = $conn->query($query);

// Mengelompokkan data berdasarkan kategori
$data_sampah = [];
while ($row = $result->fetch_assoc()) {
    $kategori = $row['kategori'];
    $data_sampah[$kategori][] = $row;
}

// Variabel total untuk setiap kategori
$total_kertas = $total_harga_kertas = 0;
$total_plastik = $total_harga_plastik = 0;
$total_logam = $total_harga_logam = 0;
$total_kaca = $total_harga_kaca = 0;
$total_lain = $total_harga_lain = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Bank Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                font-size: 14px;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }

        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body class="p-6 bg-white">

    <div class="max-w-4xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        <!-- Header Nota -->
        <div class="header">
            <p>BUKU REKAP</p>
            <p>BANK SAMPAH PELANGI 07</p>
            <p>NOTOPRAJAN</p>
            <p><?= date("d-m-Y") ?></p>
        </div>

        <!-- Tabel Data Per Kategori -->
        <?php foreach ($data_sampah as $kategori => $items): ?>
            <h2 class="text-lg font-bold mt-6"><?= strtoupper($kategori); ?></h2>
            <table class="mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Berat (kg)</th>
                        <th>Rp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_berat = 0;
                    $total_harga = 0;
                    $i = 1;
                    foreach ($items as $item):
                        $total_berat += $item['berat'];
                        $total_harga += $item['berat'] * $item['harga'];
                        ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $item['jenis_sampah']; ?></td>
                            <td class="text-right"><?= number_format($item['berat'], 2); ?></td>
                            <td class="text-right"><?= number_format($item['berat'] * $item['harga'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="font-bold">
                        <td colspan="2" class="text-right">TOTAL <?= strtoupper($kategori); ?></td>
                        <td class="text-right"><?= number_format($total_berat, 2); ?></td>
                        <td class="text-right"><?= number_format($total_harga, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>

            <?php
            // Menyimpan total berdasarkan kategori
            if ($kategori == "Kertas") {
                $total_kertas = $total_berat;
                $total_harga_kertas = $total_harga;
            } elseif ($kategori == "Plastik") {
                $total_plastik = $total_berat;
                $total_harga_plastik = $total_harga;
            } elseif ($kategori == "Logam") {
                $total_logam = $total_berat;
                $total_harga_logam = $total_harga;
            } elseif ($kategori == "Kaca") {
                $total_kaca = $total_berat;
                $total_harga_kaca = $total_harga;
            } elseif ($kategori == "Lain-lain") {
                $total_lain = $total_berat;
                $total_harga_lain = $total_harga;
            }
            ?>
        <?php endforeach; ?>

        <!-- Grand Total -->
        <div class="mt-6 border-t border-gray-500 pt-4">
            <h2 class="text-lg font-bold text-center">TOTAL SEMUA</h2>
            <table class="mt-2">
                <tr class="font-bold">
                    <td>Total Kertas</td>
                    <td class="text-right"><?= number_format($total_kertas, 2); ?> kg</td>
                    <td class="text-right"><?= number_format($total_harga_kertas, 0, ',', '.'); ?> Rp</td>
                </tr>
                <tr class="font-bold">
                    <td>Total Plastik</td>
                    <td class="text-right"><?= number_format($total_plastik, 2); ?> kg</td>
                    <td class="text-right"><?= number_format($total_harga_plastik, 0, ',', '.'); ?> Rp</td>
                </tr>
                <tr class="font-bold">
                    <td>Total Logam</td>
                    <td class="text-right"><?= number_format($total_logam, 2); ?> kg</td>
                    <td class="text-right"><?= number_format($total_harga_logam, 0, ',', '.'); ?> Rp</td>
                </tr>
                <tr class="font-bold">
                    <td>Total Kaca</td>
                    <td class="text-right"><?= number_format($total_kaca, 2); ?> kg</td>
                    <td class="text-right"><?= number_format($total_harga_kaca, 0, ',', '.'); ?> Rp</td>
                </tr>
                <tr class="font-bold">
                    <td>Total Lain-lain</td>
                    <td class="text-right"><?= number_format($total_lain, 2); ?> kg</td>
                    <td class="text-right"><?= number_format($total_harga_lain, 0, ',', '.'); ?> Rp</td>
                </tr>
            </table>
        </div>

        <!-- Tombol Print -->
        <div class="mt-6 text-center no-print">
            <button onclick="window.print()"
                class="px-6 py-3 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700">
                Print Nota
            </button>
        </div>
        <div class="mt-3 text-center">
            <a href="../tampil_data_sampah.php"
                class="px-6 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700">Kembali</a>
        </div>
    </div>

</body>

</html>

<?php $conn->close(); ?>