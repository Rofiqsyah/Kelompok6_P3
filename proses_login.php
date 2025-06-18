<?php
/* ----------  proses_login.php  ---------- */
declare(strict_types=1);
session_start();

/* --- tampilkan error selama development (matikan di production) --- */
ini_set('display_errors', '1');
error_reporting(E_ALL);

/* Ambil koneksi  */
require_once __DIR__ . '/koneksi.php';   // variabel $conn (mysqli)

/* ---------- helper ---------- */
function backWithAlert(string $msg): never
{
    echo "<script>alert('{$msg}');window.location.href='login.html';</script>";
    exit;
}

/* Pastikan method POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

/* Filter input */
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    backWithAlert('Username dan Password wajib diisi!');
}

/* Query pengguna berdasar username */
$stmt = $conn->prepare(
    'SELECT id, username, password, role 
       FROM pengguna 
      WHERE username = ? LIMIT 1'
);
if (!$stmt) {
    backWithAlert('Terjadi kesalahan server (prepare).');
}
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    backWithAlert('Username tidak ditemukan!');
}

$user = $result->fetch_assoc();

/* Verifikasi password */
if (!password_verify($password, $user['password'])) {
    backWithAlert('Password salah!');
}

/* ------------- LOGIN SUKSES ------------- */
$_SESSION['user_id']  = (int)$user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role']     = $user['role'];      // 'admin' atau 'user'

/* Tutup statement & koneksi */
$stmt->close();
$conn->close();

/* Redirect ke halaman utama */
header('Location: menuutama.php');
exit;
