<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['items'])) {
    foreach ($data['items'] as $item) {
        $idProduk = $item['id_produk'];
        $jumlah = $item['jumlah'];

        // Kurangi stok
        $stmt = $koneksi->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");
        $stmt->bind_param("ii", $jumlah, $idProduk);
        $stmt->execute();
    }
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "no_items"]);
}
?>