<?php
include('db.php');
include 'navbar.php';

// Ambil data dari tabel nasabah
$result = $conn->query("SELECT * FROM nasabah ORDER BY id ASC");

// Simpan data awal dalam array JavaScript
$nasabah_data = [];
while ($row = $result->fetch_assoc()) {
    $nasabah_data[] = $row;
}
?>

<body class="bg-white">

    <!-- Container -->
    <div class="container mx-auto px-4 md:p-6 bg-white rounded-lg shadow-lg z-10 mt-4 md:mt-10 pt-16 md:pt-20">
        <h1 class="text-2xl md:text-4xl font-bold text-center text-teal-600 mb-4 md:mb-6">Data Nasabah</h1>

        <!-- Search & Filter & Tambah Nasabah -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2 md:gap-4">
            <div class="relative w-full md:w-1/3 z-0 flex">
                <i
                    class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                <input type="text" id="search" placeholder="Cari Nama / NIK..."
                    class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm md:text-base">
            </div>

            <div class="w-full md:w-auto flex flex-col md:flex-row gap-2 md:gap-4">
                <!-- Tombol Tambah Nasabah -->
                <button onclick="openModal()"
                    class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 text-sm md:text-base">
                    Tambah Nasabah
                </button>

                <!-- Tombol Print PDF -->
                <a href="compenents/print_pdf.php" target="_blank"
                    class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 text-center text-sm md:text-base">
                    Print PDF
                </a>

                <select id="filter"
                    class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm md:text-base">
                    <option value="">Semua</option>
                    <option value="asc">A - Z</option>
                    <option value="desc">Z - A</option>
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full table-auto md:table-fixed border-collapse bg-white shadow-md" id="nasabah-table">
                <thead>
                    <tr class="bg-teal-600 text-white">
                        <th class="w-1/12 p-2 md:p-4 text-left cursor-pointer" onclick="sortTable(0)">ID</th>
                        <th class="w-3/12 p-2 md:p-4 text-left cursor-pointer" onclick="sortTable(1)">Nama</th>
                        <th class="w-3/12 p-2 md:p-4 text-left cursor-pointer" onclick="sortTable(2)">NIK</th>
                        <th class="hidden md:table-cell w-3/12 p-2 md:p-4 text-left cursor-pointer"
                            onclick="sortTable(3)">Alamat</th>
                        <th class="w-2/12 p-2 md:p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" id="nasabah-body">
                    <?php
                    $id_counter = 1;
                    foreach ($nasabah_data as $row) {
                        echo "<tr class='border-b hover:bg-gray-100 transition' id='nasabah-row-" . $row['id'] . "'>";
                        echo "<td class='p-2 md:p-4'>" . $row['id'] . "</td>";
                        echo "<td class='p-2 md:p-4'>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td class='p-2 md:p-4'>" . htmlspecialchars($row['nik']) . "</td>";
                        echo "<td class='hidden md:table-cell p-2 md:p-4'>" . htmlspecialchars($row['alamat']) . "</td>";
                        echo "<td class='p-2 md:p-4'>
                            <div class='flex flex-col md:flex-row gap-1 md:gap-4'>
                                <button onclick='editData(" . $row['id'] . ")' class='text-teal-600 hover:text-teal-800 text-sm md:text-base'>Edit</button>
                                <button onclick='deleteData(" . $row['id'] . ")' class='text-red-600 hover:text-red-800 text-sm md:text-base'>Hapus</button>
                            </div>
                          </td>";
                        echo "</tr>";
                        $id_counter++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Nasabah -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-11/12 md:w-96 mx-4">
            <h2 class="text-lg md:text-xl font-bold mb-4 text-center">Tambah Nasabah</h2>
            <form id="addNasabahForm">
                <input type="text" id="nama" placeholder="Nama" required
                    class="w-full p-2 border border-gray-300 rounded-lg mb-2 text-sm md:text-base">
                <input type="text" id="nik" placeholder="NIK" required
                    class="w-full p-2 border border-gray-300 rounded-lg mb-2 text-sm md:text-base">
                <input type="text" id="alamat" placeholder="Alamat" required
                    class="w-full p-2 border border-gray-300 rounded-lg mb-4 text-sm md:text-base">
                <div class="flex justify-between gap-2">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white p-2 rounded-lg flex-1 text-sm md:text-base">Batal</button>
                    <button type="submit"
                        class="bg-teal-600 text-white p-2 rounded-lg hover:bg-teal-700 flex-1 text-sm md:text-base">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Nasabah -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-11/12 md:w-96 mx-4">
            <h2 class="text-lg md:text-xl font-bold mb-4 text-center">Edit Nasabah</h2>
            <form id="editNasabahForm">
                <input type="hidden" id="editId">
                <input type="text" id="editNama" placeholder="Nama" required
                    class="w-full p-2 border border-gray-300 rounded-lg mb-2 text-sm md:text-base">
                <input type="text" id="editNik" placeholder="NIK" required
                    class="w-full p-2 border border-gray-300 rounded-lg mb-2 text-sm md:text-base">
                <input type="text" id="editAlamat" placeholder="Alamat" required
                    class="w-full p-2 border border-gray-300 rounded-lg mb-4 text-sm md:text-base">
                <div class="flex justify-between gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-500 text-white p-2 rounded-lg flex-1 text-sm md:text-base">Batal</button>
                    <button type="submit"
                        class="bg-teal-600 text-white p-2 rounded-lg hover:bg-teal-700 flex-1 text-sm md:text-base">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded",function() {
            // Fungsi untuk mencari data
            document.getElementById("search").addEventListener("keyup",function() {
                let searchValue=this.value.toLowerCase();
                let rows=document.querySelectorAll("#nasabah-body tr");

                rows.forEach(row => {
                    let nama=row.cells[1].textContent.toLowerCase();
                    let nik=row.cells[2].textContent.toLowerCase();
                    row.style.display=(nama.includes(searchValue)||nik.includes(searchValue))? "":"none";
                });
            });

            // Fungsi untuk membuka modal Edit dengan data yang sudah diisi
            window.editData=function(id) {
                let row=document.getElementById(`nasabah-row-${id}`);
                let nama=row.cells[1].textContent;
                let nik=row.cells[2].textContent;
                let alamat=row.cells[3].textContent;

                // Isi form modal edit
                document.getElementById("editId").value=id;
                document.getElementById("editNama").value=nama;
                document.getElementById("editNik").value=nik;
                document.getElementById("editAlamat").value=alamat;

                // Buka modal edit
                document.getElementById("editModal").classList.remove("hidden");
            };

            // Fungsi untuk menutup modal edit
            window.closeEditModal=function() {
                document.getElementById("editModal").classList.add("hidden");
            };

            // Menangani submit form edit
            document.getElementById("editNasabahForm").addEventListener("submit",function(event) {
                event.preventDefault();

                let id=document.getElementById("editId").value;
                let nama=document.getElementById("editNama").value;
                let nik=document.getElementById("editNik").value;
                let alamat=document.getElementById("editAlamat").value;

                fetch("compenents/proses_edit_nasabah.php",{
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: `id=${id}&nama=${nama}&nik=${nik}&alamat=${alamat}`
                })
                    .then(response => response.text())
                    .then(() => {
                        // Update data di tabel tanpa reload
                        let row=document.getElementById(`nasabah-row-${id}`);
                        row.cells[1].textContent=nama;
                        row.cells[2].textContent=nik;
                        row.cells[3].textContent=alamat;

                        // Tutup modal edit
                        closeEditModal();
                    });
            });

            // Fungsi untuk menghapus data
            window.deleteData=function(id) {
                if(confirm("Yakin ingin menghapus data?")) {
                    fetch("compenents/proses_hapus_nasabah.php",{
                        method: "POST",
                        headers: {"Content-Type": "application/x-www-form-urlencoded"},
                        body: `id=${id}`
                    })
                        .then(response => response.text())
                        .then(() => {
                            document.getElementById(`nasabah-row-${id}`).remove();
                        });
                }
            };

            // Fungsi untuk mengurutkan data berdasarkan Nama, ID, dan lainnya
            document.getElementById("filter").addEventListener("change",function() {
                let filterValue=this.value;
                let tableBody=document.getElementById("nasabah-body");
                let rows=Array.from(tableBody.rows);

                if(filterValue==="asc") {
                    rows.sort((a,b) => a.cells[1].textContent.localeCompare(b.cells[1].textContent));
                } else if(filterValue==="desc") {
                    rows.sort((a,b) => b.cells[1].textContent.localeCompare(a.cells[1].textContent));
                } else if(filterValue==="newest") {
                    rows.sort((a,b) => parseInt(b.cells[0].textContent)-parseInt(a.cells[0].textContent));
                } else if(filterValue==="oldest") {
                    rows.sort((a,b) => parseInt(a.cells[0].textContent)-parseInt(b.cells[0].textContent));
                } else {
                    return;
                }

                // Update tabel dengan urutan baru
                tableBody.innerHTML="";
                rows.forEach(row => tableBody.appendChild(row));
            });

            // Fungsi untuk membuka modal tambah data
            window.openModal=function() {
                document.getElementById("modal").classList.remove("hidden");
            };

            // Fungsi untuk menutup modal tambah data
            window.closeModal=function() {
                document.getElementById("modal").classList.add("hidden");
            };

            // Fungsi untuk menambah data nasabah
            document.getElementById("addNasabahForm").addEventListener("submit",function(event) {
                event.preventDefault();

                let nama=document.getElementById("nama").value;
                let nik=document.getElementById("nik").value;
                let alamat=document.getElementById("alamat").value;

                fetch("compenents/proses_tambah_nasabah.php",{
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: `nama=${nama}&nik=${nik}&alamat=${alamat}`
                })
                    .then(response => response.text())
                    .then(() => {
                        closeModal();
                        let tableBody=document.getElementById("nasabah-body");
                        let newRow=document.createElement("tr");
                        newRow.classList.add("border-b","hover:bg-gray-100","transition");

                        newRow.innerHTML=`
                    <td class="p-4">NEW</td>
                    <td class="p-4">${nama}</td>
                    <td class="p-4">${nik}</td>
                    <td class="p-4 hidden md:table-cell">${alamat}</td>
                    <td class="p-4">
                        <button onclick="editData('NEW')" class="text-teal-600 mr-2 hover:text-teal-800">Edit</button>
                        <button onclick="deleteData('NEW')" class="text-red-600 hover:text-red-800">Hapus</button>
                    </td>
                `;
                        tableBody.appendChild(newRow);
                    });
            });
        });
    </script>