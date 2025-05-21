<?php
session_start();
include 'config.php';

// Ambil user_id dari session
$user_id = $_SESSION['user_id'] ?? 1;

// Hitung total item dalam keranjang
$sqlJumlah = "SELECT SUM(jumlah) AS total FROM keranjang WHERE user_id = $user_id";
$resultJumlah = $koneksi->query($sqlJumlah);
$totalItem = 0;

if ($resultJumlah && $rowJumlah = $resultJumlah->fetch_assoc()) {
    $totalItem = $rowJumlah['total'] ?? 0;
}

echo json_encode(['jumlah' => $totalItem]);
?>
