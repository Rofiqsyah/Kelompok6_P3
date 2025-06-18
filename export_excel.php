<?php
include 'koneksi.php';
header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=riwayat_transaksi.xls");

if (isset($_POST['query'])) {
    $query = base64_decode($_POST['query']);
    $result = mysqli_query($conn, $query);

    echo "<table border='1'>";
    echo "<tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Pembeli</th>
            <th>Alamat</th>
            <th>Ekspedisi</th>
            <th>Metode</th>
            <th>Tanggal</th>
          </tr>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['namaBarang']}</td>
                <td>{$row['hargaBarang']}</td>
                <td>{$row['namaPembeli']}</td>
                <td>{$row['alamatPembeli']}</td>
                <td>{$row['ekspedisi']}</td>
                <td>{$row['metodePembayaran']}</td>
                <td>{$row['tanggal']}</td>
              </tr>";
    }

    echo "</table>";
}
?>
