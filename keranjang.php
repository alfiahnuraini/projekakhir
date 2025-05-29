<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'] ?? 1;

$query = $koneksi->prepare("SELECT * FROM keranjang WHERE user_id = ? ORDER BY tanggal DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$pesanan = [];
$totalHargaSemua = 0;

while ($row = $result->fetch_assoc()) {
    $pesanan[] = $row;
    $totalHargaSemua += $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <style>
    .keranjang-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        font-family: 'Segoe UI', sans-serif;
    }
    .pesanan-card {
        display: flex;
        gap: 15px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 12px;
        align-items: center;
    }
    .pesanan-card img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }
    .info {
        flex: 1;
    }
    .info p {
        margin: 6px 0;
        color: #333;
    }
    .jumlah-control {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 5px 0;
    }
    .btn-ubah {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background-color: #e0e0e0;
        color: #333;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-ubah:hover {
        background-color: #bdbdbd;
    }
    .jumlah-display {
        min-width: 24px;
        text-align: center;
        font-weight: bold;
        color: #222;
    }
    .total-section {
        text-align: right;
        font-weight: bold;
        font-size: 18px;
        margin-top: 20px;
    }
    .checkout-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        margin-top: 15px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .checkout-btn:hover {
        background: #388e3c;
    }
    .back-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background: #f44336;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        margin-top: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .back-btn:hover {
        background: #d32f2f;
    }
    </style>
</head>
<body>

<div class="keranjang-container">
    <h2>Keranjang Anda</h2>

    <?php if (count($pesanan) > 0): ?>
        <?php foreach ($pesanan as $item): ?>
            <div class="pesanan-card" data-id="<?= $item['id'] ?>">
                <img src="<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                <div class="info">
                    <p><strong><?= htmlspecialchars($item['nama']) ?></strong></p>
                    <?php if ($item['level'] && $item['level'] !== '-') : ?>
                        <p>Level: <?= htmlspecialchars($item['level']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($item['catatan'])) : ?>
                        <p>Catatan: <?= htmlspecialchars($item['catatan']) ?></p>
                    <?php endif; ?>
                    <p>Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                    <div class="jumlah-control">
                        <button class="btn-ubah" onclick="ubahJumlah(<?= $item['id'] ?>, -1)">−</button>
                        <span class="jumlah-display" id="jumlah-<?= $item['id'] ?>"><?= $item['jumlah'] ?></span>
                        <button class="btn-ubah" onclick="ubahJumlah(<?= $item['id'] ?>, 1)">+</button>
                    </div>
                    <p id="total-<?= $item['id'] ?>" class="total-item" data-id="<?= $item['id'] ?>" data-total="<?= $item['total'] ?>">
                        Total: Rp <?= number_format($item['total'], 0, ',', '.') ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="total-section" id="total-semua">
            Total Seluruh: Rp <?= number_format($totalHargaSemua, 0, ',', '.') ?>
        </div>

        <form action="pesanan.php" method="POST">
            <button type="submit" class="checkout-btn">Checkout</button>
        </form>

        <form action="menu.php" method="POST">
            <button type="submit" class="back-btn">Kembali ke menu</button>
        </form>
    <?php else: ?>
        <p>Keranjang Anda kosong.</p>
    <?php endif; ?>
</div>

<script>
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
}

function updateTotalSemuaLangsung() {
    let total = 0;
    document.querySelectorAll('.total-item').forEach(item => {
        const nilai = parseInt(item.dataset.total);
        if (!isNaN(nilai)) total += nilai;
    });
    document.getElementById('total-semua').textContent = 'Total Seluruh: ' + formatRupiah(total);
}

function ubahJumlah(id, perubahan) {
    const aksi = perubahan === 1 ? 'tambah' : 'kurang';

    fetch('ubah_jumlah.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&aksi=${aksi}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.hapus) {
                const elemen = document.querySelector(`[data-id="${id}"]`);
                if (elemen) elemen.remove();
            } else {
                document.getElementById('jumlah-' + id).textContent = data.jumlah;
                const totalEl = document.getElementById('total-' + id);
                totalEl.textContent = 'Total: ' + formatRupiah(data.total);
                totalEl.dataset.total = data.total;
            }
            updateTotalSemuaLangsung();
        } else {
            alert("Gagal memperbarui jumlah");
        }
    });
}
</script>

</body>
</html>
