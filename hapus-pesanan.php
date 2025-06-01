<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);
$ids = $data['ids'];

if (!empty($ids)) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    $stmt = $koneksi->prepare("DELETE FROM pesanan WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
}
?>