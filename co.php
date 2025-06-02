<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['laporan'])) {
    foreach ($data['laporan'] as $item) {
        $no_meja = $item['no_meja'];
        $nama_produk = $item['nama_produk'];
        $jumlah = $item['jumlah'];
        $subtotal = $item['subtotal'];
        $tanggal = $item['tanggal'];

        // Cek apakah data sudah ada
        $cek = $koneksi->prepare("SELECT id FROM laporan WHERE no_meja=? AND nama_produk=? AND jumlah=? AND subtotal=? AND tanggal=?");
        $cek->bind_param("ssiis", $no_meja, $nama_produk, $jumlah, $subtotal, $tanggal);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows == 0) {
            $stmt = $koneksi->prepare("INSERT INTO laporan (no_meja, nama_produk, jumlah, subtotal, tanggal) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiis", $no_meja, $nama_produk, $jumlah, $subtotal, $tanggal);
            $stmt->execute();
        }
    }

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "no data"]);
}
?>