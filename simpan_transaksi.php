<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil JSON dari fetch body
$data = json_decode(file_get_contents("php://input"), true);

// Validasi
if (!$data || empty($data['namaBarang']) || empty($data['namaPembeli']) || empty($data['alamatPembeli'])) {
    echo json_encode(["status" => "gagal", "error" => "Data tidak lengkap"]);
    exit;
}

// Ambil datanya
$namaBarang = $data['namaBarang'];
$hargaBarang = $data['hargaBarang'];
$namaPembeli = $data['namaPembeli'];
$alamatPembeli = $data['alamatPembeli'];
$ekspedisi = $data['ekspedisi'];
$metode = $data['metodePembayaran'];
$tanggal = $data['tanggal'];

// Simpan ke tabel
$sql = "INSERT INTO transaksi (namaBarang, hargaBarang, namaPembeli, alamatPembeli, ekspedisi, metodePembayaran, tanggal)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsssss", $namaBarang, $hargaBarang, $namaPembeli, $alamatPembeli, $ekspedisi, $metode, $tanggal);

if ($stmt->execute()) {
    echo json_encode(["status" => "sukses"]);
} else {
    echo json_encode(["status" => "gagal", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
