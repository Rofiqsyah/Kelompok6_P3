<?php
/* -------------------------------------------------------------------------- */
/*  AKTIFKAN DEBUG (HAPUS dua baris ini di production)                        */
/* -------------------------------------------------------------------------- */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* -------------------------------------------------------------------------- */
/*  Koneksi database (pastikan file ini ada di folder yang sama)              */
/* -------------------------------------------------------------------------- */
require_once __DIR__ . '/koneksi.php';   // $conn = mysqli_connect(...);

/* -------------------------------------------------------------------------- */
/*  Jika request POST, proses pendaftaran                                     */
/* -------------------------------------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* -------- Ambil & sanitasi input -------------------------------------- */
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    /* -------- Validasi dasar --------------------------------------------- */
    if ($username === '' || $email === '' || $password === '') {
        exitWithAlert('Semua field wajib diisi!');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exitWithAlert('Format email tidak valid!');
    }

    /* -------- Cek duplikasi username / email ----------------------------- */
    $cek = $conn->prepare(
        "SELECT id FROM pengguna WHERE username = ? OR email = ? LIMIT 1"
    );
    if (!$cek) {
        exitWithAlert('Query error: ' . $conn->error);
    }
    $cek->bind_param('ss', $username, $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $cek->close();
        exitWithAlert('Username atau email sudah terdaftar!');
    }
    $cek->close();

    /* -------- Simpan pengguna baru --------------------------------------- */
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO pengguna (username, password, email) VALUES (?, ?, ?)"
    );
    if (!$stmt) {
        exitWithAlert('Query error: ' . $conn->error);
    }
    $stmt->bind_param('sss', $username, $hashed, $email);

    if ($stmt->execute()) {
        /* -------- Sukses: arahkan ke halaman login ----------------------- */
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href = 'login.html';
              </script>";
    } else {
        exitWithAlert('Gagal menyimpan data: ' . $stmt->error);
    }
    $stmt->close();
}

$conn->close();
exit();

/* -------------------------------------------------------------------------- */
/*  FUNGSI BANTUAN                                                            */
/* -------------------------------------------------------------------------- */
function exitWithAlert(string $message): void
{
    echo "<script>alert('". addslashes($message) ."'); history.back();</script>";
    exit;
}
?>
