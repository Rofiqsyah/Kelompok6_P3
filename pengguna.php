<?php
include 'koneksi.php';

$query = "SELECT * FROM pengguna";
$result = mysqli_query($conn, $query);

echo "<h2>Data Pengguna</h2>";
echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Email</th></tr>";
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['email']}</td></tr>";
}
echo "</table>";
?>