<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'] ?? 1;

// Ambil data dari tabel keranjang berdasarkan user_id
$sql = "SELECT * FROM keranjang WHERE user_id = $user_id";
$result = $koneksi->query($sql);

$keranjang = [];
$totalHarga = 0;

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $keranjang[] = $row;
        $totalHarga += $row['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="stylesheet" href="style11.css">
    <style>
        .keranjang-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 15px;
            border-radius: 10px;
            display: flex;
            gap: 15px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .keranjang-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }
        .keranjang-item .info {
            flex: 1;
        }
        .keranjang-item h3 {
            margin: 0;
        }
        .total-harga {
            text-align: right;
            margin: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .checkout-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: green;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .checkout-btn:hover {
            background: darkgreen;
        }
        .jumlah-btn {
            padding: 2px 10px;
            font-size: 16px;
            margin: 0 5px;
        }
        .jumlah-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 5px;
        }

        .jumlah-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 50%;
            background-color: #f0f0f0;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .jumlah-btn:hover {
            background-color: #ddd;
            transform: scale(1.1);
        }

        .jumlah-count {
            font-size: 16px;
            font-weight: bold;
            min-width: 24px;
            text-align: center;
        }

    </style>
</head>
<body>

<div class="ctn">
    <div class="navbar">
        <div class="gambar"><img src="saung-removebg-preview.png" /></div>
        <div class="isinavbar">
            <a href="home.html">HOME</a>
            <a href="menu.php">MENU</a>
            <a href="pesanan.php">PESANAN</a>
        </div>
    </div>

    <h1 style="text-align:center;">Keranjang Anda</h1>

    <?php if (count($keranjang) > 0): ?>
        <?php foreach ($keranjang as $item): ?>
            <div class="keranjang-item" data-id="<?= $item['id'] ?>">
                <img src="gambar/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                <div class="info">
                    <h3><?= htmlspecialchars($item['nama']) ?></h3>
                    <p>Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>


                    <?php if (!empty($item['level'])): ?>
                        <p>Level: <?= htmlspecialchars($item['level']) ?></p>
                    <?php endif; ?>

                    <div class="jumlah-wrapper">
                        <button class="jumlah-btn" onclick="ubahJumlah(<?= $item['id'] ?>, 'kurang')">−</button>
                        <div id="jumlah-<?= $item['id'] ?>" class="jumlah-count"><?= $item['jumlah'] ?></div>
                        <button class="jumlah-btn" onclick="ubahJumlah(<?= $item['id'] ?>, 'tambah')">+</button>
                    </div>

                    <?php if (!empty($item['catatan'])): ?>
                        <p>Catatan: <?= htmlspecialchars($item['catatan']) ?></p>
                    <?php endif; ?>

                    <p>Total: Rp <span id="total-<?= $item['id'] ?>"><?= number_format($item['total'], 0, ',', '.') ?></span></p>
                    
                </div>
            </div>
        <?php endforeach; ?>

        <div class="total-harga" id="total-semua">Total Harga: Rp <?= number_format($totalHarga, 0, ',', '.') ?></div>
        <form method="POST" action="checkout.php">
            <button type="submit" class="checkout-btn">Checkout</button>
        </form>
    <?php else: ?>
        <p style="text-align:center;">Keranjang Anda masih kosong.</p>
    <?php endif; ?>
</div>

<script>
function ubahJumlah(id, aksi) {
    fetch('ubah_jumlah.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&aksi=${aksi}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (data.hapus) {
                const itemEl = document.querySelector(`[data-id="${id}"]`);
                if (itemEl) itemEl.remove();
            } else {
                document.getElementById(`jumlah-${id}`).textContent = data.jumlah;
                document.getElementById(`total-${id}`).textContent = data.total_rp;
            }
            document.getElementById('total-semua').textContent = 'Total Harga: Rp ' + data.totalSeluruh_rp;
        } else {
            alert(data.message);
        }
    });
}
</script>

</body>
</html>
