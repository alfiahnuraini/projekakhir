<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'] ?? 1;
$id = (int)($_POST['id'] ?? 0);
$aksi = $_POST['aksi'] ?? '';

if (!$id || !in_array($aksi, ['tambah', 'kurang'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid.']);
    exit;
}

$q = $koneksi->prepare("SELECT * FROM keranjang WHERE id = ? AND user_id = ?");
$q->bind_param("ii", $id, $user_id);
$q->execute();
$result = $q->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Item tidak ditemukan.']);
    exit;
}

$jumlah = (int)$row['jumlah'];
$harga = (int)$row['harga'];

$jumlah = ($aksi === 'tambah') ? $jumlah + 1 : $jumlah - 1;

if ($jumlah <= 0) {
    $del = $koneksi->prepare("DELETE FROM keranjang WHERE id = ? AND user_id = ?");
    $del->bind_param("ii", $id, $user_id);
    $del->execute();
    $hapus = true;
} else {
    $total = $jumlah * $harga;
    $upd = $koneksi->prepare("UPDATE keranjang SET jumlah = ?, total = ? WHERE id = ? AND user_id = ?");
    $upd->bind_param("iiii", $jumlah, $total, $id, $user_id);
    $upd->execute();
    $hapus = false;
}

$resTotal = $koneksi->query("SELECT SUM(total) AS totalSeluruh FROM keranjang WHERE user_id = $user_id");
$rowTotal = $resTotal->fetch_assoc();
$totalSeluruh = $rowTotal['totalSeluruh'] ?? 0;

echo json_encode([
    'success' => true,
    'hapus' => $hapus,
    'jumlah' => $jumlah,
    'total_rp' => number_format($jumlah * $harga, 0, ',', '.'),
    'totalSeluruh_rp' => number_format($totalSeluruh, 0, ',', '.')
]);
