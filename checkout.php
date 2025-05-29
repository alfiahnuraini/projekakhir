<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'] ?? 1;
$meja = $_GET['meja'] ?? 0;
date_default_timezone_set('Asia/Jakarta');
$waktu = date('Y-m-d H:i:s');

// Mulai transaksi
$koneksi->begin_transaction();

try {
    // Ambil data dari keranjang menggunakan prepared statement
    $sql = "SELECT * FROM keranjang WHERE user_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Simpan data ke tabel pesanan
            $insert_stmt = $koneksi->prepare("INSERT INTO pesanan (user_id, nama, harga, jumlah, total, level, catatan, gambar, meja, waktu)
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param(
                "isiiisssis",
                $user_id,
                $row['nama'],
                $row['harga'],
                $row['jumlah'],
                $row['total'],
                $row['level'],
                $row['catatan'],
                $row['gambar'],
                $meja,
                $waktu
            );
            $insert_stmt->execute();
        }

        // Kosongkan keranjang setelah data dipindahkan ke pesanan
        $delete_stmt = $koneksi->prepare("DELETE FROM keranjang WHERE user_id = ?");
        $delete_stmt->bind_param("i", $user_id);
        $delete_stmt->execute();

        // Commit transaksi jika semuanya berhasil
        $koneksi->commit();

        echo "<script>alert('Pesanan berhasil dikirim!'); window.location.href='pesanan.php';</script>";
    } else {
        throw new Exception("Keranjang kosong!");
    }
} catch (Exception $e) {
    // Rollback jika ada kesalahan
    $koneksi->rollback();
    echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href='menu.php';</script>";
}
?>
