<?php
include('db.php');
include('navbar.php');

// Daftar jenis sampah berdasarkan kategori
$jenis_sampah_kategori = [
    "Kertas" => ['Duplex', 'Kardus', 'Koran', 'Majalah', 'Lainnya'],
    "Logam" => ['Aluminium', 'Tembaga', 'Kuningan', 'Lainnya'],
    "Plastik" => ['Botol Plastik', 'Gelas Plastik', 'Lainnya']
];

// Menangani filter tanggal
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Query untuk mengambil data berdasarkan filter tanggal
$query = "SELECT jenis_sampah, berat, harga, tanggal FROM sampah";
if ($start_date && $end_date) {
    $query .= " WHERE tanggal BETWEEN '$start_date' AND '$end_date'";
} elseif (isset($_POST['reset'])) {
    // Jika tombol "Tampilkan Semua Data" ditekan
    // Tidak ada filter tanggal
    $query = "SELECT jenis_sampah, berat, harga, tanggal FROM sampah";
}

$result = $conn->query($query);
$data = [];
$total_price = 0; // Variabel untuk menyimpan total harga

while ($row = $result->fetch_assoc()) {
    $data[$row['jenis_sampah']] = [
        'berat' => $row['berat'],
        'harga' => $row['harga'],
        'tanggal' => $row['tanggal']
    ];

    // Hitung total harga untuk data yang sesuai dengan filter
    $total_price += $row['berat'] * $row['harga'];  // Menghitung total harga setiap baris data
}

?>

<div class="container mx-auto p-6 mt-6 bg-white shadow-xl rounded-lg">
    <div class="bg-teal-600 p-6 rounded-t-lg text-white shadow-lg">
        <h1 class="text-4xl font-bold text-center mb-4">Display Data Sampah</h1>

        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <label for="tanggal" class="text-xl">Tanggal:</label>
                <input type="date" id="start_date" name="start_date"
                    class="p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    value="<?php echo $start_date; ?>">
                <input type="date" id="end_date" name="end_date"
                    class="p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    value="<?php echo $end_date; ?>">
            </div>

            <div class="space-x-4">
                <form method="POST" class="inline-block">
                    <button type="submit" name="filter"
                        class="bg-teal-700 hover:bg-teal-800 text-white font-semibold py-2 px-4 rounded-lg">Tampilkan
                        Data</button>
                </form>
                <form method="POST" class="inline-block">
                    <button type="submit" name="reset"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">Tampilkan
                        Semua Data</button>
                </form>
            </div>
        </div>
    </div>

    <table class="min-w-full bg-white border-collapse shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-teal-600 text-white">
                <th class="border-b px-4 py-2 text-left text-sm font-semibold">Kategori</th>
                <th class="border-b px-4 py-2 text-left text-sm font-semibold">Jenis Sampah</th>
                <th class="border-b px-4 py-2 text-left text-sm font-semibold">Berat (kg)</th>
                <th class="border-b px-4 py-2 text-left text-sm font-semibold">Harga per kg (Rp)</th>
                <th class="border-b px-4 py-2 text-left text-sm font-semibold">Total Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $row_class = 'bg-gray-50'; // Start with alternating row color
            
            foreach ($jenis_sampah_kategori as $kategori => $jenis_sampah_list) {
                foreach ($jenis_sampah_list as $jenis_sampah) {
                    // Mengambil data berat dan harga untuk jenis sampah
                    $berat = isset($data[$jenis_sampah]) ? $data[$jenis_sampah]['berat'] : 0;
                    $harga = isset($data[$jenis_sampah]) ? $data[$jenis_sampah]['harga'] : 0;
                    $total_harga = $berat * $harga;
                    ?>
                    <tr class="<?php echo $row_class; ?> hover:bg-teal-100">
                        <td class="border-b px-4 py-2"><?php echo htmlspecialchars($kategori); ?></td>
                        <td class="border-b px-4 py-2"><?php echo htmlspecialchars($jenis_sampah); ?></td>
                        <td class="border-b px-4 py-2"><?php echo number_format($berat, 2); ?></td>
                        <td class="border-b px-4 py-2"><?php echo number_format($harga, 2); ?></td>
                        <td class="border-b px-4 py-2"><?php echo number_format($total_harga, 2); ?></td>
                    </tr>
                    <?php
                    // Toggle row class for alternating colors
                    $row_class = ($row_class === 'bg-gray-50') ? 'bg-white' : 'bg-gray-50';
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Total Harga -->
    <div class="mt-6 text-right">
        <strong class="text-xl text-teal-600">Jumlah Harga: Rp
            <?php
            // Menampilkan total harga yang telah dihitung berdasarkan tanggal yang difilter
            echo number_format($total_price, 2);
            ?>
        </strong>
    </div>
</div>

<?php
$conn->close();
?>