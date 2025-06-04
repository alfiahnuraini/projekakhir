<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "saung_bahagia";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

$nama = $conn->real_escape_string($data['nama']);
$pesanan = $data['pesanan'];

foreach ($pesanan as $item) {
  $menu  = $conn->real_escape_string($item['nama']);
  $harga = intval($item['harga']);

  $sql = "INSERT INTO pesanan (nama_pembeli, menu, harga) VALUES ('$nama', '$menu', $harga)";
  $conn->query($sql);
}

echo json_encode(["status" => "success", "message" => "Pesanan berhasil disimpan."]);
?>