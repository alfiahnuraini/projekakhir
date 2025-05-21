<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
</head>
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

</style>
<body>
    <div class="container1">
        <!-- navbar -->
      <div class="nav">
        <div class="gambar"><img src="saung.png" /></div>
        <div class="isinav">
        <a href="index.php">Stok</a>
        <a href="bayar.php">Bayar</a>
        <a href="laporan.php">Laporan</a>
        </div>
      </div>
        <center><h1>DAFTAR PESANAN</h1></center>

        <div class="container">
            <!-- Pesanan 1 -->
            <div class="pesanan1">
              <div class="meja" id="noMeja"><h2>Meja 11</h2></div>
              <div class="isi1">
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Mie Angel lv.1</p>
                    <p class="jumlah" id="jumlah">2x <span class="harga-satuan" id="hargaSatuan">10.000</span></p>
                    <p class="catatan" id="cttn">Catatan: tanpa bawang daun</p>
                  </div>
                  <p><span class="harga" id="hrg">= 20.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Mie Angel lv.2</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">10.000</span></p>
                  </div>
                  <p><span class="harga" id="hrg">= 10.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Udang Keju</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 8.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Udang Rambutan</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 8.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Cireng</p>
                    <p class="jumlah" id="jumlah">3x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 24.000</span></p>
                </div>
              </div>
              <div class="bawah">
                <p><strong>Subtotal: Rp <span class="subtotal" id="subtotal">0</span></strong></p>
                <button>Bayar</button>
              </div>
            </div>

            <!-- Pesanan 2 -->
             <div class="pesanan1">
              <div class="meja" id="noMeja"><h2>Meja 8</h2></div>
              <div class="isi1">
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Mie Angel lv.1</p>
                    <p class="jumlah" id="jumlah">1x <span class="hargasatuan" id="hargaSatuan">10.000</span></p>
                    <p class="catatan" id="cttn">Catatan: tanpa bawang daun</p>
                  </div>
                  <p><span class="harga" id="hrg">= 10.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Mie Angel lv.2</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">10.000</span></p>
                  </div>
                  <p><span class="harga" id="hrg">= 10.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Udang Keju</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 8.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Cireng</p>
                    <p class="jumlah" id="jumlah">3x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 24.000</span></p>
                </div>
              </div>
              <div class="bawah">
                <p><strong>Subtotal: Rp <span class="subtotal" id="subtotal">0</span></strong></p>
                <button>Bayar</button>
              </div>
            </div>

                 <!-- Pesanan 3 -->
            <div class="pesanan1">
              <div class="meja" id="noMeja"><h2>Meja 12</h2></div>
              <div class="isi1">
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Mie Angel lv.1</p>
                    <p class="jumlah" id="jumlah">2x <span class="harga-satuan" id="hargaSatuan">10.000</span></p>
                    <p class="catatan" id="cttn">Catatan: tanpa bawang daun</p>
                  </div>
                  <p><span class="harga" id="hrg">= 20.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Mie Angel lv.2</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">10.000</span></p>
                  </div>
                  <p><span class="harga" id="hrg">= 10.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Udang Keju</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 8.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Udang Rambutan</p>
                    <p class="jumlah" id="jumlah">1x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 8.000</span></p>
                </div>
                <div class="detail">
                  <div>
                    <p class="produk" id="namaProduk">Cireng</p>
                    <p class="jumlah" id="jumlah">3x <span class="harga-satuan" id="hargaSatuan">8.000</span></p>
                  </div>
                   <p><span class="harga" id="hrg">= 24.000</span></p>
                </div>
              </div>
              <div class="bawah">
                <p><strong>Subtotal: Rp <span class="subtotal" id="subtotal">0</span></strong></p>
                <button>Bayar</button>
              </div>
            </div> 
            

          </div>

    </div>
<script src="./script-bayar.js"></script>
</body>
</html>