<?php include('db.php'); ?>
<?php include 'navbar.php'; ?>

<div class="container mx-auto -mt-7 p-6 bg-white rounded-lg shadow-lg max-w-lg">
    <h1 class="text-2xl font-bold text-center text-teal-600 mb-6">Input Data Sampah</h1>

    <form action="input_sampah.php" method="POST" class="space-y-4">
        <!-- Input Nama -->
        <div class="space-y-1">
            <label for="nama" class="block text-sm font-semibold text-teal-700">Nama</label>
            <input type="text" name="nama" id="nama"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Input NIK -->
        <div class="space-y-1">
            <label for="nik" class="block text-sm font-semibold text-teal-700">NIK</label>
            <input type="text" name="nik" id="nik"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Input Nomor HP -->
        <div class="space-y-1">
            <label for="nomor_hp" class="block text-sm font-semibold text-teal-700">Nomor HP</label>
            <input type="text" name="nomor_hp" id="nomor_hp"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Input Alamat -->
        <div class="space-y-1">
            <label for="alamat" class="block text-sm font-semibold text-teal-700">Alamat</label>
            <textarea name="alamat" id="alamat"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required></textarea>
        </div>

        <!-- Input Jenis Sampah -->
        <div class="space-y-1">
            <label for="jenis_sampah" class="block text-sm font-semibold text-teal-700">Jenis Sampah</label>
            <select name="jenis_sampah" id="jenis_sampah"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200">
                <option value="Kertas">Kertas</option>
                <option value="Logam">Logam</option>
                <option value="Plastik">Plastik</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <!-- Subkategori Kertas -->
        <div id="subkategori-kertas" class="space-y-1 hidden">
            <label for="subkategori_kertas" class="block text-sm font-semibold text-teal-700">Subkategori Kertas</label>
            <select name="subkategori_kertas"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="Duplex">Duplex</option>
                <option value="Kardus">Kardus</option>
                <option value="Koran">Koran</option>
                <option value="Majalah">Majalah</option>
                <option value="Lainnya (Kertas)">Lainnya (Kertas)</option>
            </select>
        </div>

        <!-- Subkategori Logam -->
        <div id="subkategori-logam" class="space-y-1 hidden">
            <label for="subkategori_logam" class="block text-sm font-semibold text-teal-700">Subkategori Logam</label>
            <select name="subkategori_logam"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="Aluminium">Aluminium</option>
                <option value="Tembaga">Tembaga</option>
                <option value="Kuningan">Kuningan</option>
                <option value="Lainnya (Logam)">Lainnya (Logam)</option>
            </select>
        </div>

        <!-- Subkategori Plastik -->
        <div id="subkategori-plastik" class="space-y-1 hidden">
            <label for="subkategori_plastik" class="block text-sm font-semibold text-teal-700">Subkategori
                Plastik</label>
            <select name="subkategori_plastik"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="Botol Plastik">Botol Plastik</option>
                <option value="Gelas Plastik">Gelas Plastik</option>
                <option value="Lainnya (Plastik)">Lainnya (Plastik)</option>
            </select>
        </div>

        <!-- Input Berat Sampah -->
        <div class="space-y-1">
            <label for="berat" class="block text-sm font-semibold text-teal-700">Berat Sampah (kg)</label>
            <input type="number" name="berat" id="berat"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Input Tanggal -->
        <div class="space-y-1">
            <label for="tanggal" class="block text-sm font-semibold text-teal-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Tombol Kirim Data -->
        <button type="submit" name="submit"
            class="w-full py-3 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition duration-300">Kirim
            Data</button>
    </form>
</div>

<script>
    document.getElementById("jenis_sampah").addEventListener("change",function() {
        var selectedCategory=this.value;

        // Sembunyikan semua subkategori
        document.getElementById("subkategori-kertas").classList.add("hidden");
        document.getElementById("subkategori-logam").classList.add("hidden");
        document.getElementById("subkategori-plastik").classList.add("hidden");

        // Tampilkan subkategori yang sesuai
        if(selectedCategory==="Kertas") {
            document.getElementById("subkategori-kertas").classList.remove("hidden");
        } else if(selectedCategory==="Logam") {
            document.getElementById("subkategori-logam").classList.remove("hidden");
        } else if(selectedCategory==="Plastik") {
            document.getElementById("subkategori-plastik").classList.remove("hidden");
        }
    });
</script>