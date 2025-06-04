<?php
// Koneksi ke database
include 'koneksi.php';

// Cek jika data pesanan dikirim lewat POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data pesanan yang dikirim
    $dataPesanan = json_decode(file_get_contents("php://input"), true);

    // Validasi data
    if (!empty($dataPesanan)) {
        $namaPemesan = $dataPesanan['pemesan'];
        $produk = $dataPesanan['produk'];
        $level = $dataPesanan['level'] ?? null; // Level hanya ada untuk produk 'mie'
        $jumlah = $dataPesanan['jumlah'];
        $catatan = $dataPesanan['catatan'] ?? '-';
        $harga = $dataPesanan['harga'];
        $subtotal = $dataPesanan['subtotal'];
        $tanggal = date('Y-m-d H:i:s');

        // Menyimpan pesanan ke database
        $sql = "INSERT INTO takeaway (nama_pembeli, nama_produk, level, jumlah, catatan, harga_satuan, subtotal, tanggal) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('ssisisss', $namaPemesan, $produk, $level, $jumlah, $catatan, $harga, $subtotal, $tanggal);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesanan.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data pesanan tidak lengkap.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>