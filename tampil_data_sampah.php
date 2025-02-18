<?php
include('db.php');
include('navbar.php');

// Daftar jenis sampah berdasarkan kategori
$jenis_sampah_kategori = [
    "Kertas" => ['Duplex', 'Kardus', 'Koran', 'Majalah', 'Arsip', 'Buram', 'Lainnya (Kertas)'],
    "Logam" => ['Aluminium', 'Tembaga', 'Kuningan', 'Kaleng', 'Besi A', 'Besi B', 'Besi C', 'Lainnya (Logam)'],
    "Plastik" => ['Botol Plastik', 'Gelas Plastik', 'Plastik Bening', 'Le Minerale', 'Kerasan', 'Lainnya (Plastik)'],
    "Kaca" => ['Botol Sirup', 'Botol Beling Kecil', 'Lainnya (Kaca)'],
    "Lain-lain" => ['Lainnya']
];

// Cek apakah tombol reset ditekan
if (isset($_POST['reset'])) {
    $start_date = '';
    $end_date = '';
} else {
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
}

// Query awal tanpa filter
$query = "SELECT kategori, jenis_sampah, berat, harga, tanggal FROM sampah";
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


<script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>


<div class="container mx-auto px-4 md:p-6 pt-16 md:pt-20 bg-white shadow-xl rounded-lg">
    <!-- Header -->
    <div class="bg-teal-600 mt-4 md:mt-8 p-4 md:p-6 rounded-t-lg text-white shadow-lg">
        <h1 class="text-2xl md:text-3xl font-bold text-center">
            <i class="fas fa-database"></i> Data Sampah
        </h1>
    </div>

    <!-- Form Filter -->
    <div class="bg-gray-200 p-4 md:p-6 rounded-lg mt-4">
        <form method="POST" class="w-full max-w-2xl mx-auto grid grid-cols-1 gap-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-1/2">
                    <label class="text-gray-700 text-sm md:text-lg font-semibold mb-1 block">
                        <i class="fas fa-calendar-alt"></i> Mulai Tanggal:
                    </label>
                    <input type="date" name="start_date"
                        class="p-2 md:p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full">
                </div>

                <div class="w-full md:w-1/2">
                    <label class="text-gray-700 text-sm md:text-lg font-semibold mb-1 block">
                        <i class="fas fa-calendar-alt"></i> Sampai Tanggal:
                    </label>
                    <input type="date" name="end_date"
                        class="p-2 md:p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full">
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                <button type="submit" name="filter"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 md:py-3 px-4 md:px-6 rounded-lg transition-all text-sm md:text-base">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button type="submit" name="reset"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 md:py-3 px-4 md:px-6 rounded-lg transition-all text-sm md:text-base">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
                <a href="compenents/print_nota.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 md:py-3 px-4 md:px-6 rounded-lg transition-all text-sm md:text-base">
                    <i class="fas fa-print"></i> Print
                </a>
                <a href="data_sampah.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 md:py-3 px-4 md:px-6 rounded-lg transition-all text-sm md:text-base">
                    <i class="fas fa-history"></i> Riwayat
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="overflow-x-auto mt-4 md:mt-6">
        <table class="w-full bg-white border-collapse shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-teal-600 text-white">
                    <th class="border-b px-3 md:px-6 py-2 text-left text-xs md:text-sm font-semibold">Kategori</th>
                    <th class="border-b px-3 md:px-6 py-2 text-left text-xs md:text-sm font-semibold">Jenis Sampah
                    </th>
                    <th class="border-b px-3 md:px-6 py-2 text-left text-xs md:text-sm font-semibold">Berat (kg)
                    </th>
                    <th
                        class="border-b px-3 md:px-6 py-2 text-left text-xs md:text-sm font-semibold hidden md:table-cell">
                        Harga/kg</th>
                    <th class="border-b px-3 md:px-6 py-2 text-left text-xs md:text-sm font-semibold">Total</th>
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
                        <tr class="<?= $row_class; ?> hover:bg-gray-200 transition-all">
                            <td class="border-b px-3 md:px-6 py-2 md:py-4 text-xs md:text-base">
                                <?= htmlspecialchars($kategori); ?>
                            </td>
                            <td class="border-b px-3 md:px-6 py-2 md:py-4 text-xs md:text-base">
                                <?= htmlspecialchars($jenis_sampah); ?>
                            </td>
                            <td class="border-b px-3 md:px-6 py-2 md:py-4 text-xs md:text-base">
                                <?= number_format($berat, 2); ?>
                            </td>
                            <td class="border-b px-3 md:px-6 py-2 md:py-4 text-xs md:text-base hidden md:table-cell">
                                <?= number_format($harga, 2); ?>
                            </td>
                            <td class="border-b px-3 md:px-6 py-2 md:py-4 text-xs md:text-base font-bold text-green-600">
                                <?= number_format($total_harga, 2); ?>
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

    <div
        class="mt-4 md:mt-6 p-4 md:p-6 bg-gray-100 rounded-lg flex flex-col md:flex-row justify-between items-center gap-2">
        <strong class="text-lg md:text-xl text-teal-600">
            <i class="fas fa-money-bill-wave"></i> Jumlah Harga:
        </strong>
        <span class="text-xl md:text-2xl font-bold text-green-600">
            Rp <?= number_format($total_price, 2); ?>
        </span>
    </div>
</div>


<?php
$conn->close();
?>