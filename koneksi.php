<?php
$host = "sql305.infinityfree.com";     // Host InfinityFree
$user = "if0_39176500";                // Username MySQL InfinityFree
$pass = "SayyfuxcxvI";                 // Password MySQL kamu
$db   = "if0_39176500_teco_cell";      // Nama database di InfinityFree

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
