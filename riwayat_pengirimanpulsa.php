<?php
include 'koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM pengirimanpulsa ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pengiriman Pulsa</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f2f2;
      padding: 30px;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #004080;
      color: white;
    }

    tr:hover {
      background-color: #f9f9f9;
    }

    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #004080;
      color: white;
      text-decoration: none;
      border-radius: 6px;
    }

    .btn:hover {
      background-color: #002f66;
    }
  </style>
</head>
<body>

  <h2>Riwayat Pengiriman Pulsa</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nomor HP</th>
        <th>Provider</th>
        <th>Nominal</th>
        <th>Metode</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($data)) : ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['nomor_hp']) ?></td>
          <td><?= htmlspecialchars($row['provider']) ?></td>
          <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
          <td><?= htmlspecialchars($row['metode']) ?></td>
          <td><?= $row['tanggal'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div style="text-align: center;">
    <a href="MenuUtama.php" class="btn">Kembali ke Menu Utama</a>
  </div>

</body>
</html>
