<?php include('db.php');
include 'navbar.php'; ?>

<div class="container mx-auto px-4 md:p-6 bg-white rounded-lg mt-4 md:mt-10 pt-16 md:pt-20 mb-8 md:mb-20 shadow-lg">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="tampil_data_sampah.php"
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-all text-sm md:text-base">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <h1 class="text-2xl md:text-4xl font-bold text-center text-teal-600 mb-4 md:mb-6">Data Sampah</h1>

    <!-- Search sama Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2 md:gap-4">
        <div class="relative w-full md:w-1/3 z-0 flex">
            <i
                class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
            <input type="text" id="search" placeholder="Cari Nasabah / Jenis sampah...."
                class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm md:text-base">
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row gap-2 md:gap-4">
            <button onclick="printTable()"
                class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 text-sm md:text-base w-full md:w-auto">
                Print Data
            </button>
            <select id="filter"
                class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm md:text-base w-full md:w-auto">
                <option value="">Semua Jenis Sampah</option>
                <?php
                $result = $conn->query("SELECT DISTINCT jenis_sampah FROM sampah");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['jenis_sampah']) . "'>" . htmlspecialchars($row['jenis_sampah']) . "</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto rounded-lg">
        <table class="w-full table-auto border-collapse rounded-lg shadow-sm">
            <thead>
                <tr class="bg-teal-600 text-white">
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-sm md:text-base">Nama Nasabah</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-sm md:text-base">Jenis Sampah</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-sm md:text-base">Berat (kg)</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-sm md:text-base hidden md:table-cell">Tanggal
                    </th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-sm md:text-base">Aksi</th>
                </tr>
            </thead>
            <tbody id="sampah-table" class="text-gray-700">
                <?php
                $result = $conn->query("SELECT sampah.id, nasabah.nama, sampah.jenis_sampah, sampah.berat, sampah.tanggal
                            FROM sampah
                            JOIN nasabah ON sampah.nasabah_id = nasabah.id");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b hover:bg-gray-100 transition'>";
                    echo "<td class='px-3 md:px-6 py-2 md:py-3 text-sm md:text-base'>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td class='px-3 md:px-6 py-2 md:py-3 text-sm md:text-base'>" . htmlspecialchars($row['jenis_sampah']) . "</td>";
                    echo "<td class='px-3 md:px-6 py-2 md:py-3 text-sm md:text-base'>" . htmlspecialchars($row['berat']) . "</td>";
                    echo "<td class='px-3 md:px-6 py-2 md:py-3 text-sm md:text-base hidden md:table-cell'>" . htmlspecialchars($row['tanggal']) . "</td>";
                    echo "<td class='px-3 md:px-6 py-2 md:py-3'>
                            <div class='flex flex-wrap gap-1 md:gap-4'>
                                <button onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['jenis_sampah']) . "\", " . $row['berat'] . ", \"" . $row['tanggal'] . "\")' 
                                    class='text-teal-600 hover:text-teal-800 text-sm md:text-base'>Edit</button>
                                <button onclick='confirmDelete(" . $row['id'] . ")' 
                                    class='text-red-600 hover:text-red-800 text-sm md:text-base'>Hapus</button>
                            </div>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-11/12 md:w-96 mx-2">
        <h2 class="text-lg md:text-xl font-bold mb-4 text-center">Edit Sampah</h2>
        <form id="editForm" method="POST">
            <input type="hidden" id="editId">
            <div class="mb-2">
                <label for="jenis_sampah" class="text-sm md:text-base">Jenis Sampah</label>
                <input type="text" id="editJenisSampah" name="jenis_sampah" required
                    class="w-full p-2 border border-gray-300 rounded-lg mt-1 text-sm md:text-base">
            </div>
            <div class="mb-2">
                <label for="berat" class="text-sm md:text-base">Berat (kg)</label>
                <input type="number" id="editBerat" name="berat" required
                    class="w-full p-2 border border-gray-300 rounded-lg mt-1 text-sm md:text-base" step="0.01" min="0">
            </div>
            <div class="mb-4">
                <label for="tanggal" class="text-sm md:text-base">Tanggal</label>
                <input type="date" id="editTanggal" name="tanggal" required
                    class="w-full p-2 border border-gray-300 rounded-lg mt-1 text-sm md:text-base">
            </div>
            <div class="flex justify-between gap-2">
                <button type="button" onclick="closeEditModal()"
                    class="bg-gray-500 text-white p-2 rounded-lg flex-1 text-sm md:text-base">Batal</button>
                <button type="submit"
                    class="bg-teal-600 text-white p-2 rounded-lg hover:bg-teal-700 flex-1 text-sm md:text-base">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="confirmDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-11/12 md:w-96 mx-2">
        <h2 class="text-lg md:text-xl font-bold mb-4 text-center">Konfirmasi Penghapusan</h2>
        <p class="mb-4 text-center text-sm md:text-base">Apakah Anda yakin ingin menghapus data ini?</p>
        <div class="flex justify-between gap-2">
            <button type="button" onclick="closeConfirmDeleteModal()"
                class="bg-gray-500 text-white p-2 rounded-lg flex-1 text-sm md:text-base">Batal</button>
            <button id="confirmDeleteButton" type="button"
                class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 flex-1 text-sm md:text-base">Hapus</button>
        </div>
    </div>
