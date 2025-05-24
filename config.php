<?php
$koneksi = new mysqli("localhost", "root", "", "saung_bahagia");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
