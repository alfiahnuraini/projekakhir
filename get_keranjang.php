<?php
session_start();
include 'koneksi.php'; // Pastikan file ini berisi koneksi ke database

// Ambil data keranjang dari tabel 'keranjang' dan tabel 'menu'
$query = "SELECT k.id, m.nama, m.harga, k.jumlah, k.level, k.catatan
          FROM keranjang k 
          JOIN menu m ON k.id_menu = m.id";
$result = mysqli_query($conn, $query);

$keranjang = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row['total'] = $row['harga'] * $row['jumlah']; // Hitung total harga
    $keranjang[] = $row;
}

// Mengembalikan data dalam format JSON
echo json_encode($keranjang);
?>