</div>

<!-- Modal Data Berhasil Dihapus -->
<div id="successDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-11/12 md:w-96 mx-2 text-center">
        <h2 class="text-base md:text-lg font-bold text-green-600 mb-4">Data Berhasil Dihapus!</h2>
        <button onclick="closeSuccessDeleteModal()"
            class="bg-teal-600 text-white p-2 rounded-lg hover:bg-teal-700 text-sm md:text-base px-8">OK</button>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Pencarian Data
    document.getElementById("search").addEventListener("keyup",function() {
        let searchValue=this.value.toLowerCase();
        let rows=document.querySelectorAll("#sampah-table tr");

        rows.forEach(row => {
            let nama=row.cells[0].textContent.toLowerCase();
            let jenis_sampah=row.cells[1].textContent.toLowerCase();

            row.style.display=(nama.includes(searchValue)||jenis_sampah.includes(searchValue))? "":"none";
        });
    });

    // Filter Berdasarkan Jenis Sampah
    document.getElementById("filter").addEventListener("change",function() {
        let filterValue=this.value.toLowerCase();
        let rows=document.querySelectorAll("#sampah-table tr");

        rows.forEach(row => {
            let jenis_sampah=row.cells[1].textContent.toLowerCase();
            row.style.display=(filterValue===""||jenis_sampah===filterValue)? "":"none";
        });
    });

    // Fitur Edit Modal
    function openEditModal(id,jenis_sampah,berat,tanggal) {
        document.getElementById("editId").value=id;
        document.getElementById("editJenisSampah").value=jenis_sampah;
        document.getElementById("editBerat").value=berat;
        document.getElementById("editTanggal").value=tanggal;

        document.getElementById("editModal").classList.remove("hidden");
    }

    function closeEditModal() {
        document.getElementById("editModal").classList.add("hidden");
    }

    // Update Data via Modal
    document.getElementById("editForm").addEventListener("submit",function(event) {
        event.preventDefault();

        let id=document.getElementById("editId").value;
        let jenis_sampah=document.getElementById("editJenisSampah").value;
        let berat=document.getElementById("editBerat").value;
        let tanggal=document.getElementById("editTanggal").value;

        // Kirim data ke PHP untuk update
        fetch('compenents/edit_sampah.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&jenis_sampah=${jenis_sampah}&berat=${berat}&tanggal=${tanggal}`
        })
            .then(response => response.text())
            .then(data => {
                // Tutup modal dan update tabel
                closeEditModal();
                location.reload(); // Reload halaman untuk melihat perubahan
            });
    });

    // Hapus Data
    let deleteId=null;

    // Fungsi untuk membuka modal konfirmasi hapus
    function confirmDelete(id) {
        deleteId=id; // Menyimpan ID yang akan dihapus
        document.getElementById("confirmDeleteModal").classList.remove("hidden");
    }

    // Fungsi untuk menutup modal konfirmasi hapus
    function closeConfirmDeleteModal() {
        document.getElementById("confirmDeleteModal").classList.add("hidden");
    }

    // Fungsi untuk mengonfirmasi penghapusan data
    document.getElementById("confirmDeleteButton").addEventListener("click",function() {
        if(deleteId!==null) {
            // Menghapus data menggunakan PHP (menggunakan query string)
            window.location.href='compenents/hapus_sampah.php?id='+deleteId;
        }
    });

    // Fungsi untuk menutup modal data berhasil dihapus
    function closeSuccessDeleteModal() {
        document.getElementById("successDeleteModal").classList.add("hidden");
        location.reload(); // Refresh halaman setelah mengonfirmasi
    }

    // Fungsi untuk menampilkan modal data berhasil dihapus
    function showSuccessDeleteModal() {
        document.getElementById("successDeleteModal").classList.remove("hidden");
    }

    // Fitur Print
    function printTable() {
        let printWindow=window.open('','','height=600,width=800');
        let tableHTML=document.querySelector('table').outerHTML;

        printWindow.document.write('<html><head><title>Print Data Sampah</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
        printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
        printWindow.document.write('th { background-color: #4CAF50; color: white; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h1>Data Sampah</h1>');
        printWindow.document.write(tableHTML);
        printWindow.document.write('</body></html>');

        printWindow.document.close(); // Close the document to ensure the content is fully loaded before printing
        printWindow.print(); // Print the content
    }
</script>