<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html"); exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- 1. Sanitasi & ambil input ---
    $produk  = trim($_POST['produk']   ?? '');
    $jumlah  = (int)($_POST['jumlah']  ?? 1);
    $alamat  = substr(trim($_POST['alamat'] ?? ''),0,200);       // batasi 200 char
    $ekspedisi = $_POST['ekspedisi'] ?? '';
    $metode    = $_POST['metode']    ?? '';

    if ($produk==='' || $jumlah<1 || $alamat==='') {
        die("<script>alert('Data tidak lengkap');history.back();</script>");
    }

    // --- 2. Ambil stok & harga asli dari tabel barang ---
    $stmt = $conn->prepare("SELECT stok,harga FROM barang WHERE nama=? LIMIT 1");
    $stmt->bind_param("s",$produk);
    $stmt->execute();
    $stmt->bind_result($stokKini,$hargaAsli);
    if(!$stmt->fetch()){      // produk tidak ditemukan
        $stmt->close();
        die("<script>alert('Produk tidak ditemukan');location='penjualan.html';</script>");
    }
    $stmt->close();

    // --- 3. Verifikasi stok ---
    if ($stokKini < $jumlah){
        echo "<script>alert('Stok tidak mencukupi');location='penjualan.html';</script>";
        exit;
    }

    // --- 4. Update stok ---
    $up = $conn->prepare("UPDATE barang SET stok = stok - ? WHERE nama=?");
    $up->bind_param("is",$jumlah,$produk);
    $up->execute();
    $up->close();

    // --- 5. Catat transaksi ---
    $ins = $conn->prepare(
        "INSERT INTO transaksi
         (namaBarang,hargaBarang,jumlah,namaPembeli,alamatPembeli,ekspedisi,metodePembayaran,tanggal)
         VALUES (?,?,?,?,?,?,?,NOW())");
    $ins->bind_param(
        "siissss",
        $produk,
        $hargaAsli,
        $jumlah,
        $_SESSION['username'],
        $alamat,
        $ekspedisi,
        $metode
    );
    $ins->execute();
    $ins->close();

    echo "<script>alert('Pembayaran berhasil!');location='riwayattransaksi.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout | Teco Cell</title>
<!-- gaya singkat sama seperti sebelumnya -->
<style>
  :root{--biru:#003366}
  body{font-family:'Segoe UI',sans-serif;background:#f0f4f8;margin:0}
  .wrapper{max-width:600px;margin:40px auto;background:#fff;padding:30px;border-radius:10px;
           box-shadow:0 0 15px rgba(0,0,0,.12)}
  h2{text-align:center;color:var(--biru);margin-bottom:20px}
  label{display:block;margin-top:15px;font-weight:bold}
  input,select{width:100%;padding:10px;margin-top:5px;border:1px solid #ccc;border-radius:6px}
  button{margin-top:25px;width:100%;padding:12px;background:var(--biru);color:#fff;border:0;
         border-radius:8px;font-weight:bold;cursor:pointer}
  button:hover{background:#002244}
</style>
</head>
<body>
<div class="wrapper">
  <h2>Checkout Pembelian</h2>

  <form method="POST">
    <label>Nama Produk
      <input readonly name="produk"
             value="<?= htmlspecialchars($_GET['produk']??'') ?>">
    </label>

    <label>Harga (per item)
      <input readonly value="Rp <?= number_format((int)($_GET['harga']??0),0,',','.') ?>">
    </label>

    <label>Jumlah
      <input required type="number" name="jumlah" min="1" value="1">
    </label>

    <label>Alamat Pengiriman
      <input required name="alamat" placeholder="Masukkan alamat lengkap">
    </label>

    <label>Ekspedisi
      <select name="ekspedisi" required>
        <option value="J&T">J&T</option>
        <option value="SiCepat">SiCepat</option>
        <option value="JNE">JNE</option>
      </select>
    </label>

    <label>Metode Pembayaran
      <select name="metode" required>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="COD">COD</option>
        <option value="QRIS">QRIS</option>
      </select>
    </label>

    <button type="submit">Konfirmasi & Bayar</button>
  </form>
</div>
</body>
</html>
