<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Membership</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        input {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
    <!-- Add the SheetJS (xlsx.js) library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Data Transaksi Membership</h1>
        
        <!-- Input Search dan Button Search -->
        <input type="text" id="searchInput" placeholder="Cari Plat Nomor Kendaraan...">
        <button id="searchButton" onclick="searchData()">Search</button>

        <!-- Export to Excel Button -->
        <button id="exportButton" onclick="exportToExcel()">Export to Excel</button>
        
        <!-- Tabel Data -->
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Location Code</th>
                    <th>Transaction Date</th>
                    <th>Vehicle Type</th>
                    <th>Vehicle Plate Number</th>
                    <th>Name</th>
                    <th>Product</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Membership Status</th>
                    <th>Smartcard Number</th>
                    <th>Nama Lokasi</th>  <!-- Kolom baru untuk Nama Lokasi -->
                </tr>
            </thead>

            <tbody id="tableBody">
                <!-- Data akan dimasukkan di sini oleh JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        // Fungsi untuk menampilkan data ke tabel
        function displayData(data) {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = ''; // Hapus data lama

            data.forEach(item => {
                const row = document.createElement('tr');
                
                Object.values(item).forEach((value, index) => {
                    // Tambahkan kolom nama_lokasi
                    const cell = document.createElement('td');
                    cell.textContent = value;
                    row.appendChild(cell);
                });

                tableBody.appendChild(row);
            });
        }

        // Fungsi untuk mencari data berdasarkan plat nomor
        function searchData() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();

            // Mengambil data dari server hanya saat tombol "Search" diklik
            fetch('get_data.php?plateNumber=' + encodeURIComponent(searchInput))
                .then(response => response.json())
                .then(data => {
                    displayData(data); // Menampilkan data ke tabel
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Fungsi untuk mengekspor data ke Excel
        function exportToExcel() {
            const table = document.getElementById("dataTable");
            const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet 1" });
            XLSX.writeFile(wb, "Data_Transaksi_Membership.xlsx");
        }

        // Tampilkan data awal saat halaman dimuat (opsional jika Anda ingin menampilkan semua data tanpa filter pada awal)
        window.onload = function() {
            displayData([]); // Awalnya kosong atau Anda bisa mengambil data awal tanpa filter
        };
    </script>
</body>
</html>
