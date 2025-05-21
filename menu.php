<?php
session_start();
include 'config.php';

// Ambil data produk dari database
$query = "SELECT * FROM produk";
$result = $koneksi->query($query);

// Kelompokkan berdasarkan kategori
$menu = [
    "mie" => [],
    "camilan" => [],
    "minuman" => []
];

while($row = $result->fetch_assoc()) {
    if (isset($menu[$row["kategori"]])) {
        $menu[$row["kategori"]][] = $row;
    }
}

// Ambil user_id dari session, default ke 1 jika belum login
$user_id = $_SESSION['user_id'] ?? 1;

// Hitung total item di keranjang
$jumlahKeranjang = 0;
$sqlJumlah = "SELECT SUM(jumlah) AS total FROM keranjang WHERE user_id = $user_id";
$resultJumlah = $koneksi->query($sqlJumlah);
if ($resultJumlah && $rowJumlah = $resultJumlah->fetch_assoc()) {
    $jumlahKeranjang = $rowJumlah['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="style11.css">
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

    <div class="atas">
        <div class="toko"><p>SAUNG <br> BAHAGIA</p></div>
        <form onsubmit="return searchProduct()">
            <input type="text" placeholder="Search..." class="search" id="searchInput">
            <button type="submit" class="search-btn">Search</button>
        </form>
        <div class="keranjang">
            <a href="keranjang.php">
                <img src="keranjang-removebg-preview.png" alt="Keranjang">
                <span class="nomor" id="cart-count"><?= $jumlahKeranjang ?></span>
            </a>
        </div>
    </div>

    <?php foreach ($menu as $kategori => $daftar): ?>
        <?php if (count($daftar) > 0): ?>
            <div class="h1"><h1><?= strtoupper($kategori) ?></h1></div>
            <div class="<?= $kategori ?>">
                <?php foreach ($daftar as $produk): ?>
                    <div class="produk-card">
                        <img src="gambar/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama']) ?>">
                        <p><?= htmlspecialchars($produk['nama']) ?></p>
                        <div class="bawah">
                            <p>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

                            <?php if ($kategori === 'mie'): ?>
                                <a href="detail.php?id=<?= $produk['id'] ?>">
                                    <button>Tambah</button>
                                </a>
                            <?php else: ?>
                                <button onclick="tambahKeKeranjang(
                                    '<?= htmlspecialchars($produk['nama'], ENT_QUOTES) ?>',
                                    <?= $produk['harga'] ?>,
                                    '<?= htmlspecialchars($produk['gambar'], ENT_QUOTES) ?>'
                                )">Tambah</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<script>
function searchProduct() {
    const keyword = document.getElementById("searchInput").value.toLowerCase();
    const kategoriList = ["mie", "camilan", "minuman"];

    kategoriList.forEach(kategori => {
        const container = document.querySelector(`.${kategori}`);
        const title = container?.previousElementSibling;
        let matchFound = false;

        if (container) {
            const cards = container.querySelectorAll(".produk-card");

            cards.forEach(card => {
                const name = card.querySelector("p").textContent.toLowerCase();
                const match = name.includes(keyword);
                card.style.display = match ? "block" : "none";
                if (match) matchFound = true;
            });

            container.style.display = matchFound ? "flex" : "none";
            if (title && title.tagName === "DIV") {
                title.style.display = matchFound ? "block" : "none";
            }

            if (keyword === "") {
                kategoriList.forEach(k => {
                    document.querySelector(`.${k}`).style.display = "flex";
                    const titleEl = document.querySelector(`.${k}`).previousElementSibling;
                    if (titleEl) titleEl.style.display = "block";
                });
            }
        }
    });

    return false;
}

function updateCartCount() {
    fetch('cek_keranjang.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('cart-count').textContent = data.jumlah;
    });
}

function tambahKeKeranjang(nama, harga, gambar) {
    const jumlah = 1;
    const total = harga * jumlah;

    const data = new URLSearchParams();
    data.append('nama', nama);
    data.append('harga', harga);
    data.append('jumlah', jumlah);
    data.append('total', total);
    data.append('gambar', gambar);

    fetch('tambah_keranjang.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: data.toString()
    })
    .then(res => res.text())
    .then(response => {
        alert("Berhasil ditambahkan ke keranjang");
        updateCartCount();
    });
}
</script>

</body>
</html>
