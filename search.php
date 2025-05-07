<?php
$koneksi = mysqli_connect("localhost", "root", "", "saung_bahagia");

$keyword = $_GET['q'];
$query = "SELECT * FROM produk WHERE nama LIKE '%$keyword%'";

$result = mysqli_query($koneksi, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
