<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM produk WHERE id = $id";

    if ($koneksi->query($sql) === TRUE) {
        echo "Sukses";
    } else {
        echo "Gagal";
    }
} else {
    echo "Invalid request";
}