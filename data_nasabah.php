<?php
include('db.php');
include 'navbar.php';

// Konfigurasi Pagination
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$total_result = $conn->query("SELECT COUNT(*) as total FROM nasabah");
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $limit);

// Ambil data dengan pagination
$result = $conn->query("SELECT * FROM nasabah LIMIT $limit OFFSET $offset");
?>

<!-- Container -->
<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Data Nasabah</h1>

    <!-- Search & Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <!-- Input Search -->
        <div class="relative w-full md:w-1/3">
            <input type="text" id="search" placeholder=" Cari Nama / NIK..."
                class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <span class="absolute left-3 top-2.5 text-gray-400"><i data-lucide="search"></i></span>
        </div>

        <!-- Tombol Print -->
        <div class="text-right">
            <button onclick="printTable()" class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Print
                Data</button>
            <select id="filter"
                class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Semua</option>
                <?php foreach (range('A', 'Z') as $letter) {
                    echo "<option value='$letter'>$letter</option>";
                } ?>
            </select>
        </div>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto rounded-lg">
        <table class="w-full table-fixed border-collapse bg-white shadow-md">
            <thead>
                <tr class="bg-teal-600 text-white">
                    <th class="w-1 p-4 text-left cursor-pointer" onclick="sortTable(0)">
                        <div class="flex items-center">
                            ID <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                    <th class="w-1/4 p-4 text-left cursor-pointer" onclick="sortTable(1)">
                        <div class="flex items-center">
                            Nama <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                    <th class="w-1/4 p-4 text-left cursor-pointer" onclick="sortTable(2)">
                        <div class="flex items-center">
                            NIK <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                    <th class="w-1/4 p-4 text-left cursor-pointer" onclick="sortTable(3)">
                        <div class="flex items-center">
                            Alamat <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="nasabah-table" class="text-gray-700">
                <?php
                $id_counter = $offset + 1; // ID sesuai halaman
                $id_counter = 1; // Mulai dari 1
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b hover:bg-gray-100 transition'>";
                    echo "<td class='w-1/4 p-4'>" . $id_counter . "</td>"; // Menggunakan counter
                    echo "<td class='w-1/4 p-4'>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td class='w-1/4 p-4'>" . htmlspecialchars($row['nik']) . "</td>";
                    echo "<td class='w-1/4 p-4'>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "</tr>";
                    $id_counter++; // Tambah ID
                }

                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center mt-4">
        <ul class="flex space-x-2">
            <?php if ($page > 1): ?>
                <li><a href="?page=1" class="px-3 py-2 bg-gray-300 rounded-lg">First</a></li>
                <li><a href="?page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-gray-300 rounded-lg">Prev</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li><a href="?page=<?php echo $i; ?>"
                        class="px-3 py-2 <?php echo ($i == $page) ? 'bg-teal-600 text-white' : 'bg-gray-300'; ?> rounded-lg"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li><a href="?page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-gray-300 rounded-lg">Next</a></li>
                <li><a href="?page=<?php echo $total_pages; ?>" class="px-3 py-2 bg-gray-300 rounded-lg">Last</a></li>
            <?php endif; ?>
        </ul>
    </div>

</div>

<!-- Import Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    // Sorting Data
    function sortTable(columnIndex) {
        let table=document.getElementById("nasabah-table");
        let rows=Array.from(table.rows);
        let isAscending=table.getAttribute("data-sort")==="asc";

        rows.sort((a,b) => {
            let aText=a.cells[columnIndex].textContent.trim().toLowerCase();
            let bText=b.cells[columnIndex].textContent.trim().toLowerCase();
            return isAscending? aText.localeCompare(bText):bText.localeCompare(aText);
        });

        table.innerHTML="";
        rows.forEach(row => table.appendChild(row));
        table.setAttribute("data-sort",isAscending? "desc":"asc");
    }

    // Pencarian Data
    document.getElementById("search").addEventListener("keyup",function() {
        let searchValue=this.value.toLowerCase();
        let rows=document.querySelectorAll("#nasabah-table tr");

        rows.forEach(row => {
            let nama=row.cells[1].textContent.toLowerCase();
            let nik=row.cells[2].textContent.toLowerCase();
            row.style.display=(nama.includes(searchValue)||nik.includes(searchValue))? "":"none";
        });
    });

    // Filter Berdasarkan Huruf Awal Nama
    document.getElementById("filter").addEventListener("change",function() {
        let filterValue=this.value.toLowerCase();
        let rows=document.querySelectorAll("#nasabah-table tr");

        rows.forEach(row => {
            let nama=row.cells[1].textContent.toLowerCase();
            row.style.display=(filterValue===""||nama.startsWith(filterValue))? "":"none";
        });
    });
</script>