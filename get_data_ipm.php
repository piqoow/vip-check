<?php
header('Content-Type: application/json');

$servername_1 = "110.0.100.70";
$username_1 = "root";
$password_1 = "P@ssw0rdKu!23";
$dbname_1 = "ipm_datawarehouse";

$servername_2 = "110.0.100.71";
$username_2 = "root";
$password_2 = "P@ssw0rdKu!23";
$dbname_2 = "ipm-dashboard";

$conn_1 = new mysqli($servername_1, $username_1, $password_1, $dbname_1);

$conn_2 = new mysqli($servername_2, $username_2, $password_2, $dbname_2);

if ($conn_1->connect_error || $conn_2->connect_error) {
    die("Connection failed: " . $conn_1->connect_error . ' / ' . $conn_2->connect_error);
}

$plateNumber = isset($_GET['plateNumber']) ? $_GET['plateNumber'] : '';

$sql_1 = "SELECT location_code, transDate, newVehicleType, newVehiclePlateNumber, name, product, newStartDate, newEndDate, membershipStatus, newSmartcardNumber 
        FROM trx_membership 
        WHERE newVehiclePlateNumber LIKE '%" . $conn_1->real_escape_string($plateNumber) . "%' GROUP BY location_code";

$result_1 = $conn_1->query($sql_1);

$data = [];
if ($result_1->num_rows > 0) {
    while($row = $result_1->fetch_assoc()) {
        $location_code = $row['location_code'];
        $sql_2 = "SELECT nama_Lokasi FROM ms_lokasi ml WHERE kode_Lokasi LIKE '" . $conn_2->real_escape_string($location_code) . "'";
        $result_2 = $conn_2->query($sql_2);

        if ($result_2->num_rows > 0) {
            $location_data = $result_2->fetch_assoc();
            $row['nama_Lokasi'] = $location_data['nama_Lokasi'];
        } else {
            $row['nama_Lokasi'] = '';
        }

        $data[] = $row;
    }
}

$conn_1->close();
$conn_2->close();

echo json_encode($data);
?>
