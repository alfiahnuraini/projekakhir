<?php
session_start();
include 'koneksi.php'; // Pastikan file ini berisi koneksi ke database

// Ambil isi keranjang dari database, misalnya dari tabel 'keranjang'
$query = "SELECT k.id, m.nama, m.harga, k.jumlah 
          FROM keranjang k 
          JOIN menu m ON k.id_menu = m.id";
$result = mysqli_query($conn, $query);

$keranjang = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row['total'] = $row['harga'] * $row['jumlah'];
    $keranjang[] = $row;
}

// Mengembalikan data dalam bentuk JSON agar bisa dibaca JavaScript
echo json_encode($keranjang);
?>
