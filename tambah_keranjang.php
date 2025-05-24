<?php
session_start();
header("Content-Type: application/json");
include 'config.php';

$data = [];

// Ambil inputan dari JSON atau POST biasa
$rawInput = file_get_contents("php://input");
$decoded = json_decode($rawInput, true);

if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
    $data = $decoded;
} elseif ($_POST) {
    $data = $_POST;
} else {
    echo json_encode([
        "success" => false,
        "message" => "Format data tidak dikenali (harus JSON atau POST)."
    ]);
    exit;
}

// Ambil data dari input
$nama       = $data['nama'] ?? '';
$gambar     = $data['gambar'] ?? '';
$catatan    = $data['catatan'] ?? '';
$jumlah     = (int)($data['jumlah'] ?? 1);
$harga      = (int)($data['hargaSatuan'] ?? ($data['harga'] ?? 0));
$total      = (int)($data['totalHarga'] ?? ($data['total'] ?? 0));
$user_id    = $_SESSION['user_id'] ?? 1;

// Cek dan ubah level dari array ke string jika perlu
$levelRaw   = $data['level'] ?? '-';
$level      = is_array($levelRaw) ? implode(', ', $levelRaw) : $levelRaw;

// Validasi data wajib
if ($nama === '' || $harga <= 0 || $jumlah <= 0) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap atau tidak valid."]);
    exit;
}

// Simpan ke database
$stmt = $koneksi->prepare("INSERT INTO keranjang (nama, gambar, level, catatan, jumlah, harga, total, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiiii", $nama, $gambar, $level, $catatan, $jumlah, $harga, $total, $user_id);

if ($stmt->execute()) {
    // Ambil jumlah total item dalam keranjang untuk feedback
    $result = $koneksi->query("SELECT SUM(jumlah) as total_item FROM keranjang WHERE user_id = $user_id");
    $row = $result->fetch_assoc();
    $totalItem = $row['total_item'] ?? 0;

    echo json_encode([
        "success" => true,
        "message" => "Pesanan berhasil ditambahkan.",
        "jumlah" => $totalItem
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan ke database: " . $stmt->error
    ]);
}
?>
