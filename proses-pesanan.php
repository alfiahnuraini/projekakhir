<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $jumlah = (int)$_POST['jumlah'];

  // Ambil stok produk
  $cek = mysqli_query($koneksi, "SELECT stok FROM produk WHERE nama='$nama'");
  $data = mysqli_fetch_assoc($cek);

  if ($data) {
    $stok = (int)$data['stok'];

    if ($stok >= $jumlah) {
      $sisa = $stok - $jumlah;
      $update = mysqli_query($koneksi, "UPDATE produk SET stok=$sisa WHERE nama='$nama'");

      if ($update) {
        echo " Pesanan berhasil! Sisa stok: $sisa";
      } else {
        echo " Gagal mengurangi stok.";
      }
    } else {
      echo " Stok tidak mencukupi. Tersisa $stok.";
    }
  } else {
    echo " Produk tidak ditemukan.";
  }
}
?>