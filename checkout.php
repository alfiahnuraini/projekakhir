<?php
$koneksi = new mysqli("localhost", "root", "", "saung_bahagia");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Kosongkan keranjang
$koneksi->query("DELETE FROM keranjang");

$koneksi->close();

// Redirect kembali ke menu
header("Location: menu.html");
exit();
?>
