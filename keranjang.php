<?php
session_start();  // Memulai sesi

// Jika keranjang ada di sesi
if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
    echo "<h2>Keranjang Anda</h2>";
    echo "<ul>";

    foreach ($_SESSION['keranjang'] as $item) {
        echo "<li>";
        echo "Nama: " . $item['nama'] . "<br>";
        echo "Jumlah: " . $item['jumlah'] . "<br>";
        echo "Level: " . $item['level'] . "<br>";
        echo "Catatan: " . $item['catatan'] . "<br>";
        echo "Harga: Rp " . number_format($item['harga'], 0, ',', '.') . "<br>";
        echo "</li>";
    }

    echo "</ul>";
    echo "<p>Total: Rp " . number_format(array_sum(array_column($_SESSION['keranjang'], 'harga')), 0, ',', '.') . "</p>";
} else {
    echo "<p>Keranjang Anda kosong.</p>";
}
?>
