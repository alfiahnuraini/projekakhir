<?php
// get_keranjang.php
require_once 'koneksi.php';

$sql = "SELECT SUM(jumlah) as total FROM keranjang WHERE status = 'pending'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode(['total' => $data['total'] ?? 0]);
?>
