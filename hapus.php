<?php
include 'koneksi.php';

// Hapus jika ada parameter ?hapus=ID
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
    header("Location: stok.php");
    exit;
}
?>