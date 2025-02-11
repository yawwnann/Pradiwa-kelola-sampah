<?php include('db.php'); ?>
<?php include 'navbar.php'; ?>

<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg mt-20">
    <h1 class="text-2xl font-bold text-center text-teal-600 mb-6">Input Data Sampah</h1>

    <form id="sampahForm" method="POST">
        <!-- Input Nama -->
        <div class="space-y-1 relative">
            <label for="nama" class="block text-sm font-semibold text-teal-700">Nama</label>
            <input type="text" name="nama" id="nama"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required autocomplete="off">
            <div id="suggestions" class="absolute w-full bg-white border border-gray-300 rounded-lg shadow-md hidden">
            </div>
        </div>

        <!-- Input NIK -->
        <div class="space-y-1">
            <label for="nik" class="block text-sm font-semibold text-teal-700">NIK</label>
            <input type="text" name="nik" id="nik"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required readonly>
        </div>

        <!-- Input Alamat -->
        <div class="space-y-1">
            <label for="alamat" class="block text-sm font-semibold text-teal-700">Alamat</label>
            <textarea name="alamat" id="alamat"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required readonly></textarea>
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

        <!-- Input Berat Sampah -->
        <div class="space-y-1">
            <label for="berat" class="block text-sm font-semibold text-teal-700">Berat Sampah (kg)</label>
            <input type="number" name="berat" id="berat" step="0.01"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Input Tanggal (Secara Default Hari Ini) -->
        <div class="space-y-1">
            <label for="tanggal" class="block text-sm font-semibold text-teal-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                class="w-full p-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200"
                required>
        </div>

        <!-- Tombol Kirim Data -->
        <button type="submit"
            class="w-full py-3 bg-teal-600 mt-4 text-white font-bold rounded-lg hover:bg-teal-700 transition duration-300">Kirim
            Data</button>
    </form>
</div>

<!-- MODAL STATUS -->
<div id="statusModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
        <h2 id="statusMessage" class="text-lg font-bold text-teal-700"></h2>
        <button onclick="closeModal()"
            class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 mt-4">OK</button>
    </div>
</div>

<script>
    // Set default tanggal ke hari ini
    document.addEventListener("DOMContentLoaded",function() {
        let today=new Date();
        let formattedDate=today.toISOString().split('T')[0];
        document.getElementById("tanggal").value=formattedDate;
    });

    function showModal(message) {
        document.getElementById("statusMessage").innerText=message;
        document.getElementById("statusModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("statusModal").classList.add("hidden");
        window.location.reload();
    }

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

        if(inputNama.length>0) {
            fetch(`compenents/search_nasabah.php?nama=${inputNama}`)
                .then(response => response.json())
                .then(data => {
                    let suggestionsBox=document.getElementById("suggestions");
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
            document.getElementById("suggestions").classList.add("hidden");
        }
    });
</script>