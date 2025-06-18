<?php
include 'koneksi.php';

$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

echo "<h2>Data Barang</h2>";
echo "<table border='1'><tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th></tr>";
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$row['id']}</td><td>{$row['nama_barang']}</td><td>{$row['harga']}</td><td>{$row['stok']}</td></tr>";
}
echo "</table>";
?>