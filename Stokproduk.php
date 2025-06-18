<?php
include 'koneksi.php';

// Tambah barang jika ada input POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $stok = $_POST['stok'];
  $harga = $_POST['harga'];

  if (!empty($nama) && is_numeric($stok) && is_numeric($harga)) {
    $stmt = $conn->prepare("INSERT INTO barang (nama, stok, harga) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nama, $stok, $harga);
    $stmt->execute();
  }
}

// Hapus barang jika ada ID
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM barang WHERE id = $id");
}

$barang = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Stok Barang</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #002f66;
      color: #fff;
      padding: 40px;
    }
    .container {
      background-color: #fff;
      color: #000;
      border-radius: 12px;
      padding: 20px;
      max-width: 800px;
      margin: auto;
    }
    h2 {
      text-align: center;
      color: #002f66;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #002f66;
      color: white;
    }
    .form-section {
      background: #f3f7fa;
      padding: 20px;
      margin-top: 30px;
      border-radius: 10px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      padding: 10px 20px;
      background-color: #002f66;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    a.btn-delete {
      color: red;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Daftar Barang</h2>

    <table>
      <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Aksi</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($barang)) : ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= $row['stok'] ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td><a href="?hapus=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus barang ini?')">Hapus</a></td>
      </tr>
      <?php endwhile; ?>
    </table>

    <div class="form-section">
      <h3>Tambah Barang</h3>
      <form method="POST">
        <input type="text" name="nama" placeholder="Nama Barang" required />
        <input type="number" name="stok" placeholder="Stok" required />
        <input type="number" name="harga" placeholder="Harga" required />
        <button type="submit">Tambah</button>
      </form>
    </div>
  </div>
</body>
</html>
