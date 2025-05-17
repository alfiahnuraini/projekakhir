<?php
$koneksi = new mysqli("localhost", "root", "", "saung_bahagia");

$query = "SELECT * FROM menu";
$result = $koneksi->query($query);

$menu = [
    "mie" => [],
    "camilan" => [],
    "minuman" => []
];

while($row = $result->fetch_assoc()) {
    $menu[$row["kategori"]][] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="style11.css">
</head>
<body>
<div class="ctn">
        <div class="navbar">
            <div class="gambar"><img src="saung-removebg-preview.png" /></div>
            <div class="isinavbar">
                <a href="home.html">HOME</a>
                <a href="menu.html">MENU</a>
                <a href="pesanan.html">PESANAN</a>
            </div>
    </div>
    <div class="atas">
        <div class="toko">
            <p>SAUNG <br> BAHAGIA</p>
        </div>
        <form onsubmit="return searchProduct()">
            <input type="text" placeholder="Search..." class="search" id="searchInput">
            <button type="submit" class="search-btn">Search</button>
            <script>
            function searchProduct() {
                const keyword = document.getElementById("searchInput").value.toLowerCase();
                const products = document.querySelectorAll(".produk-card");

                let foundAny = false;

                // Filter produk berdasarkan keyword
                products.forEach(card => {
                    const name = card.querySelector("p").textContent.toLowerCase();
                    const match = name.includes(keyword);
                    card.style.display = match ? "block" : "none";
                    if (match) foundAny = true;
                });

                // Sembunyikan/tampilkan kategori kontainer
                const containers = document.querySelectorAll(".mie, .mie2, .camilan1, .camilan2, .camilan3, .camilan4, .minuman1, .minuman2, .minuman3, .minuman4");
                containers.forEach(container => {
                    const visibleProducts = container.querySelectorAll(".produk-card");
                    const hasVisible = Array.from(visibleProducts).some(card => card.style.display !== "none");
                    container.style.display = hasVisible ? "flex" : "none";
                });

                // Sembunyikan/tampilkan judul kategori
                const mieVisible = Array.from(document.querySelectorAll(".mie, .mie2")).some(c => c.style.display !== "none");
                document.querySelector(".h1").style.display = mieVisible ? "block" : "none";

                const camilanVisible = Array.from(document.querySelectorAll(".camilan1, .camilan2, .camilan3, .camilan4")).some(c => c.style.display !== "none");
                document.querySelector(".h2").style.display = camilanVisible ? "block" : "none";

                const minumanVisible = Array.from(document.querySelectorAll(".minuman1, .minuman2, .minuman3, .minuman4")).some(c => c.style.display !== "none");
                document.querySelector(".h3").style.display = minumanVisible ? "block" : "none";

                // Tampilkan/ sembunyikan pesan "Produk tidak ditemukan"
                document.getElementById("not-found").style.display = foundAny ? "none" : "block";

                return false; // Mencegah reload halaman
            }
</script>   
    </form>
    <div class="keranjang">
        <a href="keranjang.php">
            <img src="keranjang-removebg-preview.png" alt="Keranjang">
            <span class="nomor" id="cart-count">0</span>
        </a>
        <script>
            window.onload = function() {
              fetch('get_keranjang.php')
                .then(res => res.json())
                .then(data => {
                  document.getElementById("keranjang-jumlah").innerText = data.total;
                })
                .catch(err => {
                  console.error('Gagal ambil data keranjang:', err);
                });
            };
            </script>
        </div>
        </div>
    

        <!-- Judul kategori -->
        <?php foreach ($menu as $kategori => $daftar): ?>
            <?php if (count($daftar) > 0): ?>
                <div class="h1"><h1><?= strtoupper($kategori) ?></h1></div>
                <div class="<?= $kategori ?>">
                    <?php foreach ($daftar as $produk): ?>
                        <div class="produk-card">
                            <img src="gambar/<?= htmlspecialchars($produk['gambar']) ?>">
                            <p><?= htmlspecialchars($produk['nama']) ?></p>
                            <div class="bawah">
                                <p>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                                <button onclick="tambahKeKeranjang('<?= $produk['id'] ?>')">Tambah</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <script>
        function tambahKeKeranjang(idProduk) {
            fetch('tambah_keranjang.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + idProduk
            })
            .then(res => res.text())
            .then(data => {
                alert("Produk ditambahkan ke keranjang!");
            });
        }
    </script>
</body>
</html>
