<?php
include('db.php');
include('navbar.php');

// Daftar jenis sampah berdasarkan kategori
$jenis_sampah_kategori = [
    "Kertas" => ['Duplex', 'Kardus', 'Koran', 'Majalah', 'Lainnya'],
    "Logam" => ['Aluminium', 'Tembaga', 'Kuningan', 'Lainnya'],
    "Plastik" => ['Botol Plastik', 'Gelas Plastik', 'Lainnya']
];

// Cek apakah tombol reset ditekan
if (isset($_POST['reset'])) {
    $start_date = '';
    $end_date = '';
} else {
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
}

// Query awal tanpa filter
$query = "SELECT jenis_sampah, berat, harga, tanggal FROM sampah";
$params = [];
$types = '';

if (!empty($start_date) && !empty($end_date)) {
    $query .= " WHERE tanggal BETWEEN ? AND ?";
    $params = [$start_date, $end_date];
    $types = 'ss';
}

// Jalankan query dengan prepared statement
$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
    $total_price += $row['berat'] * $row['harga'];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
</head>


<div class="container mx-auto p-6 mt-6 bg-white shadow-xl rounded-lg">
    <!-- Header -->
    <div class="bg-teal-600 p-6 rounded-t-lg text-white shadow-lg">
        <h1 class="text-3xl font-bold text-center"><i class="fas fa-database"></i> Data Sampah</h1>
    </div>

    <!-- Form Filter -->
    <div class="bg-gray-200 p-6 rounded-lg mt-4 flex justify-center">
        <form method="POST" class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-4 text-center">
            <div class="col-span-2 flex justify-center gap-4">
                <!-- Input Mulai Tanggal -->
                <div class="flex flex-col text-center">
                    <label class="text-gray-700 text-lg font-semibold mb-1">
                        <i class="fas fa-calendar-alt"></i> Mulai Tanggal:
                    </label>
                    <input type="date" name="start_date"
                        class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full"
                        value="<?php echo htmlspecialchars($start_date); ?>">
                </div>

                <!-- Input Sampai Tanggal -->
                <div class="flex flex-col text-center">
                    <label class="text-gray-700 text-lg font-semibold mb-1">
                        <i class="fas fa-calendar-alt"></i> Sampai Tanggal:
                    </label>
                    <input type="date" name="end_date"
                        class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full"
                        value="<?php echo htmlspecialchars($end_date); ?>">
                </div>
            </div>

            <!-- Tombol Filter, Reset, Print, Riwayat -->
            <div class="col-span-2 flex justify-center gap-3">
                <button type="submit" name="filter"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg transition-all">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <button type="submit" name="reset"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-all">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
                <button type="submit" name="print"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-all">
                    <i class="fas fa-print"></i> Print
                </button>
                <a href="data_sampah.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all">
                    <i class="fas fa-history"></i> Riwayat
                </a>
            </div>
        </form>
    </div>


    <!-- Tabel Data -->
    <div class="overflow-x-auto mt-6">
        <table class="w-full bg-white border-collapse shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-teal-600 text-white">
                    <th class="border-b px-6 py-3 text-left text-sm font-semibold">Kategori</th>
                    <th class="border-b px-6 py-3 text-left text-sm font-semibold">Jenis Sampah</th>
                    <th class="border-b px-6 py-3 text-left text-sm font-semibold">Berat (kg)</th>
                    <th class="border-b px-6 py-3 text-left text-sm font-semibold">Harga per kg (Rp)</th>
                    <th class="border-b px-6 py-3 text-left text-sm font-semibold">Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row_class = 'bg-gray-50';

                foreach ($jenis_sampah_kategori as $kategori => $jenis_sampah_list) {
                    foreach ($jenis_sampah_list as $jenis_sampah) {
                        $berat = 0;
                        $harga = 0;

                        foreach ($data as $row) {
                            if ($row['jenis_sampah'] == $jenis_sampah) {
                                $berat += $row['berat'];
                                $harga = $row['harga'];
                            }
                        }

                        $total_harga = $berat * $harga;
                        ?>
                        <tr class="<?php echo $row_class; ?> hover:bg-gray-200 transition-all">
                            <td class="border-b px-6 py-4"><?php echo htmlspecialchars($kategori); ?></td>
                            <td class="border-b px-6 py-4"><?php echo htmlspecialchars($jenis_sampah); ?></td>
                            <td class="border-b px-6 py-4 text-left"><?php echo number_format($berat, 2); ?></td>
                            <td class="border-b px-6 py-4 text-left"><?php echo number_format($harga, 2); ?></td>
                            <td class="border-b px-6 py-4 text-left font-bold text-green-600">
                                <?php echo number_format($total_harga, 2); ?>
                            </td>
                        </tr>
                        <?php
                        $row_class = ($row_class === 'bg-gray-50') ? 'bg-white' : 'bg-gray-50';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Total Harga -->
    <div class="mt-6 p-6 bg-gray-100 rounded-lg flex justify-between items-left">
        <strong class="text-xl text-teal-600"><i class="fas fa-money-bill-wave"></i> Jumlah Harga:</strong>
        <span class="text-2xl font-bold text-green-600">Rp <?php echo number_format($total_price, 2); ?></span>
    </div>
</div>


<?php
$conn->close();
?>