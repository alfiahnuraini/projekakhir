<?php
include 'koneksi.php';

// Hapus semua pesanan setelah dibayar
$koneksi->query("DELETE FROM pesanan");

echo json_encode(['status' => 'deleted']);
?>