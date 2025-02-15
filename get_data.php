<?php
header('Content-Type: application/json');

// Database connection details for trx_membership
$servername_1 = "110.0.100.70";
$username_1 = "root";
$password_1 = "P@ssw0rdKu!23";
$dbname_1 = "centrepark_datawarehouse";

// Database connection details for lokasi
$servername_2 = "110.0.100.71"; // Server yang sama atau berbeda jika perlu
$username_2 = "root";
$password_2 = "P@ssw0rdKu!23";
$dbname_2 = "site-dashboard"; // Database yang berisi tabel lokasi

// Create connection for trx_membership database
$conn_1 = new mysqli($servername_1, $username_1, $password_1, $dbname_1);

// Create connection for lokasi database
$conn_2 = new mysqli($servername_2, $username_2, $password_2, $dbname_2);

// Check connections
if ($conn_1->connect_error || $conn_2->connect_error) {
    die("Connection failed: " . $conn_1->connect_error . ' / ' . $conn_2->connect_error);
}

// Ambil plat nomor dari query string (parameter GET)
$plateNumber = isset($_GET['plateNumber']) ? $_GET['plateNumber'] : '';

// SQL query untuk trx_membership
$sql_1 = "SELECT location_code, transDate, newVehicleType, newVehiclePlateNumber, name, product, newStartDate, newEndDate, membershipStatus, newSmartcardNumber 
        FROM trx_membership 
        WHERE newVehiclePlateNumber LIKE '%" . $conn_1->real_escape_string($plateNumber) . "%' GROUP BY location_code";

// Execute query untuk trx_membership
$result_1 = $conn_1->query($sql_1);

// Array untuk menampung hasil
$data = [];
if ($result_1->num_rows > 0) {
    while($row = $result_1->fetch_assoc()) {
        // Ambil nama lokasi berdasarkan location_code dari tabel lokasi
        $location_code = $row['location_code'];
        $sql_2 = "SELECT nama_Lokasi FROM ms_lokasi ml WHERE kode_Lokasi LIKE '" . $conn_2->real_escape_string($location_code) . "'";
        $result_2 = $conn_2->query($sql_2);

        if ($result_2->num_rows > 0) {
            // Ambil nama lokasi dari query kedua
            $location_data = $result_2->fetch_assoc();
            $row['nama_Lokasi'] = $location_data['nama_Lokasi'];  // Menambahkan kolom nama_lokasi
        } else {
            $row['nama_Lokasi'] = '';  // Jika tidak ditemukan, beri nilai kosong
        }

        // Menambahkan baris data yang sudah diupdate dengan nama_lokasi
        $data[] = $row;
    }
}

// Close connections
$conn_1->close();
$conn_2->close();

// Return data as JSON
echo json_encode($data);
?>
