<?php
// Koneksi ke database menu di Laptop 1
$conn1 = new mysqli("192.168.1.14", "syncuser", "sync123", "saung_bahagia");
if ($conn1->connect_error) {
    die("Koneksi ke Laptop 1 gagal: " . $conn1->connect_error);
}

// Ambil data menu
$result = $conn1->query("SELECT * FROM produk");

// Koneksi ke database menu di Laptop 2
$conn2 = new mysqli("localhost", "root", "", "saung_bahagia");
if ($conn2->connect_error) {
    die("Koneksi ke Laptop 2 gagal: " . $conn2->connect_error);
}

while ($row = $result->fetch_assoc()) {
    $namaProduk = $conn2->real_escape_string($row['nama']);
    $harga = $row['harga'];
    $stok = $row['stok'] ?? 0;
    $kategori = $conn2->real_escape_string($row['kategori']);
    $namaFile = $conn2->real_escape_string($row['gambar']);

    // Cek apakah produk sudah ada (misal berdasarkan nama)
    $cek = $conn2->query("SELECT * FROM produk WHERE nama = '$namaProduk'");
    if ($cek->num_rows == 0) {
        $insert = $conn2->query("INSERT INTO produk (nama, harga, stok, kategori, gambar)
                                 VALUES ('$nama', '$harga', '$stok', '$kategori', '$namaFile')");
        if (!$insert) {
            echo "Gagal insert: " . $conn2->error . "<br>";
        }
    } else {
        echo "Produk '$namaProduk' sudah ada, dilewati.<br>";
    }
}

echo "<br>Sinkronisasi selesai!";
?>
