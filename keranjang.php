<?php
include 'koneksi.php';

$meja = isset($_GET['meja']) ? $_GET['meja'] : '';

// Ambil data keranjang dari database berdasarkan nomor meja
$query = "SELECT * FROM keranjang WHERE meja = '$meja'";
$result = mysqli_query($conn, $query);

$total_harga = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Meja <?= htmlspecialchars($meja) ?></title>
    <style>
        .card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px auto;
            width: 80%;
            border-radius: 10px;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100px;
            height: auto;
        }
        .card-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .info {
            flex: 1;
        }
        .checkout {
            margin: 20px auto;
            text-align: center;
        }
        .checkout form button {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Keranjang Meja <?= htmlspecialchars($meja) ?></h2>

<?php while($row = mysqli_fetch_assoc($result)) {
    $total = $row['harga'] * $row['jumlah'];
    $total_harga += $total;
?>
    <div class="card">
        <div class="card-content">
            <img src="<?= $row['gambar'] ?>" alt="<?= $row['nama_menu'] ?>">
            <div class="info">
                <h3><?= $row['nama_menu'] ?></h3>
                <p>Harga: Rp<?= number_format($row['harga']) ?></p>
                <p>Jumlah: <?= $row['jumlah'] ?></p>
                <?php if (!empty($row['level'])): ?>
                    <p>Level: <?= $row['level'] ?></p>
                <?php endif; ?>
                <?php if (!empty($row['catatan'])): ?>
                    <p>Catatan: <?= $row['catatan'] ?></p>
                <?php endif; ?>
                <p><strong>Subtotal: Rp<?= number_format($total) ?></strong></p>
            </div>
        </div>
    </div>
<?php } ?>

<div class="checkout">
    <h3>Total Harga: Rp<?= number_format($total_harga) ?></h3>
    <form action="pesanan.php" method="POST">
        <input type="hidden" name="meja" value="<?= htmlspecialchars($meja) ?>">
        <button type="submit">Checkout</button>
    </form>
</div>

</body>
</html>
