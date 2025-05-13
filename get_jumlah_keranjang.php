<?php
header('Content-Type: application/json');
$host = "localhost";
$user = "root";
$pass = "";
$db = "your_database_name"; // ganti nama database kamu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["jumlah" => 0]);
    exit;
}

// Hitung total jumlah pesanan di keranjang
$sql = "SELECT SUM(jumlah) as total FROM keranjang"; 
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $jumlah = $row["total"] ?? 0;
    echo json_encode(["jumlah" => (int)$jumlah]);
} else {
    echo json_encode(["jumlah" => 0]);
}
?>
