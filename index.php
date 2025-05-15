<?php
$koneksi = new mysqli("localhost", "root", "", "nama_database_kamu");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

include 'koneksi.php';

$nama = $_POST['namaProduk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$kategori = $_POST['kategori'];

$gambarPath = '';
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $gambarName = time() . '_' . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambarName);
    $gambarPath = 'uploads/' . $gambarName;
}

$stmt = $koneksi->prepare("INSERT INTO menu (namaProduk, harga, stok, kategori, gambar) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $nama, $harga, $stok, $kategori, $gambarPath);
$stmt->execute();
$stmt->close();

echo json_encode(["status" => "sukses"]);

include 'koneksi.php';

$result = $koneksi->query("SELECT * FROM menu ORDER BY id DESC");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>

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
                  <div class="mb-2">
                      <label class="form-label">Nama Produk</label>
                      <input type="text" class="form-control" id="txtnamaProduk"/>
                  </div>
      
                    <div class="mb-2">
                      <label class="form-label">Harga</label>
                      <input type="text" class="form-control" id="txtharga"/>
                    </div>
      
                    <div class="mb-2">
                      <label class="form-label">Stok</label>
                      <input type="number" class="form-control" id="txtstok"/>
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Kategori</label>
                      <select class="form-select" aria-label="Default select example" id="txtkategori">
                        <option selected></option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Camilan">Camilan</option>
                      </select>
                    </div>

                    <div class="mb-2">
                      <label class="form-label">Gambar</label>
                      <input type="file" class="form-control" id="txtgambar" accept="image/*">
                    </div>
  
                      <div class="mt-3">
                        <button class="btn btn-primary " onclick="tambahProduk()">Selesai</button>
                        <button class="btn btn-secondary" onclick="cancel()">Cancel</button>
                      </div>
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
              </table>
            </div>
  
          </div>
        </div>
    </div>
  
  </div>
  <script>
  const listProduk = JSON.parse(localStorage.getItem('produkList')) || [];

let mode= 'tambah'

function tampilkanProduk() {
  fetch('tampilkanProduk.php')
    .then(response => response.json())
    .then(data => {
      const tabelProduk = document.getElementById('tabelProduk');
      tabelProduk.innerHTML = `
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Kategori</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      `;

      data.forEach((produk, index) => {
        tabelProduk.innerHTML += `
          <tr>
            <td>${index + 1}</td>
            <td>${produk.namaProduk}</td>
            <td>${produk.harga}</td>
            <td>${produk.stok}</td>
            <td>${produk.kategori}</td>
            <td><img src="${produk.gambar}" width="60" height="60" /></td>
            <td>
              <!-- tombol edit & hapus bisa kamu lanjutkan -->
              <button class="btn btn-danger" onclick="hapusProduk(${produk.id})">Hapus</button>
            </td>
          </tr>
        `;
      });
    });
}

function tambahProduk() {
  const namaProduk = document.getElementById('txtnamaProduk').value;
  const harga = document.getElementById('txtharga').value;
  const stok = document.getElementById('txtstok').value;
  const kategori = document.getElementById('txtkategori').value;
  const gambarFile = document.getElementById('txtgambar').files[0];

  const formData = new FormData();
  formData.append('namaProduk', namaProduk);
  formData.append('harga', harga);
  formData.append('stok', stok);
  formData.append('kategori', kategori);
  if (gambarFile) {
    formData.append('gambar', gambarFile);
  }

  fetch('tambah_produk.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'sukses') {
      alert('Produk berhasil ditambahkan!');
      tampilkanProduk(); // ini nanti akan kita ubah juga agar ambil dari database
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
   

const cariProduk = (namaProduk) => {
    // tampilkan stok jika nama produk == nama
    for (let i = 0; i < listProduk.length; i++){
        if (listProduk[i].namaProduk == namaProduk) 
            return i
    }
    return -1
}

// const hapusProduk = (target) => {
//     const produkDiHapus = cariProduk(target)
//     // menghapus elemen dari dalam array
//     if (produkDiHapus !== -1) {
//     listProduk.splice(produkDiHapus, 1)
//     tampilkanProduk()
//     }

//     localStorage.setItem('produkList',JSON.stringify(listProduk));
//     hapusProduk()
// }

// const editProduk = (target) => {
//     const produkEdit = cariProduk(target);
//     const produkDiedit = listProduk[produkEdit];

//     const namaProduk = document.getElementById('txtnamaProduk').value = target
//     const harga = document.getElementById('txtharga').value = produkDiedit.harga
//     const stok = document.getElementById('txtstok').value = produkDiedit.stok
//     const kategori = document.getElementById('txtkategori').value = produkDiedit.kategori
//     const gambar = document.getElementById('txtgambar').value = produkDiedit.gambar


//     mode = produkEdit

//     console.log(target)
//     console.log(produkEdit)
//     console.log(listProduk[produkEdit])
// }

// const cancel = () => {
//     const namaProduk = document.getElementById('txtnamaProduk').value =""
//     const harga = document.getElementById('txtharga').value =""
//     const stok = document.getElementById('txtstok').value =""
//     const kategori = document.getElementById('txtkategori').value =""
//     const gambar = document.getElementById('txtgambar').value =""

//     mode = 'tambah'
// }
  </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>