<?php
include 'koneksi.php';
$hasil = $koneksi->query("SELECT * FROM laporan ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .nav{
    width: 1276px;
    height: 60px;
    background-color: #f7943e;
    margin-left: 30px;
    margin-bottom: 5px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin-left: -50px;
}

.nav a{
    align-items: center;
    color: white;
    margin-top: 8px;
    margin-right: 30px;
    font-size: 25px;
    text-decoration: none;
    font-family: 'Times New Roman', Times, serif;
}

.isinav{
    margin-top: 8px;
}

.gambar img {
    width: 65px;
    height: 65px;
    margin-left: -550px; 
}

.hapus button {
    background-color: #ff0d5e;
    color: white;
    border: none;
    padding: 5px 15px;
    border-radius: 6px;
    cursor: pointer;
    margin-left: 1000px;
    margin-bottom: 20px;
    margin-top: -20px;
}

.hapus button:hover{
    background-color: #ff0d5e;
}
 .grafik {
      position: absolute;
      font-size: 18px;
      right: 20px;
      padding-top: 13px;
    }
</style>
<body>
    <div class="container">

        <!-- navbar -->
      <div class="nav">
    <div class="gambar"><img src="saung-removebg-preview.png" /></div>
    <div class="isinav">
      <a href="index.php">Stok</a>
      <a href="bayar.php">Bayar</a>
      <a href="laporan.php">Laporan</a>
    </div>
    <div class="grafik">
      <a href="laporan-diagram.php"> Grafik Penjualan</a> 
    </div>
  </div>

        <div class="card-header">
            <center><h1 style="font-size: 30px; margin-top: 27px;" >LAPORAN PENJUALAN</h1></center>
        </div>
        <div class="row">
        <div class="card mt-4 ">
          <div class="card-body">
              <table class="table table-bordered" id="tabelHarian">
            <thead class="table table-success">
                <th>Id</th>
                <th>No Meja</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Tanggal</th>
            </thead>
            <!-- HTML bagian tabel -->
<tbody>
<?php 
$no = 1;
while ($row = $hasil->fetch_assoc()): 
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row['no_meja']) ?></td>
    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
    <td><?= $row['jumlah'] ?></td>
    <td><?= number_format($row['subtotal'], 0, ',', '.') ?></td>
    <td><?= $row['tanggal'] ?></td>
</tr>
<?php endwhile;?>
</tbody>
              </table>
          </div>
           <div class="hapus">
        <button onclick="hapusLaporan()">Hapus</button>
        <script>
            function hapusLaporan() {
                if(confirm("Yakin ingin menghapus semua laporan?")) {
                    window.location.href = "hapus-laporan.php";
                }
            }
            </script>
        </div>
        </div>
        </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>