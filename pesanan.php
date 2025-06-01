<?php
session_start();
include 'koneksi.php';

// Ambil user_id dari session
$user_id = $_SESSION['user_id'] ?? 1;

// Ambil nomor meja dari POST (karena dari form checkout)
$meja = $_POST['meja'] ?? 'Tidak diketahui';

// Ambil data dari keranjang
$sql_keranjang = "SELECT * FROM keranjang WHERE user_id = ?";
$stmt = $koneksi->prepare($sql_keranjang);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$pesanan = [];
$subtotal = 0;

// Pindahkan ke tabel pesanan jika ada isinya
if ($result->num_rows > 0) {
    $insert = $koneksi->prepare("INSERT INTO pesanan (user_id, nama, harga, jumlah, total, level, catatan, gambar, meja, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    while ($row = $result->fetch_assoc()) {
        $pesanan[] = $row;
        $subtotal += $row['total'];

        $insert->bind_param(
            "isiiissss",
            $row['user_id'],
            $row['nama'],
            $row['harga'],
            $row['jumlah'],
            $row['total'],
            $row['level'],
            $row['catatan'],
            $row['gambar'],
            $meja
        );
        $insert->execute();
    }

    // Hapus isi keranjang setelah dipindah
    $koneksi->query("DELETE FROM keranjang WHERE user_id = $user_id");
}

// Ambil kembali data dari tabel pesanan (untuk ditampilkan)
$sql = "SELECT * FROM pesanan WHERE user_id = ? AND meja = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("is", $user_id, $meja);
$stmt->execute();
$result = $stmt->get_result();

$pesanan = [];
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $pesanan[] = $row;
    $subtotal += $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }
        .container {
            max-width: 412px;
            margin: auto;
            background-color: antiquewhite;
            padding: 10px 0;
        }
        .navbar {
            display: flex;
            justify-content: center;
        }
        .gambar img {
            width: 50px;
            height: 50px;
            margin: 9px 0 9px 15px;
        }
        .isinavbar {
            width: 100%;
            height: 53px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }
        .isinavbar a {
            color: black;
            font-size: 22px;
            font-family: 'Times New Roman', Times, serif;
            text-decoration: none;
        }
        .judul h1 {
            font-size: 25px;
            text-align: center;
        }
        .pesanan1 {
            max-width: 350px;
            border: 1px solid black;
            padding: 15px;
            margin: 20px auto;
            box-sizing: border-box;
            background: #fff;
        }
        .pesanan1 h2 {
            text-align: center;
            border-bottom: 1px solid black;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .catatan {
            font-size: 12px;
            color: gray;
            margin-top: -5px;
        }
        .jumlah {
            font-size: 15px;
            margin-top: -10px;
        }
        .bawah {
            border-top: 1px solid black;
            padding-top: 10px;
            text-align: right;
        }
        .produk {
            font-weight: bold;
        }
        .harga {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Navbar -->
    <div class="navbar">
        <div class="gambar"><img src="saung.png" /></div>
        <div class="isinavbar">
            <a href="home.html">HOME</a>
            <a href="menu.php">MENU</a>
            <a href="pesanan.php">PESANAN</a>
        </div>
    </div>

    <div class="judul"><h1>DAFTAR PESANAN</h1></div>

    <div class="container2">
        <div class="pesanan1">
            <h2>Meja <?= htmlspecialchars($meja) ?></h2>
            <div class="isi1">
                <?php if (count($pesanan) > 0): ?>
                    <?php foreach ($pesanan as $item): ?>
                        <div class="detail">
                            <div>
                                <p class="produk"><?= htmlspecialchars($item['nama']) ?> <?= $item['level'] ? 'lv.'.$item['level'] : '' ?></p>
                                <p class="jumlah"><?= $item['jumlah'] ?>x <span class="hargasatuan"><?= number_format($item['harga'], 0, ',', '.') ?></span></p>
                                <?php if (!empty($item['catatan'])): ?>
                                    <p class="catatan">Catatan: <?= htmlspecialchars($item['catatan']) ?></p>
                                <?php endif; ?>
                            </div>
                            <p class="harga">= <?= number_format($item['total'], 0, ',', '.') ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center;">Belum ada pesanan.</p>
                <?php endif; ?>
            </div>
            <div class="bawah">
                <p><strong>Subtotal: Rp <?= number_format($subtotal, 0, ',', '.') ?></strong></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
