<?php
$koneksi = new mysqli("localhost", "root", "", "saung_bahagia");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

$result = $koneksi->query("SELECT * FROM keranjang");

echo "<h2>Keranjang Anda</h2>";

if ($result->num_rows > 0) {
  echo "<ul>";
  while ($row = $result->fetch_assoc()) {
    echo "<li>";
    echo "<strong>" . $row['nama'] . "</strong><br>";
    echo "Jumlah: " . $row['jumlah'] . "<br>";
    echo "Level: " . $row['level'] . "<br>";
    echo "Catatan: " . $row['catatan'] . "<br>";
    echo "Total Harga: Rp " . number_format($row['total'], 0, ',', '.') . "<br>";
    echo "<img src='" . $row['gambar'] . "' width='100'><br>";
    echo "</li><hr>";
  }
  echo "</ul>";
} else {
  echo "<p>Keranjang kosong.</p>";
}

$koneksi->close();
?>
