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

<!-- Container -->
<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg z-10 mt-20">
    <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Data Nasabah</h1>

    <!-- Search & Filter & Tambah Nasabah -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <div class="relative w-full md:w-1/3 z-0 flex">
            <i
                class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
            <input type="text" id="search" placeholder="Cari Nama / NIK..."
                class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>

        <div class="text-right flex gap-4">
            <!-- Tombol Tambah Nasabah -->
            <button onclick="openModal()" class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                Tambah Nasabah
            </button>

            <!-- Tombol Print PDF -->
            <a href="compenents/print_pdf.php" target="_blank"
                class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                Print PDF
            </a>

            <select id="filter"
                class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
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
        <table class="w-full table-fixed border-collapse bg-white shadow-md" id="nasabah-table">
            <thead>
                <tr class="bg-teal-600 text-white">
                    <th class="w-1 p-4 text-left cursor-pointer" onclick="sortTable(0)">ID</th>
                    <th class="w-1/4 p-4 text-left cursor-pointer" onclick="sortTable(1)">Nama</th>
                    <th class="w-1/4 p-4 text-left cursor-pointer" onclick="sortTable(2)">NIK</th>
                    <th class="w-1/4 p-4 text-left cursor-pointer" onclick="sortTable(3)">Alamat</th>
                    <th class="w-1/4 p-4 text-left">Aksic</th>
                </tr>
            </thead>
            <tbody class="text-gray-700" id="nasabah-body">
                <?php
                $id_counter = 1;
                foreach ($nasabah_data as $row) {
                    echo "<tr class='border-b hover:bg-gray-100 transition' id='nasabah-row-" . $row['id'] . "'>";
                    echo "<td class='w-1/4 p-4'>" . $row['id'] . "</td>";
                    echo "<td class='w-1/4 p-4'>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td class='w-1/4 p-4'>" . htmlspecialchars($row['nik']) . "</td>";
                    echo "<td class='w-1/4 p-4'>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td class='w-1/4 p-4 text-left'>
                            <button onclick='editData(" . $row['id'] . ")' class='text-teal-600  mr-6 hover:text-teal-800'>Edit</button>
                            <button onclick='deleteData(" . $row['id'] . ")' class='text-red-600 hover:text-red-800'>Hapus</button>
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
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4 text-center">Tambah Nasabah</h2>
        <form id="addNasabahForm">
            <input type="text" id="nama" placeholder="Nama" required
                class="w-full p-2 border border-gray-300 rounded-lg mb-2">
            <input type="text" id="nik" placeholder="NIK" required
                class="w-full p-2 border border-gray-300 rounded-lg mb-2">
            <input type="text" id="alamat" placeholder="Alamat" required
                class="w-full p-2 border border-gray-300 rounded-lg mb-4">
            <div class="flex justify-between">
                <button type="button" onclick="closeModal()"
                    class="bg-gray-500 text-white p-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-teal-600 text-white p-2 rounded-lg hover:bg-teal-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Edit Nasabah -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4 text-center">Edit Nasabah</h2>
        <form id="editNasabahForm">
            <input type="hidden" id="editId">
            <input type="text" id="editNama" placeholder="Nama" required
                class="w-full p-2 border border-gray-300 rounded-lg mb-2">
            <input type="text" id="editNik" placeholder="NIK" required
                class="w-full p-2 border border-gray-300 rounded-lg mb-2">
            <input type="text" id="editAlamat" placeholder="Alamat" required
                class="w-full p-2 border border-gray-300 rounded-lg mb-4">
            <div class="flex justify-between">
                <button type="button" onclick="closeEditModal()"
                    class="bg-gray-500 text-white p-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-teal-600 text-white p-2 rounded-lg hover:bg-teal-700">Simpan</button>
            </div>
        </form>
    </div>
</div>


<script>
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


    // Fungsi untuk mengedit data nasabah
    function editData(id) {
        // Ambil data nasabah berdasarkan ID
        let row=document.getElementById('nasabah-row-'+id);
        let nama=row.cells[1].innerText;
        let nik=row.cells[2].innerText;
        let alamat=row.cells[3].innerText;

        // Isi data ke form edit
        document.getElementById('editId').value=id;
        document.getElementById('editNama').value=nama;
        document.getElementById('editNik').value=nik;
        document.getElementById('editAlamat').value=alamat;

        // Buka modal edit
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal edit
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Menangani submit form edit
    document.getElementById("editNasabahForm").addEventListener("submit",function(event) {
        event.preventDefault();

        let id=document.getElementById("editId").value;
        let nama=document.getElementById("editNama").value;
        let nik=document.getElementById("editNik").value;
        let alamat=document.getElementById("editAlamat").value;

        // Mengirim data ke server untuk mengupdate data
        fetch("compenents/proses_edit_nasabah.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&nama=${nama}&nik=${nik}&alamat=${alamat}`
        })
            .then(response => response.text())
            .then(data => {
                // Mengupdate data pada tabel tanpa reload
                let row=document.getElementById('nasabah-row-'+id);
                row.cells[1].innerText=nama;
                row.cells[2].innerText=nik;
                row.cells[3].innerText=alamat;

                // Menutup modal edit
                closeEditModal();
            });
    });


    // Fungsi untuk menghapus data
    function deleteData(id) {
        if(confirm("Yakin ingin menghapus data?")) {
            // Mengirim permintaan ke server untuk menghapus data
            fetch("compenents/proses_hapus_nasabah.php",{
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${id}`
            })
                .then(response => response.text())
                .then(data => {
                    // Menghapus baris tabel setelah berhasil
                    let row=document.getElementById('nasabah-row-'+id);
                    row.remove();
                });
        }
    }


</script>
<script>
    // Fungsi untuk membuka modal
    function openModal() {
        document.getElementById("modal").classList.remove("hidden");
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById("modal").classList.add("hidden");
    }

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
            .then(data => {
                closeModal();
                let tableBody=document.getElementById("nasabah-body");
                let newRow=document.createElement("tr");
                newRow.classList.add("border-b","hover:bg-gray-100","transition");
                newRow.innerHTML=`
                <td class='w-1/4 p-4'>NEW</td>
                <td class='w-1/4 p-4'>${nama}</td>
                <td class='w-1/4 p-4'>${nik}</td>
                <td class='w-1/4 p-4'>${alamat}</td>
                <td class='w-1/4 p-4 text-center'>
                    <button class='p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700'>Edit</button>
                    <button class='p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 ml-2'>Hapus</button>
                </td>
            `;
                tableBody.appendChild(newRow);
            });
    });


    //Sorting Data berdasarkan filter A-Z, Z-A, Terbaru, Terlama
    document.getElementById("filter").addEventListener("change",function() {
        let filterValue=this.value;
        let tableBody=document.getElementById("nasabah-body");
        let rows=Array.from(tableBody.rows);

        if(filterValue==="asc") {
            // Urutkan A-Z berdasarkan Nama
            rows.sort((a,b) => {
                let aText=a.cells[1].textContent.trim().toLowerCase();
                let bText=b.cells[1].textContent.trim().toLowerCase();
                return aText.localeCompare(bText);
            });
        } else if(filterValue==="desc") {
            // Urutkan Z-A berdasarkan Nama
            rows.sort((a,b) => {
                let aText=a.cells[1].textContent.trim().toLowerCase();
                let bText=b.cells[1].textContent.trim().toLowerCase();
                return bText.localeCompare(aText);
            });
        } else if(filterValue==="newest") {
            // Urutkan berdasarkan ID terbaru (ID besar ke kecil)
            rows.sort((a,b) => {
                let aText=parseInt(a.cells[0].textContent.trim(),10);
                let bText=parseInt(b.cells[0].textContent.trim(),10);
                return bText-aText;
            });
        } else if(filterValue==="oldest") {
            // Urutkan berdasarkan ID terlama (ID kecil ke besar)
            rows.sort((a,b) => {
                let aText=parseInt(a.cells[0].textContent.trim(),10);
                let bText=parseInt(b.cells[0].textContent.trim(),10);
                return aText-bText;
            });
        } else {
            // Kembalikan ke data awal jika "Semua" dipilih
            resetTable();
            return;
        }

        // Perbarui tabel dengan urutan baru
        tableBody.innerHTML=""; // Kosongkan tabel sebelum menambahkan kembali baris yang sudah diurutkan
        rows.forEach(row => tableBody.appendChild(row));
    });
</script>