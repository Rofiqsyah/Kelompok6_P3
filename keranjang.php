<?php
session_start();
include 'koneksi.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Tambahkan produk ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produk'], $_POST['harga'], $_POST['jumlah'])) {
    $item = [
        'produk' => $_POST['produk'],
        'harga' => (int)$_POST['harga'],
        'jumlah' => (int)$_POST['jumlah'],
    ];
    $_SESSION['keranjang'][] = $item;
}

// Hapus item dari keranjang
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $index = (int)$_GET['hapus'];
    if (isset($_SESSION['keranjang'][$index])) {
        unset($_SESSION['keranjang'][$index]);
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    }
    header('Location: keranjang.php');
    exit();
}

$keranjang = $_SESSION['keranjang'];

// Mapping gambar produk
$gambarProduk = [
  "SAMSUNG GALAXY A14 5G 6/128GB" => "img/samsung galaxy 14 5g.webp",
  "SAMSUNG GALAXY A15 8/256"      => "img/samsung galaxy a15.webp",
  "SAMSUNG GALAXY A16 5G 8/256GB" => "img/samsung galaxy a16 5g.webp",
  "SAMSUNG GALAXY S25 12/512GB"   => "img/samsung galaxy s25.webp",
  "14 PRO IBOX 128GB"             => "img/14 ibox.webp",
  "IPHONE 15 PRO MAX 256GB"       => "img/ip 15 pro ibox.webp",
  "IPHONE 16 INTER 256GB"         => "img/ip 16 inter.jpg",
  "GOOGLE PIXEL 6 256GB"          => "img/google pixel 6.jpg"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #f9f9f9; }
    h2 { color: #003366; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    th { background-color: #003366; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
    img { width: 60px; border-radius: 5px; }
    .btn-kembali, .btn-checkout {
      margin-top: 20px;
      display: inline-block;
      padding: 10px 20px;
      background-color: #004080;
      color: white;
      text-decoration: none;
      border-radius: 6px;
    }
    .btn-hapus {
      color: red;
      text-decoration: none;
      font-weight: bold;
    }
    .btn-checkout {
      background-color: green;
      margin-left: 10px;
    }
  </style>
</head>
<body>

<h2>Keranjang Belanja Anda</h2>

<?php if (empty($keranjang)): ?>
  <p>Keranjang kosong.</p>
<?php else: ?>
  <table>
    <tr>
      <th>Gambar</th>
      <th>Produk</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Total</th>
      <th>Aksi</th>
    </tr>
    <?php
      $grandTotal = 0;
      foreach ($keranjang as $i => $item):
        $total = $item['harga'] * $item['jumlah'];
        $grandTotal += $total;
        $key = strtoupper($item['produk']);
        $img = $gambarProduk[$key] ?? 'img/default.jpg';
    ?>
    <tr>
      <td><img src="<?= $img ?>" alt="<?= htmlspecialchars($item['produk']) ?>"></td>
      <td><?= htmlspecialchars($item['produk']) ?></td>
      <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
      <td><?= $item['jumlah'] ?></td>
      <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
      <td><a class="btn-hapus" href="?hapus=<?= $i ?>" onclick="return confirm('Hapus item ini?')">Hapus</a></td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="4"><strong>Total Belanja</strong></td>
      <td colspan="2"><strong>Rp <?= number_format($grandTotal, 0, ',', '.') ?></strong></td>
    </tr>
  </table>
<?php endif; ?>

<a href="menuutama.php" class="btn-kembali">← Kembali ke Menu</a>
<?php if (!empty($keranjang)): ?>
  
    <form action="checkout.php" method="post" style="display:inline;">
      <input type="hidden" name="checkout" value="1">
      <button type="submit" class="btn-checkout">Checkout</button>
    </form>
    
<?php endif; ?>

</body>
</html>
