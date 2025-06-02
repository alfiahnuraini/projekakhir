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

    // Cek apakah produk sudah ada berdasarkan nama
    $check = $koneksi->prepare("SELECT * FROM produk WHERE nama = ?");
    $check->bind_param("s", $nama);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Produk sudah ada, update stok dan data lainnya
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $stokBaru = $row['stok'] + $stok;

        // Jika ada gambar baru diupload
        if (!empty($namaFile)) {
            move_uploaded_file($tmp, $folder . $namaFile);
            $update = $koneksi->prepare("UPDATE produk SET harga=?, stok=?, kategori=?, gambar=? WHERE id=?");
            $update->bind_param("iissi", $harga, $stokBaru, $kategori, $namaFile, $id);
        } else {
            // Jika tidak upload gambar baru
            $update = $koneksi->prepare("UPDATE produk SET harga=?, stok=?, kategori=? WHERE id=?");
            $update->bind_param("iisi", $harga, $stokBaru, $kategori, $id);
        }

        if ($update->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal memperbarui produk.";
        }
    } else {
        // Produk belum ada, tambah baru
        if (move_uploaded_file($tmp, $folder . $namaFile)) {
            $insert = $koneksi->prepare("INSERT INTO produk (nama, harga, stok, kategori, gambar) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("siiss", $nama, $harga, $stok, $kategori, $namaFile);
            if ($insert->execute()) {
                header("Location: index.php");
                exit;
            } else {
                echo "Gagal menambah produk.";
            }
        } else {
            echo "Gagal upload gambar.";
        }
    }
}
?>