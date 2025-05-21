<?php
$conn = new mysqli('localhost', 'root', '', 'saung_bahagia');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

session_start();
$user_id = $_SESSION['user_id'] ?? 1;

// Jika ingin tetap menyimpan data keranjang setelah checkout, tidak perlu hapus keranjang, cukup beri status atau update transaksi.
$query = "UPDATE keranjang SET status = 'checkout', tgl_checkout = NOW() WHERE user_id = $user_id";
$conn->query($query);

// Redirect ke halaman menu setelah checkout
header("Location: menu.php");
exit;
?>
