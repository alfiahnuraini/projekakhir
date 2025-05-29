<?php
session_start();
include 'koneksi.php';

$id = $_POST['id'];
$aksi = $_POST['aksi'] ?? '';
$user_id = $_SESSION['user_id'] ?? 1;

$response = ['success' => false];

$query = $koneksi->prepare("SELECT jumlah, harga FROM keranjang WHERE id = ? AND user_id = ?");
$query->bind_param("ii", $id, $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $jumlah = $row['jumlah'];
    $harga = $row['harga'];

    if ($aksi === 'tambah') {
        $jumlah++;
    } elseif ($aksi === 'kurang') {
        $jumlah--;
    }

    if ($jumlah <= 0) {
        $del = $koneksi->prepare("DELETE FROM keranjang WHERE id = ? AND user_id = ?");
        $del->bind_param("ii", $id, $user_id);
        $del->execute();
        $response = ['success' => true, 'hapus' => true];
    } else {
        $total = $jumlah * $harga;
        $update = $koneksi->prepare("UPDATE keranjang SET jumlah = ?, total = ? WHERE id = ? AND user_id = ?");
        $update->bind_param("iiii", $jumlah, $total, $id, $user_id);
        $update->execute();

        $response = [
            'success' => true,
            'jumlah' => $jumlah,
            'total' => $total
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
