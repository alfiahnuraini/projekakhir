<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['meja'] = $_POST['nomorMeja'];
    header('Location: menu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saung Bahagia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!--navbar-->
        <div class="navbar">
            <div class="gambar"><img src="saung-removebg-preview.png" /></div>
            <div class="isinavbar">
                <a href="home.php">HOME</a>
                <a href="menu.php">MENU</a>
                <a href="pesanan.php">PESANAN</a>
            </div>
        </div>

        <!--informasi-->
        <div class="informasi">
            <h1>Dari Mie Sampai Es Teh, semua bikin bahagia</h1>
            <p>Saung Bahagia adalah tempat makan yang menyajikan berbagai varian mie pedas dengan tingkat kepedasan yang bisa disesuaikan sesuai selera pelanggan.</p>
        </div>
 
<div class="form-meja">
  <label for="meja">Masukkan Nomor Meja:</label>
  <input type="number" name="meja" id="meja" required>
  <button onclick="mulaiPesan()">Mulai Pesan</button>
</div>

        <!--gambar produk-->
        <div class="gproduk">
            <img src="DIMSUM.jpg"/>
            <img src="mie.png"/>
            <img src="tehh.jpg"/>
        </div>

        <!--testimoni-->
        <div class="testimoni">
            <h1>TESTIMONI</h1>
            <div class="tesasli">
                <div class="tes1">
                    <img src="profil.jpg"/>
                    <p>anu</p>
                    <p>"Mienya enak banget! Pedasnya nampol!"</p>
                </div>
                <div class="tes1">
                    <img src="profil.jpg"/>
                    <p>anu</p>
                    <p>"Tempatnya nyaman, makanannya variatif."</p>
                </div>
                <div class="tes1">
                    <img src="profil.jpg"/>
                    <p>anu</p>
                    <p>"Pelayanan ramah, recommended banget!"</p>
                </div>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="kanan">
                <img src="saung-removebg-preview.png"/>
                <p><b>SAUNG BAHAGIA</b></p>
                <a href="menu.php"><button>Beli Sekarang</button></a>
            </div>
        </div>

        <!--Lokasi-->
        <div class="lokasi">
            <h1>Lokasi Kami</h1>
            <iframe src="https://www.google.com/maps/embed?pb=..." width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

</body>

 <script>
  function mulaiPesan() {
    const meja = document.getElementById("meja").value;
    if (meja) {
      // Redirect ke menu.php sambil kirim nomor meja via query string
      window.location.href = `menu.php?meja=${encodeURIComponent(meja)}`;
    } else {
      alert("Silakan masukkan nomor meja terlebih dahulu.");
    }
  }
</script>
</html>