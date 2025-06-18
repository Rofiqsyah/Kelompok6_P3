<?php
include 'koneksi.php';

$query = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak Riwayat Transaksi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: white;
      color: #000;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #000;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    @media print {
      .no-print {
        display: none;
      }
    }

    .no-print {
      margin-bottom: 20px;
    }

    .back-btn {
      display: inline-block;
      padding: 8px 16px;
      background-color: #004080;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body onload="window.print()">

  <div class="no-print">
    <a href="riwayattransaksi.php" class="back-btn">Kembali ke Riwayat</a>
  </div>

  <h2>Laporan Riwayat Transaksi</h2>

  <table>
    <thead>
      <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Pembeli</th>
        <th>Alamat</th>
        <th>Ekspedisi</th>
        <th>Metode</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><?= htmlspecialchars($row['namaBarang']) ?></td>
        <td>Rp <?= number_format($row['hargaBarang'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['namaPembeli']) ?></td>
        <td><?= htmlspecialchars($row['alamatPembeli']) ?></td>
        <td><?= htmlspecialchars($row['ekspedisi']) ?></td>
        <td><?= htmlspecialchars($row['metodePembayaran']) ?></td>
        <td><?= htmlspecialchars($row['tanggal']) ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>
</html>
