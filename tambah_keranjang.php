<?php
include 'koneksi.php'; // koneksi ke DB

$id_menu = $_POST['id_menu'];
$jumlah = $_POST['jumlah'];
$level = $_POST['level'];
$catatan = $_POST['catatan'];

$stmt = $conn->prepare("INSERT INTO keranjang (id_menu, jumlah, level, catatan) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $id_menu, $jumlah, $level, $catatan);
$stmt->execute();

echo "Sukses";
