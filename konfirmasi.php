<?php
// konfirmasi.php - halaman setelah email dikirim
session_start();
if (!isset($_SESSION['kode_reset'])) {
    header("Location: form_reset.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Kode</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 40px; }
    .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
    input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 6px; border: 1px solid #ccc; }
    button { background: #003366; color: white; padding: 12px; border: none; width: 100%; border-radius: 6px; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Masukkan Kode Reset</h2>
    <form method="post" action="verifikasi_kode.php">
      <input type="text" name="kode" placeholder="Kode 6 digit" required>
      <button type="submit">Verifikasi</button>
    </form>
  </div>
</body>
</html>
