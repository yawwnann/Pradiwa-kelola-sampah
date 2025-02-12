<?php include('db.php'); ?>
<?php include 'navbar.php'; ?>

<div class="container mx-auto p-6 bg-white rounded-lg shadow-xl max-w-3xl mt-20 mb-20">
    <h1 class="text-3xl font-bold text-center text-teal-600 mb-8">Input Data Sampah</h1>
    <div id="suggestions" class="absolute w-full bg-white border border-gray-300 rounded-lg shadow-md hidden z-[999]">
    </div>

    <form id="sampahForm" method="POST" class="space-y-6">
        <!-- Input Nama -->
        <div class="relative">
            <label for="nama" class="block text-sm font-semibold text-teal-700">Nama</label>
            <input type="text" name="nama" id="nama"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 placeholder-gray-400"
                required autocomplete="off" placeholder="Masukkan Nama">
        </div>

        <!-- Input NIK -->
        <div class="relative">
            <label for="nik" class="block text-sm font-semibold text-teal-700">NIK</label>
            <input type="text" name="nik" id="nik"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 placeholder-gray-400"
                required readonly placeholder="NIK otomatis">
        </div>

        <!-- Input Alamat -->
        <div class="relative">
            <label for="alamat" class="block text-sm font-semibold text-teal-700">Alamat</label>
            <textarea name="alamat" id="alamat"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 placeholder-gray-400"
                required readonly placeholder="Alamat otomatis"></textarea>
        </div>


        <!-- Input Jenis Sampah -->
        <div class="relative">
            <label for="jenis_sampah" class="block text-sm font-semibold text-teal-700">Jenis Sampah</label>
            <select name="jenis_sampah" id="jenis_sampah"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300">
                <optgroup label="Kertas">
                    <option value="Duplex">Duplex</option>
                    <option value="Kardus">Kardus</option>
                    <option value="Koran">Koran</option>
                    <option value="Majalah">Majalah</option>
                    <option value="Lainnya (Kertas)">Lainnya</option>
                </optgroup>
                <optgroup label="Logam">
                    <option value="Aluminium">Aluminium</option>
                    <option value="Tembaga">Tembaga</option>
                    <option value="Kuningan">Kuningan</option>
                    <option value="Lainnya (Logam)">Lainnya</option>
                </optgroup>
                <optgroup label="Plastik">
                    <option value="Botol Plastik">Botol Plastik</option>
                    <option value="Gelas Plastik">Gelas Plastik</option>
                    <option value="Lainnya (Plastik)">Lainnya</option>
                </optgroup>
            </select>
        </div>

        <!-- Input Jenis Sampah Lainnya (Akan Ditampilkan Saat Memilih Lainnya) -->
        <div id="inputJenisSampahLainnya" class="hidden mt-4">
            <label for="jenis_sampah_lainnya" class="block text-sm font-semibold text-teal-700">Jenis Sampah
                (Kategorikan)</label>
            <input type="text" name="jenis_sampah_lainnya" id="jenis_sampah_lainnya"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300"
                placeholder="Masukkan jenis sampah lainnya">
        </div>

        <!-- Input Berat Sampah -->
        <div class="relative">
            <label for="berat" class="block text-sm font-semibold text-teal-700">Berat Sampah (kg)</label>
            <input type="number" name="berat" id="berat" step="0.01"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 placeholder-gray-400"
                required placeholder="Berat dalam kilogram">
        </div>

        <!-- Input Harga per Kilogram -->
        <div class="relative">
            <label for="harga" class="block text-sm font-semibold text-teal-700">Harga per Kilogram (Rp)</label>
            <input type="number" name="harga" id="harga" step="100"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 placeholder-gray-400"
                required placeholder="Harga per kilogram">
        </div>

        <!-- Input Total Harga -->
        <div class="relative">
            <label for="total_harga" class="block text-sm font-semibold text-teal-700">Total Harga (Rp)</label>
            <input type="text" name="total_harga" id="total_harga" readonly
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 placeholder-gray-400">
        </div>

        <!-- Input Tanggal (Secara Default Hari Ini) -->
        <div class="relative">
            <label for="tanggal" class="block text-sm font-semibold text-teal-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                class="w-full p-3 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300">
        </div>
        <!-- Hidden Input Kategori -->
        <input type="hidden" name="kategori" id="kategori">
        <!-- Tombol Kirim Data -->
        <button type="submit"
            class="w-full py-3 bg-teal-600 mt-6 text-white font-semibold rounded-lg hover:bg-teal-700 transition duration-300 transform hover:scale-105">Kirim
            Data</button>
    </form>
</div>

<!-- MODAL STATUS -->
<div id="statusModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
        <h2 id="statusMessage" class="text-lg font-bold text-teal-700"></h2>
        <button onclick="closeModal()"
            class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 mt-4">OK</button>
    </div>
</div>

