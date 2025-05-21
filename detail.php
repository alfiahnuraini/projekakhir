<?php
include 'config.php';

if (!isset($_GET['id'])) {
  die("ID produk tidak ditemukan.");
}

$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id = '$id'";
$result = $koneksi->query($query);

if ($result->num_rows == 0) {
  die("Produk tidak ditemukan.");
}

$produk = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($produk['nama']) ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .menu-container {
      max-width: 400px;
      margin: auto;
      border: 1px solid #000000;
      border-radius: 10px;
      padding: 20px;
    }
    img {
      width: 100%;
      border-radius: 10px;
    }
    .tombol {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }
    .tombol button {
      width: 30px;
      height: 30px;
    }
    .tombol input {
      width: 40px;
      text-align: center;
      border: none;
      font-size: 16px;
    }
    .btn-pesan {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      background-color: #00aaff;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .levelclass {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }
    .level {
      width: 48%;
    }
    .level label {
      display: block;
      margin: 5px 0;
    }
  </style>
</head>
<body>

<div class="menu-container">
  <img src="gambar/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama']) ?>" id="gambar-mie">
  <h2 id="nama-mie"><?= htmlspecialchars($produk['nama']) ?></h2>
  <p id="harga-satuan">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

  <h3>Pilih Level</h3>
  <div class="levelclass">
    <div class="level">
      <?php for ($i = 1; $i <= 4; $i++): ?>
        <label><input type="checkbox" value="<?= $i ?>"> Lv. <?= $i ?></label>
      <?php endfor; ?>
    </div>
    <div class="level">
      <?php for ($i = 5; $i <= 8; $i++): ?>
        <label><input type="checkbox" value="<?= $i ?>"> Lv. <?= $i ?></label>
      <?php endfor; ?>
    </div>
  </div>

  <h3>Catatan (opsional)</h3>
  <textarea rows="3" style="width: 100%;" id="catatan"></textarea>

  <h3>Jumlah Pesanan</h3>
  <div class="tombol">
    <button onclick="kurang()">-</button>
    <input type="text" id="jumlah" value="1" readonly>
    <button onclick="tambah()">+</button>
  </div>

  <button class="btn-pesan" id="btn-pesan" onclick="tambahPesanan()">Tambah Pesanan - Rp <?= number_format($produk['harga'], 0, ',', '.') ?></button>
</div>

<script>
  let hargaSatuan = <?= $produk['harga'] ?>;
  let jumlah = 1;

  function updateHarga() {
    let total = hargaSatuan * jumlah;
    document.getElementById("btn-pesan").innerText = `Tambah Pesanan - Rp ${total.toLocaleString('id-ID')}`;
  }

  function tambah() {
    jumlah++;
    document.getElementById("jumlah").value = jumlah;
    updateHarga();
  }

  function kurang() {
    if (jumlah > 1) {
      jumlah--;
      document.getElementById("jumlah").value = jumlah;
      updateHarga();
    }
  }

  function tambahPesanan() {
    const namaMie = document.getElementById("nama-mie").innerText;
    const gambarMie = document.getElementById("gambar-mie").src;
    const levelCheckboxes = document.querySelectorAll('.levelclass input[type="checkbox"]');
    const selectedLevels = Array.from(levelCheckboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    if (selectedLevels.length === 0) {
      alert("Pilih minimal 1 level pedas!");
      return;
    }

    const catatan = document.getElementById("catatan").value;
    const totalHarga = hargaSatuan * jumlah;

    const pesanan = {
      nama: namaMie,
      gambar: gambarMie,
      level: selectedLevels,
      catatan: catatan,
      jumlah: jumlah,
      hargaSatuan: hargaSatuan,
      totalHarga: totalHarga
    };

    console.log("Mengirim data:", pesanan);

    fetch("tambah_keranjang.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(pesanan)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Pesanan berhasil ditambahkan!");
        window.location.href = "keranjang.php";
      } else {
        alert("Gagal menambahkan pesanan: " + data.message);
      }
    })
    .catch(error => {
      console.error("Fetch error:", error);
      alert("Terjadi kesalahan saat mengirim pesanan.");
    });
  }
</script>
</body>
</html>
