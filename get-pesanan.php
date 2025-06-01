<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

// Ambil hanya pesanan yang belum dibayar
$sql = "SELECT * FROM pesanan ORDER BY meja, waktu ASC";
$result = $koneksi->query($sql);

$pesananGrouped = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meja = 'Meja ' . $row['meja'];
        if (!isset($pesananGrouped[$meja])) {
            $pesananGrouped[$meja] = [];
        }
        $pesananGrouped[$meja][] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($pesananGrouped);
?>