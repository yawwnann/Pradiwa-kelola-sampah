<?php include('db.php'); ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css">
    <!-- Add Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>



<div class="container  bg-gray-50 min-h-screen mx-auto mt-10 p-6">
    <h1 class="text-4xl font-bold text-center text-teal-600 mb-8">Statistik Sampah</h1>

    <!-- Statistik Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <!-- Total Nasabah -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-users text-4xl text-teal-600 mb-4"></i>
            <h2 class="text-2xl font-reguler text-teal-600">Total Nasabah</h2>
            <?php
            $nasabah_query = "SELECT COUNT(*) as total_nasabah FROM nasabah";
            $nasabah_result = mysqli_query($conn, $nasabah_query);
            $nasabah_data = mysqli_fetch_assoc($nasabah_result);
            $total_nasabah = $nasabah_data['total_nasabah'];
            ?>
            <p class="text-5xl font-bold text-teal-700 mt-4"><?php echo $total_nasabah; ?></p>
        </div>

        <!-- Total Berat Sampah -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-weight text-4xl text-teal-600 mb-4"></i>
            <h2 class="text-2xl font-reguler text-teal-600">Total Berat Sampah</h2>
            <?php
            $berat_query = "SELECT SUM(berat) as total_berat FROM sampah";
            $berat_result = mysqli_query($conn, $berat_query);
            $berat_data = mysqli_fetch_assoc($berat_result);
            $total_berat = $berat_data['total_berat'];
            ?>
            <p class="text-3xl font-bold text-teal-700 mt-4"><?php echo number_format($total_berat, 2); ?> kg</p>
        </div>

        <!-- Jenis Sampah Paling Banyak -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-recycle text-4xl text-teal-600 mb-4"></i>
            <h2 class="text-xl font-reguler text-teal-600">Jenis Sampah Paling Banyak</h2>
            <?php
            $jenis_sampah_query = "SELECT jenis_sampah, COUNT(*) as jumlah FROM sampah GROUP BY jenis_sampah ORDER BY jumlah DESC LIMIT 1";
            $jenis_sampah_result = mysqli_query($conn, $jenis_sampah_query);
            $jenis_sampah_data = mysqli_fetch_assoc($jenis_sampah_result);
            $jenis_sampah = $jenis_sampah_data['jenis_sampah'];
            $jumlah_sampah = $jenis_sampah_data['jumlah'];
            ?>
            <p class="text-2xl font-bold text-teal-700 mt-4">
                <?php echo $jenis_sampah . " <br> (" . $jumlah_sampah . " sampah)"; ?>
            </p>
        </div>

        <!-- Rata-rata Berat Sampah Per Tanggal -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-calendar-day text-4xl text-teal-600 mb-4"></i>
            <h2 class="text-2xl font-reguler text-teal-600">Rata-rata Berat Sampah Per Tanggal</h2>
            <?php
            $rata_berat_query = "SELECT tanggal, AVG(berat) as rata_berat FROM sampah GROUP BY tanggal";
            $rata_berat_result = mysqli_query($conn, $rata_berat_query);
            $rata_berat_data = mysqli_fetch_assoc($rata_berat_result);
            $rata_berat = $rata_berat_data['rata_berat'];
            ?>
            <p class="text-3xl font-bold text-teal-700 mt-4"><?php echo number_format($rata_berat, 2); ?> kg</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="flex flex-col lg:flex-row items-center justify-center gap-8 mb-12">
        <!-- Grafik Total Berat Sampah per Jenis -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full lg:w-1/2">
            <h2 class="text-2xl font-reguler text-teal-600 mb-4">Total Berat Sampah per Jenis</h2>
            <canvas id="beratSampahChart"></canvas>
        </div>

        <!-- Grafik Sampah per Tanggal -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full lg:w-1/2">
            <h2 class="text-2xl font-reguler text-teal-600 mb-4">Sampah per Tanggal</h2>
            <canvas id="tanggalChart"></canvas>
        </div>
    </div>

</div>

<script>
    // Grafik Total Berat Sampah per Jenis
    var ctx=document.getElementById('beratSampahChart').getContext('2d');
    var beratSampahChart=new Chart(ctx,{
        type: 'bar',
        data: {
            labels: [
                <?php
                $jenis_sampah_query = "SELECT jenis_sampah FROM sampah GROUP BY jenis_sampah";
                $jenis_sampah_result = mysqli_query($conn, $jenis_sampah_query);
                while ($row = mysqli_fetch_assoc($jenis_sampah_result)) {
                    echo "'" . $row['jenis_sampah'] . "',";
                }
                ?>
            ],
            datasets: [{
                label: 'Berat Sampah (kg)',
                data: [
                    <?php
                    mysqli_data_seek($jenis_sampah_result, 0); // Reset pointer
                    while ($row = mysqli_fetch_assoc($jenis_sampah_result)) {
                        $berat_query = "SELECT SUM(berat) as total_berat FROM sampah WHERE jenis_sampah='" . $row['jenis_sampah'] . "'";
                        $berat_result = mysqli_query($conn, $berat_query);
                        $berat_data = mysqli_fetch_assoc($berat_result);
                        echo $berat_data['total_berat'] . ",";
                    }
                    ?>
                ],
                backgroundColor: '#4FBA6F',
                borderColor: '#4FBA6F',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });

    // Grafik Sampah per Tanggal
    var tanggalCtx=document.getElementById('tanggalChart').getContext('2d');
    var tanggalChart=new Chart(tanggalCtx,{
        type: 'line',
        data: {
            labels: [
                <?php
                $tanggal_query = "SELECT DISTINCT tanggal FROM sampah ORDER BY tanggal";
                $tanggal_result = mysqli_query($conn, $tanggal_query);
                while ($row = mysqli_fetch_assoc($tanggal_result)) {
                    echo "'" . $row['tanggal'] . "',";
                }
                ?>
            ],
            datasets: [{
                label: 'Jumlah Sampah',
                data: [
                    <?php
                    mysqli_data_seek($tanggal_result, 0); // Reset pointer
                    while ($row = mysqli_fetch_assoc($tanggal_result)) {
                        $jumlah_query = "SELECT COUNT(*) as jumlah FROM sampah WHERE tanggal='" . $row['tanggal'] . "'";
                        $jumlah_result = mysqli_query($conn, $jumlah_query);
                        $jumlah_data = mysqli_fetch_assoc($jumlah_result);
                        echo $jumlah_data['jumlah'] . ",";
                    }
                    ?>
                ],
                borderColor: '#4FBA6F',
                backgroundColor: 'rgba(79, 186, 111, 0.2)',
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });
</script>

<?php
mysqli_close($conn); // Tutup koneksi database
?>
</body>

</html>