<?php include('db.php');
include 'navbar.php'; ?>

<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Data Sampah</h1>

    <!-- Search & Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <!-- Input Search -->
        <div class="relative w-full md:w-1/3">
            <input type="text" id="search" placeholder=" Cari Nama Nasabah / Jenis Sampah..."
                class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <span class="absolute left-3 top-2.5 text-gray-400"><i data-lucide="search"></i></span>
        </div>
        <!-- Tombol Print -->
        <div class="text-right mb-4">
            <button onclick="printTable()" class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Print
                Data</button>
            <!-- Filter berdasarkan jenis sampah -->
            <select id="filter"
                class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
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
                    <th class="px-6 py-3 text-left cursor-pointer" onclick="sortTable(0)">
                        <div class="flex items-center">
                            Nama Nasabah
                            <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left cursor-pointer" onclick="sortTable(1)">
                        <div class="flex items-center">
                            Jenis Sampah
                            <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left cursor-pointer" onclick="sortTable(2)">
                        <div class="flex items-center">
                            Berat (kg)
                            <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left cursor-pointer" onclick="sortTable(3)">
                        <div class="flex items-center">
                            Tanggal
                            <i data-lucide="arrow-up-down" class="ml-2"></i>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="sampah-table" class="text-gray-700">
                <?php
                $result = $conn->query("SELECT nasabah.nama, sampah.jenis_sampah, sampah.berat, sampah.tanggal
                                       FROM sampah
                                       JOIN nasabah ON sampah.nasabah_id = nasabah.id");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b hover:bg-gray-100 transition'>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['jenis_sampah']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['berat']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['tanggal']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Import Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

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

    // Sorting Kolom
    function sortTable(columnIndex) {
        let table=document.getElementById("sampah-table");
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