<script>
    // Menghandle perubahan pada dropdown "Jenis Sampah"
    document.getElementById("jenis_sampah").addEventListener("change",function() {
        var selectedOption=this.value;
        var inputJenisSampahLainnya=document.getElementById("inputJenisSampahLainnya");

        // Menampilkan input form untuk jenis sampah lainnya jika "Lainnya" dipilih
        if(selectedOption.includes("Lainnya")) {
            inputJenisSampahLainnya.classList.remove("hidden");

            // Mengubah label dan placeholder sesuai kategori yang dipilih
            if(selectedOption==="Lainnya (Kertas)") {
                document.querySelector("label[for='jenis_sampah_lainnya']").textContent="Jenis Sampah Kertas Lainnya";
                document.getElementById("jenis_sampah_lainnya").placeholder="Masukkan jenis sampah Kertas lainnya";
            } else if(selectedOption==="Lainnya (Logam)") {
                document.querySelector("label[for='jenis_sampah_lainnya']").textContent="Jenis Sampah Logam Lainnya";
                document.getElementById("jenis_sampah_lainnya").placeholder="Masukkan jenis sampah Logam lainnya";
            } else if(selectedOption==="Lainnya (Plastik)") {
                document.querySelector("label[for='jenis_sampah_lainnya']").textContent="Jenis Sampah Plastik Lainnya";
                document.getElementById("jenis_sampah_lainnya").placeholder="Masukkan jenis sampah Plastik lainnya";
            }
        } else {
            // Menyembunyikan input form jika tidak memilih "Lainnya"
            inputJenisSampahLainnya.classList.add("hidden");
        }
    });

    // Set default tanggal ke hari ini
    document.addEventListener("DOMContentLoaded",function() {
        let today=new Date();
        let formattedDate=today.toISOString().split('T')[0];
        document.getElementById("tanggal").value=formattedDate;
    });

    // Fungsi untuk menghitung total harga
    document.getElementById("berat").addEventListener("input",updateTotalHarga);
    document.getElementById("harga").addEventListener("input",updateTotalHarga);

    // Fungsi untuk menghitung total harga dan format menjadi format Rupiah
    function updateTotalHarga() {
        let hargaPerKg=parseFloat(document.getElementById("harga").value)||0;
        let beratSampah=parseFloat(document.getElementById("berat").value)||0;
        let totalHarga=hargaPerKg*beratSampah;

        // Format angka menjadi format Rupiah
        let formattedHarga=new Intl.NumberFormat('id-ID',{
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(totalHarga);

        document.getElementById("total_harga").value=formattedHarga;
    }

    function showModal(message) {
        document.getElementById("statusMessage").innerText=message;
        document.getElementById("statusModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("statusModal").classList.add("hidden");
        window.location.reload();
    }

    document.getElementById("jenis_sampah").addEventListener("change",function() {
        var selectedOption=this.value;
        var inputJenisSampahLainnya=document.getElementById("inputJenisSampahLainnya");

        // Mengecek apakah pilihan adalah "Lainnya"
        if(selectedOption.includes("Lainnya")) {
            // Menampilkan input form untuk jenis sampah lainnya
            inputJenisSampahLainnya.classList.remove("hidden");

            // Mengambil kategori dari optgroup label
            var kategori=this.options[this.selectedIndex].closest("optgroup").label;

            // Menghapus tanda kurung atau karakter tidak perlu dari kategori
            kategori=kategori.split(" (")[0]; // Mengambil teks sebelum tanda kurung (misal: Kertas, Logam, Plastik)

            // Menyimpan kategori di hidden input
            document.getElementById("kategori").value=kategori;
        } else {
            // Menyembunyikan input form jika tidak memilih "Lainnya"
            inputJenisSampahLainnya.classList.add("hidden");

            // Mengambil kategori dari optgroup label
            var kategori=this.options[this.selectedIndex].closest("optgroup").label;

            // Menyimpan kategori di hidden input
            document.getElementById("kategori").value=kategori;
        }
    });



    document.getElementById("sampahForm").addEventListener("submit",function(event) {
        event.preventDefault();

        let formData=new FormData(this);

        fetch("compenents/submit_sampah.php",{
            method: "POST",
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                showModal(data.includes("berhasil")? "Data Berhasil Dimasukkan!":"Gagal Memasukkan Data!");
            })
            .catch(() => {
                showModal("Terjadi Kesalahan!");
            });
    });

    document.getElementById("nama").addEventListener("keyup",function() {
        let inputNama=this.value.trim();
        let suggestionsBox=document.getElementById("suggestions");

        if(inputNama.length>0) {
            fetch(`compenents/search_nasabah.php?nama=${inputNama}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML="";

                    if(data.length>0) {
                        suggestionsBox.classList.remove("hidden");

                        data.forEach(nasabah => {
                            let item=document.createElement("div");
                            item.className="p-2 cursor-pointer hover:bg-gray-100";
                            item.textContent=nasabah.nama;
                            item.onclick=function() {
                                document.getElementById("nama").value=nasabah.nama;
                                document.getElementById("nik").value=nasabah.nik;
                                document.getElementById("alamat").value=nasabah.alamat;
                                suggestionsBox.classList.add("hidden");
                            };
                            suggestionsBox.appendChild(item);
                        });
                    } else {
                        suggestionsBox.classList.add("hidden");
                    }
                });
        } else {
            suggestionsBox.classList.add("hidden");
        }
    });
</script>