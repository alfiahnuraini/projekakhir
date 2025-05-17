<?php
$koneksi = new mysqli("localhost", "root", "", "saung_bahagia");

$id = $_GET['id'];
$result = $koneksi->query("SELECT * FROM menu WHERE id = $id");
$produk = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Menu</title>
  <style>
    /* Gaya kamu sebelumnya, bisa disalin di sini */
  </style>
</head>
<body>
  <div class="menu-container">
    <img src="gambar/<?= $produk['gambar'] ?>" alt="<?= $produk['nama'] ?>">
    <h2><?= $produk['nama'] ?></h2>
    <p>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

    <h3>Pilih Level</h3>
    <div class="levelclass">
      <?php for ($i = 1; $i <= 8; $i++): ?>
        <label><input type="checkbox" name="level[]" value="<?= $i ?>"> Lv. <?= $i ?></label>
      <?php endfor; ?>
    </div>

    <h3>Catatan</h3>
    <textarea id="catatan" style="width:100%"></textarea>

    <h3>Jumlah</h3>
    <input type="number" id="jumlah" value="1" min="1" />

    <button onclick="tambahPesanan()">Tambah ke Keranjang</button>
  </div>

<script>
function tambahPesanan() {
  const idMenu = <?= $produk['id'] ?>;
  const jumlah = parseInt(document.getElementById('jumlah').value);
  const catatan = document.getElementById('catatan').value;
  const levels = Array.from(document.querySelectorAll('input[name="level[]"]:checked')).map(cb => cb.value);

  fetch('tambah_keranjang.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      id_menu: idMenu,
      jumlah: jumlah,
      level: levels.join(','),
      catatan: catatan
    })
  })
  .then(res => res.text())
  .then(data => {
    alert('Pesanan ditambahkan!');
    window.location.href = 'keranjang.php';
  });
}
</script>
</body>
</html>
