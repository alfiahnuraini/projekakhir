<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    // Upload gambar
    $namaFile = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "gambar/";

    // Simpan gambar ke folder
    if (move_uploaded_file($tmp, $folder.$namaFile)) {
        $sql = "INSERT INTO produk (nama, harga, stok, kategori, gambar)
                VALUES ('$nama', '$harga', '$stok', '$kategori', '$namaFile')";
        
        if ($koneksi->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>