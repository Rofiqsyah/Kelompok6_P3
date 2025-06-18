<?php
/**
 *  transaksi.php
 *  Menampilkan tabel riwayat transaksi
 *  © 2025 Teco Cell
 */
session_start();
require_once 'koneksi.php';

/* ========== Proteksi Login ========== */
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}

/* ========== Ambil Data Transaksi ========== */
$sql  = "SELECT * FROM transaksi ORDER BY id DESC";
$data = $conn->query($sql);

/* ========== Jika dipanggil AJAX (fetch) ========== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect'])) {
    echo json_encode(['status' => 'sukses']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi – Teco Cell</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --biru-tua:#003366;
            --biru-tombol:#004080;
            --biru-hover:#002f66;
        }
        *{box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{
            margin:0;padding:30px;
            background:linear-gradient(to right,#eef2f3,#d9e2ec);
            color:#000;animation:fadeIn .6s ease-in-out
        }
        @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
        h1{
            margin:0 0 20px;
            color:var(--biru-tua);
            animation:slideDown .5s ease-in-out
        }
        @keyframes slideDown{from{transform:translateY(-20px);opacity:0}to{transform:none;opacity:1}}
        table{
            width:100%;border-collapse:collapse;background:#fff
        }
        th,td{
            padding:10px;border:1px solid #ccd6e0;font-size:14px
        }
        th{background:var(--biru-tua);color:#fff}
        tr:nth-child(even){background:#f4f8fc}
        tr:hover{background:#e0f0ff;transition:.3s}
        .btn-back{
            display:inline-block;margin-top:25px;padding:10px 22px;
            background:var(--biru-tombol);color:#fff;text-decoration:none;font-weight:600;
            border-radius:8px;transition:.3s
        }
        .btn-back:hover{background:var(--biru-hover)}
        @media(max-width:768px){th,td{font-size:12px}}
    </style>
</head>
<body>

<h1>Data Transaksi</h1>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Nama Pembeli</th>
        <th>Alamat</th>
        <th>Ekspedisi</th>
        <th>Metode</th>
        <th>Tanggal</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($data && $data->num_rows): ?>
        <?php while ($row = $data->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['namaBarang']) ?></td>
                <td>Rp <?= number_format($row['hargaBarang'],0,',','.') ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= htmlspecialchars($row['namaPembeli']) ?></td>
                <td><?= htmlspecialchars($row['alamatPembeli']) ?></td>
                <td><?= htmlspecialchars($row['ekspedisi']) ?></td>
                <td><?= htmlspecialchars($row['metodePembayaran']) ?></td>
                <td><?= date('d-m-Y H:i:s',strtotime($row['tanggal'])) ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="9" style="text-align:center">Belum ada transaksi.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<a href="penjualan.html" class="btn-back">← Kembali ke Produk</a>

</body>
</html>
