

<?php
include 'koneksi.php';

$sql = "SELECT DATE(tanggal) as tanggal, SUM(subtotal) as total
        FROM laporan
        GROUP BY DATE(tanggal)
        ORDER BY tanggal ASC";

$result = $koneksi->query($sql);

$dataTanggal = [];
$dataTotal = [];

while ($row = $result->fetch_assoc()) {
    $dataTanggal[] = $row['tanggal'];
    $dataTotal[] = (int)$row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <h1 style="text-align: center;">Kelompok 4</h1>
  <h2 style="text-align: center;">Nama Anggota Kelompok
    1. Alfiah Nur Aini (4)
    2. Apsha Arfianah (9)
    3. Najwa Karima (28)
    4. Nurhayati (30)
  </h2>
    <title>Grafik Penjualan Harian</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2 style="text-align: center;">Grafik Penjualan per Hari</h2>
    <canvas id="penjualanChart" width="800" height="400"></canvas>

    <script>
        const ctx = document.getElementById('penjualanChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line', // Bisa juga "bar"
            data: {
                labels: <?= json_encode($dataTanggal) ?>,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: <?= json_encode($dataTotal) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.3)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString("id-ID");
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>