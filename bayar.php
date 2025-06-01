<?php
session_start();
include 'koneksi.php';

// Ambil semua pesanan GROUP BY meja
$sql = "SELECT meja FROM pesanan GROUP BY meja ORDER BY meja";
$result = $koneksi->query($sql);

$pesananPerMeja = [];

while ($row = $result->fetch_assoc()) {
    $meja = $row['meja'];

    // Ambil semua pesanan untuk meja ini
    $sqlDetail = "SELECT * FROM pesanan WHERE meja = ? ORDER BY id ASC";
    $stmt = $koneksi->prepare($sqlDetail);
    $stmt->bind_param("s", $meja);
    $stmt->execute();
    $detailResult = $stmt->get_result();

    $pesananPerMeja[$meja] = [];

    while ($detail = $detailResult->fetch_assoc()) {
        $pesananPerMeja[$meja][] = $detail;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Pembayaran</title>
  <style>
    .nav{
        width: 1270px;
        height: 60px;
        background-color: rgb(118, 234, 217);
        margin-left: 30px;
        margin-bottom: 5px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        margin-left: 65px;
        margin-top: -8px;
        }
        .nav a{
            align-items: center;
            color: black;
            margin-top: 8px;
            margin-right: 30px;
            font-size: 30px;
            text-decoration: none;
            font-family: 'Times New Roman', Times, serif;
        }
        .isinav{
            margin-top: 15px;
        }
        .gambar img {
            width: 65px;
            height: 65px;
            margin-left: -550px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            padding: 20px;
            width: 1276px;
            flex-direction: row;
        }
        .pesanan1 {
            width: 350px;
            border: 1px solid black;
            padding: 15px;
            box-sizing: border-box;
        }
        .pesanan1 h2 {
            text-align: center;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .isi1 {
            margin-bottom: 15px;
        }
        .detail {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .catatan {
            font-size: 12px;
            color: gray;
            margin-top: -5px;
        }
        .harga {
            margin-left: 10px;
        }
        .jumlah {
            margin-top: -10px;
            font-size: 15px;
        }
        .bawah {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid black;
            padding-top: 10px;
        }
        .bawah button {
            background-color: #0d92ff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
        .bawah button:hover {
            background-color: #0071cc;
        }
        .takeaway {
          position: absolute;
          font-size: 18px;
          right: 20px;
          padding-top: 13px;
        }
  </style>
</head>
<body>
  <div class="nav">
    <div class="gambar"><img src="saung.png" /></div>
    <div class="isinav">
      <a href="index.php">Stok</a>
      <a href="bayar.php">Bayar</a>
      <a href="laporan.php">Laporan</a>
    </div>
    <div class="takeaway">
      <a href="form.php">Take Away</a> 
    </div>
  </div>

  <center><h1>DAFTAR PESANAN</h1></center>

  <div class="container">
    <?php foreach ($pesananPerMeja as $meja => $items): ?>
    <div class="pesanan1">
      <div class="meja"><h2>Meja <?= htmlspecialchars($meja) ?></h2></div>
      <div class="isi1">
        <?php 
        $subtotal = 0;
        foreach ($items as $item): 
          $subtotal += $item['total'];
        ?>
        <div class="detail" data-id="<?= $item['id'] ?>">
          <div>
            <p class="produk"><?= htmlspecialchars($item['nama']) ?><?= $item['level'] ? ' lv.'.$item['level'] : '' ?></p>
            <p class="jumlah"><?= $item['jumlah'] ?>x <span class="hargasatuan"><?= number_format($item['harga'], 0, ',', '.') ?></span></p>
            <?php if (!empty($item['catatan'])): ?>
              <p class="catatan">Catatan: <?= htmlspecialchars($item['catatan']) ?></p>
            <?php endif; ?>
          </div>
          <p><span class="harga">= <?= number_format($item['total'], 0, ',', '.') ?></span></p>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="bawah">
        <p><strong>Subtotal: Rp <span class="subtotal"><?= number_format($subtotal, 0, ',', '.') ?></span></strong></p>
        <button class="bayar-btn">Bayar</button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const tombolBayarSemua = document.querySelectorAll(".bayar-btn");

    tombolBayarSemua.forEach(function(tombol) {
      tombol.addEventListener("click", async function () {
        const pesananCard = this.closest(".pesanan1");
        const meja = pesananCard.querySelector(".meja h2").textContent.replace("Meja ", "");
        const items = pesananCard.querySelectorAll(".detail");

        let laporanList = JSON.parse(localStorage.getItem('LaporanList')) || [];

        const idToDelete = [];

        items.forEach(item => {
          const id = item.dataset.id;
          const namaProduk = item.querySelector(".produk").textContent;
          const jumlah = item.querySelector(".jumlah").textContent.split("x")[0].trim();
          const subtotal = item.querySelector(".harga").textContent.replace("= ", "").replace(/\./g, "").trim();

          const laporan = {
            noMeja: meja,
            namaProduk: namaProduk,
            jmlh: jumlah,
            subtotal: parseInt(subtotal),
            tanggal: new Date().toLocaleString("id-ID")
          };

          laporanList.push(laporan);
          idToDelete.push(id);
        });

        localStorage.setItem('LaporanList', JSON.stringify(laporanList));

        // Hapus data dari database
        fetch('hapus-pesanan.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ ids: idToDelete })
        }).then(() => {
          pesananCard.remove();
        });
      });
    });
  });
  </script>
</body>
</html>