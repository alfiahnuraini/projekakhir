<?php
include 'koneksi.php';
$koneksi->query("DELETE FROM laporan");
header("Location: laporan.php");
exit;
?>