<?php
include 'koneksi.php';

// Ambil data dari JSON yang dikirim oleh fetch
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan data lengkap
if (!isset($data['nama'], $data['hargaSatuan'], $data['jumlah'], $data['level'], $data['catatan'], $data['totalHarga'], $data['gambar'])) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$nama = $data['nama'];
$hargaSatuan = $data['hargaSatuan'];
$jumlah = $data['jumlah'];
$level = $data['level'];
$catatan = $data['catatan'];
$totalHarga = $data['totalHarga'];
$gambar = $data['gambar'];

// Pastikan user ID tersedia (misal dari session atau login)
$user_id = $_SESSION['user_id'] ?? 1; // Gantilah ini sesuai dengan cara Anda mengelola session user

// Query untuk menambahkan pesanan ke keranjang
$query = "INSERT INTO keranjang (user_id, nama, harga, jumlah, level, catatan, total, gambar) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("isiiisis", $user_id, $nama, $hargaSatuan, $jumlah, $level, $catatan, $totalHarga, $gambar);

if ($stmt->execute()) {
    // Mengirimkan data kembali setelah berhasil
    $response = [
        "success" => true,
        "message" => "Pesanan berhasil ditambahkan ke keranjang.",
        "jumlah" => getJumlahKeranjang($user_id) // Mengambil jumlah pesanan di keranjang
    ];
} else {
    // Menangani kesalahan
    $response = [
        "success" => false,
        "message" => "Gagal menambahkan pesanan ke keranjang."
    ];
}

echo json_encode($response);

// Fungsi untuk menghitung jumlah pesanan dalam keranjang
function getJumlahKeranjang($user_id) {
    global $koneksi;
    $sql = "SELECT SUM(jumlah) AS total FROM keranjang WHERE user_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}
?>