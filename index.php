<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memperbaharui Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .nav{
    width: 1276px;
    height: 60px;
    background-color: rgb(118, 234, 217);
    margin-bottom: 5px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin-left: 30px;
    margin-right: 100%;
    margin-left: 70px;

}

.nav a{
    align-items: center;
    color: black;
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
</style>
<body>
  <div class="container1">
    <!-- navbar -->

    <div class="nav">
      <div class="gambar"><img src="saung.png" /></div>
      <div class="isinav">
      <a href="index.html" style="font-size: 30px;">Stok</a>
      <a href="bayar.html" style="font-size: 30px;">Bayar</a>
      <a href="laporan.html" style="font-size: 30px;">Laporan</a>
      </div>
    </div>

    <!-- isi -->
    <div class="container mt-3">
        <div class="row">
          <div class="col-3">
            <div class="card border-secondary  mb-4">
              <div class="card-header text-bg-info">
                INPUT STOK PRODUK
              </div>
              <div class="card-body">
                <form id="formProduk" action="stok.php" method="POST" enctype="multipart/form-data">
                  <div class="mb-2">
                      <label class="form-label">Nama Produk</label>
                      <input type="text" class="form-control" id="txtnamaProduk" name="namaProduk"/>
                  </div>
      
                    <div class="mb-2">
                      <label class="form-label">Harga</label>
                      <input type="text" class="form-control" id="txtharga" name="harga"/>
                    </div>
      
                    <div class="mb-2">
                      <label class="form-label">Stok</label>
                      <input type="number" class="form-control" id="txtstok" name="stok"/>
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Kategori</label>
                      <select class="form-select" aria-label="Default select example" name="kategori" id="txtkategori">
                        <option selected></option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Camilan">Camilan</option>
                      </select>
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Gambar</label>
                      <input type="file" class="form-control" id="txtgambar" name="gambar" accept="image/*">
                    </div>
  
                      <div class="mt-3">
                        <button type="submit" class="btn btn-primary ">Selesai</button>
                        <button class="btn btn-secondary" onclick="cancel()">Cancel</button>
                      </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-9">
            <div class="card  border-secondary  mb-3">
              <table class="table table-bordered" id="tabelProduk">
  <div class="card-header text-bg-info">TABEL STOK PRODUK</div>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Kategori</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>
</thead>

<tbody>
<?php
include 'koneksi.php';
$no = 1;
$sql = "SELECT * FROM menu";
$result = $koneksi->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>$no</td>
            <td>{$row['nama_produk']}</td>
            <td>{$row['harga']}</td>
            <td>{$row['stok']}</td>
            <td>{$row['kategori']}</td>
            <td><img src='gambar/{$row['gambar']}' width='50'></td>
            <td><a href='stok.php?id={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a></td>
        </tr>";
    $no++;
}
?>
</tbody>
</table>
            </div>
  
          </div>
        </div>
    </div>
  
  </div>
</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>