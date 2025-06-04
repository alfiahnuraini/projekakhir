<?php
session_start();
include 'koneksi.php';

$sql = "SELECT meja FROM pesanan GROUP BY meja ORDER BY meja";
$result = $koneksi->query($sql);

$pesananPerMeja = [];

while ($row = $result->fetch_assoc()) {
    $meja = $row['meja'];
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
    /* style di sini tetap sama seperti yang kamu punya sebelumnya */
    .nav {
      width: 1270px;
      height: 60px;
      background-color: #f7943e;
      margin-left: 65px;
      margin-bottom: 5px;
      display: flex;
      flex-direction: row;
      justify-content: center;
      margin-top: -8px;
    }
    .nav a {
      align-items: center;
      color: white;
      margin-top: 8px;
      margin-right: 30px;
      font-size: 30px;
      text-decoration: none;
      font-family: 'Times New Roman', Times, serif;
    }
    .isinav {
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
    <div class="gambar"><img src="saung-removebg-preview.png" /></div>
    <div class="isinav">
      <a href="index.php">Stok</a>
      <a href="bayar.php">Bayar</a>
      <a href="laporan.php">Laporan</a>
    </div>
    <div class="takeaway">
      <a href="form.html">Take Away</a> 
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

    <!-- Bagian pesanan takeaway (dari localStorage) -->
    <div style="width: 100%;">
      <h2>Daftar Pesanan Takeaway</h2>
      <p>Nama Pemesan: <strong id="nama-pemesan">-</strong></p>


      <h3>Total Keseluruhan: Rp <span id="total-keseluruhan">0</span></h3>
    </div>
  </div>

  <table border="1" id="tabelPesanan">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Level</th>
      <th>Jumlah</th>
      <th>Harga</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody id="bodyPesanan"></tbody>
</table>

<script>
  // Ambil data dari localStorage
  const pesanan = JSON.parse(localStorage.getItem('daftarPesanan')) || [];

  function tampilkanPesanan() {
    const tbody = document.getElementById('bodyPesanan');
    tbody.innerHTML = ''; // Kosongkan isi sebelumnya

    pesanan.forEach((item, index) => {
      const row = document.createElement('tr');

      const totalHarga = item.harga * item.jumlah;

      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${item.nama}</td>
        <td>${item.level || '-'}</td>
        <td>${item.jumlah}</td>
        <td>Rp ${item.harga.toLocaleString()}</td>
        <td>Rp ${totalHarga.toLocaleString()}</td>
      `;

      tbody.appendChild(row);
    });
  }

  // Jalankan fungsi saat halaman dimuat
  document.addEventListener('DOMContentLoaded', tampilkanPesanan);
</script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const tombolBayarSemua = document.querySelectorAll(".bayar-btn");

      tombolBayarSemua.forEach(function(tombol) {
        tombol.addEventListener("click", async function () {
          tombol.disabled = true;

          const pesananCard = this.closest(".pesanan1");
          const meja = pesananCard.querySelector(".meja h2").textContent.replace("Meja ", "");
          const items = pesananCard.querySelectorAll(".detail");

          const dataLaporan = [];
          const idToDelete = [];

          items.forEach(item => {
            const id = item.dataset.id;
            const namaProdukFull = item.querySelector(".produk").textContent;
            const namaProduk = namaProdukFull.split(" lv.")[0].trim();
            const jumlah = parseInt(item.querySelector(".jumlah").textContent.split("x")[0].trim());
            const hargaSatuan = parseInt(item.querySelector(".hargasatuan").textContent.replace(/\./g, "").trim());
            const subtotal = parseInt(item.querySelector(".harga").textContent.replace("= ", "").replace(/\./g, "").trim());
            const catatanEl = item.querySelector(".catatan");
            const level = namaProdukFull.includes("lv.") ? namaProdukFull.split("lv.")[1].trim() : "";
            const catatan = catatanEl ? catatanEl.textContent.replace("Catatan: ", "").trim() : "";

            dataLaporan.push({
              no_meja: meja,
              nama_produk: namaProduk,
              jumlah: jumlah,
              harga: hargaSatuan,
              subtotal: subtotal,
              level: level,
              catatan: catatan
            });

            idToDelete.push(id);
          });

          // kirim ke co.php
          fetch('co.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ laporan: dataLaporan })
          }).then(res => res.json())
            .then(res => {
              if (res.status === 'success') {
                fetch('hapus-pesanan.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ ids: idToDelete })
                }).then(() => {
                  pesananCard.remove();
                });
              } else {
                alert("Gagal menyimpan ke laporan!");
                tombol.disabled = false;
              }
            });
        });
      });
    });
  </script>
<script>
  // Ambil data pesanan dari sessionStorage
  const pesanan = JSON.parse(sessionStorage.getItem("pesanan")) || [];

  // Cek jika ada pesanan
  if (pesanan.length > 0) {
    const container = document.getElementById("pesanan-container");

    // Loop untuk menampilkan setiap pesanan
    pesanan.forEach(pesananItem => {
      const card = document.createElement("div");
      card.className = "pesanan-card";
      card.innerHTML = `
        <h3>${pesananItem.nama}</h3>
        <p>Jumlah: ${pesananItem.jumlah}</p>
        <p>Level Pedas: ${pesananItem.level}</p>
        <p>Harga: Rp${pesananItem.harga}</p>
      `;
      container.appendChild(card);
    });
  } else {
    document.getElementById("pesanan-container").innerHTML = "<p>Belum ada pesanan.</p>";
}
</script>
</body>
</html>