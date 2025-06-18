<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$isAdmin = ($_SESSION['role'] ?? 'user') === 'admin';

/* ======== proses beli user (POST dari checkout.php di‐bypass) ======== */
if (!$isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['produk'], $_POST['harga'], $_POST['jumlah'])) {

    $produk  = $_POST['produk'];
    $jumlah  = (int)$_POST['jumlah'];
    $harga   = (int)$_POST['harga'];

    /* cek stok */
    $cek = $conn->prepare("SELECT stok FROM barang WHERE nama = ?");
    $cek->bind_param("s", $produk);
    $cek->execute();
    $cek->bind_result($stokSekarang);
    $cek->fetch();
    $cek->close();

    if ($stokSekarang < $jumlah) {
        echo "<script>alert('Stok tidak mencukupi');</script>";
    } else {
        /* kurangi stok */
        $up = $conn->prepare("UPDATE barang SET stok = stok - ? WHERE nama = ?");
        $up->bind_param("is", $jumlah, $produk);
        $up->execute();
        $up->close();

        /* simpan transaksi */
        $namaPembeli     = $_SESSION['username'];
        $alamatPembeli   = "-";
        $ekspedisi       = "J&T";
        $metodePembayaran= "Transfer Bank";

        $in = $conn->prepare(
           "INSERT INTO transaksi (namaBarang,hargaBarang,jumlah,namaPembeli,alamatPembeli,ekspedisi,metodePembayaran,tanggal)
            VALUES (?,?,?,?,?,?,?,NOW())");
        $in->bind_param("siissss", $produk, $harga, $jumlah,
                        $namaPembeli,$alamatPembeli,$ekspedisi,$metodePembayaran);
        $in->execute(); $in->close();

        echo "<script>document.addEventListener('DOMContentLoaded',()=>showPopup('Pembelian berhasil!'));</script>";
    }
}

/* ======== filter & pencarian ======== */
$search      = trim($_GET['search'] ?? '');
$filter_stok = (int)($_GET['stok'] ?? 0);

$sql   = "SELECT * FROM barang WHERE 1";
$params= []; $types='';

if ($search !== '') {
    $sql .= " AND nama LIKE ?";
    $params[] = "%$search%"; $types .= 's';
}
if ($filter_stok > 0) {
    $sql .= " AND stok >= ?";
    $params[] = $filter_stok; $types .= 'i';
}

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result  = $stmt->get_result();
$produk  = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

/* ======== mapping gambar (tanpa spasi) ======== */
$gambarProduk = [
  "SAMSUNG GALAXY A14 5G 6/128GB" => "img/samsung galaxy 14 5g.webp",
  "SAMSUNG GALAXY A15 8/256"      => "img/samsung galaxy a15.webp",
  "SAMSUNG GALAXY A16 5G 8/256GB" => "img/samsung galaxy a16 5g.webp",
  "SAMSUNG GALAXY S25 12/512GB"   => "img/samsung galxy s25.webp",
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
<title>Menu Utama – Teco Cell</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
:root{--biru:#003366;--biru2:#004080;--bg:#f6f6f6}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;background:var(--bg);animation:fade .5s}
@keyframes fade{from{opacity:0}to{opacity:1}}
header{background:var(--biru);color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap}
.logo{font-size:22px;font-weight:bold}
.search-box{flex:1;max-width:400px}
.search-box form{display:flex;gap:10px}
.search-box input,.search-box select{padding:8px;border:1px solid #ccc;border-radius:5px;width:100%}
nav.menu{background:var(--biru2);display:flex;flex-wrap:wrap;gap:12px;justify-content:center;padding:10px}
nav a,.logout-btn{color:#fff;padding:10px 14px;text-decoration:none;border-radius:6px}
nav a:hover,.logout-btn:hover{background:rgba(255,255,255,.2)}
.logout-btn{background:#ff4d4d;border:none;cursor:pointer}
.banner{background:#fff;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;padding:30px 20px}
.banner img{width:200px;border-radius:10px}
.produk-list ul{list-style:none;padding:0}
.produk-list li{background:#fff;margin-bottom:10px;padding:10px;border:1px solid #ccc;border-radius:5px;display:flex;align-items:center;gap:15px}
.produk-list img{width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #ddd}
.produk-list li:hover{transform:translateY(-4px);box-shadow:0 4px 12px rgba(0,0,0,.1);transition:.3s}
.produk-info{flex:1}
footer{background:var(--biru);color:#fff;text-align:center;padding:15px;margin-top:30px}
.popup{position:fixed;top:20px;right:20px;background:#28a745;color:#fff;padding:12px 20px;border-radius:8px;display:none}
</style>
</head>
<body>

<header>
  <div class="logo">TECO CELL</div>
  <div class="search-box">
    <form method="get">
      <input type="text" name="search" placeholder="Cari produk…" value="<?=htmlspecialchars($search)?>">
      <select name="stok">
        <option value="0">Semua Stok</option>
        <option value="1"  <?=$filter_stok==1?'selected':''?>>Stok ≥ 1</option>
        <option value="5"  <?=$filter_stok==5?'selected':''?>>Stok ≥ 5</option>
        <option value="10" <?=$filter_stok==10?'selected':''?>>Stok ≥ 10</option>
      </select>
      <button type="submit">Filter</button>
    </form>
  </div>
</header>

<nav class="menu">
  <a href="penjualan.html">Katalog</a>

  <?php if($isAdmin): ?>
      <a href="Stokproduk.php">Stok Barang</a>
      <a href="transaksi.php">Semua Transaksi</a>
      <a href="export_excel.php">Export Excel</a>
      <a href="pengirimanpulsa.php">Pengiriman Pulsa</a>
      <a href="riwayattransaksi.php">Riwayat Transaksi</a>
  <?php else: ?>
      <a href="riwayattransaksi.php">Riwayat</a>
      <a href="keranjang.php">Keranjang</a>
      <a href="pembelian_pulsa.php">Pembelian Pulsa</a>
  <?php endif; ?>

  <a href="kontak_kami.php">Kontak Kami</a>
  <form action="logout.php" method="post" style="display:inline;">
    <button class="logout-btn">Logout</button>
  </form>
</nav>

<section class="banner">
  <div>
    <h2>Promo Minggu Ini: Samsung S24 Series</h2>
    <p>Selamat datang, <strong><?=htmlspecialchars($_SESSION['username'])?></strong>!</p>
    <a href="#produk"><button>Beli Sekarang</button></a>
  </div>
  <img src="img/samsung s24.jpg" alt="Promo">
</section>

<section id="produk" class="section produk-list">
  <h3 style="margin:20px 0;">Daftar Produk</h3>
  <ul>
  <?php foreach($produk as $item):
        $key = strtoupper($item['nama']);
        $img = $gambarProduk[$key] ?? 'img/default.jpg'; ?>
    <li>
      <img src="<?=$img?>" alt="<?=htmlspecialchars($item['nama'])?>">
      
      <div class="produk-info">
        <strong><?=htmlspecialchars($item['nama'])?></strong><br>
        Stok: <?=$item['stok']?> &nbsp; | &nbsp; Harga: Rp <?=number_format($item['harga'],0,',','.')?>
      </div>

      <?php if($isAdmin): ?>
        

      <?php else: ?>
          <form action="checkout.php" method="get">
            <input type="hidden" name="produk" value="<?=htmlspecialchars($item['nama'])?>">
            <input type="hidden" name="harga"  value="<?=$item['harga']?>">
            <button type="submit">Beli</button>
          </form>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
  <?php if(!$produk): ?><li>Tidak ada produk.</li><?php endif; ?>
  </ul>
</section>

<footer>© 2025 TECO CELL</footer>

<div id="popup" class="popup"></div>
<script>
function showPopup(msg){
  const p=document.getElementById('popup');
  p.textContent=msg; p.style.display='block';
  setTimeout(()=>p.style.display='none',3000);
}
</script>
</body>
</html>
