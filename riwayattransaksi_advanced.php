<?php
include 'koneksi.php';

$filter = '';
$search = '';
$where = [];

if (!empty($_GET['from']) && !empty($_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $where[] = "tanggal BETWEEN '$from' AND '$to'";
}

if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $where[] = "(namaBarang LIKE '%$search%' OR namaPembeli LIKE '%$search%')";
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$query = "SELECT * FROM transaksi $where_sql ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Transaksi (Filter & Export)</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f2f2f2; }
    h2 { text-align: center; color: #003366; }
    form { margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px; }
    input, button { padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { padding: 10px; border: 1px solid #ddd; }
    th { background-color: #004080; color: white; }
    a.button, button.button {
      padding: 10px 16px;
      background-color: #004080;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      border: none;
      cursor: pointer;
    }
    .export { margin-top: 10px; }
  </style>
</head>
<body>

<h2>Riwayat Transaksi</h2>

<form method="GET">
  <label>Dari Tanggal: <input type="date" name="from" value="<?= isset($_GET['from']) ? $_GET['from'] : '' ?>"></label>
  <label>Sampai Tanggal: <input type="date" name="to" value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>"></label>
  <label>Cari Produk/Pembeli: <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"></label>
  <button type="submit" class="button">Terapkan</button>
  <a href="riwayattransaksi_advanced.php" class="button">Reset</a>
</form>

<form method="POST" action="export_excel.php">
  <input type="hidden" name="query" value="<?= base64_encode($query) ?>">
  <button type="submit" class="button export">Export ke Excel</button>
</form>

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
