<?php
include 'koneksi.php';

$query = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Transaksi</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f2f2f2;
      padding: 20px;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #003366;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #004080;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .button-group {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .button-group a {
      padding: 10px 20px;
      background-color: #004080;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      margin-top: 10px;
    }

    .button-group a:hover {
      background-color: #002f66;
    }
  </style>
</head>
<body>

  <h2>Riwayat Transaksi</h2>

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

  <div class="button-group">
    <a href="menuutama.php">Kembali ke Menu Utama</a>
    <a href="riwayattransaksi_cetak.php" target="_blank">Cetak Riwayat</a>
  </div>

</body>
</html>
