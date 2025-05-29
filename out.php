<?php
include 'connect.php';

if (isset($_POST['checkout'])) {
  $nama = $_POST['nama'];
  $menu = $_POST['menu'];
  $jumlah = $_POST['jumlah'];
  $level = $_POST['level'];

  // Ambil harga menu
  $q = mysqli_query($conn, "SELECT harga, stok FROM stok WHERE nama = '$menu'");
  $data = mysqli_fetch_assoc($q);
  $harga = $data['harga'];
  $stokSekarang = $data['stok'];

  if ($jumlah > $stokSekarang) {
    echo "Stok tidak mencukupi.";
    exit();
  }

  $total = $harga * $jumlah;

  // Simpan ke tabel pesanan
  $simpan = mysqli_query($conn, "INSERT INTO pesanan (nama, menu, jumlah, level, total) VALUES ('$nama', '$menu', $jumlah, '$level', $total)");

  // Kurangi stok
  $updateStok = mysqli_query($conn, "UPDATE stok SET stok = stok - $jumlah WHERE nama = '$menu'");

  if ($simpan && $updateStok) {
    header("Location: daftar_pesanan.php");
    exit();
  } else {
    echo "Gagal menyimpan pesanan.";
  }
}
?>