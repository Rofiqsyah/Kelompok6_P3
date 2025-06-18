<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontak Kami - Teco Cell</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f8f9fa;
      color: #333;
    }
    header {
      background-color: #003366;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }
    .container {
      max-width: 800px;
      margin: 30px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
      color: #003366;
    }
    p {
      line-height: 1.6;
    }
    .info {
      background: #e9f5ff;
      padding: 15px;
      margin-top: 20px;
      border-left: 4px solid #003366;
    }
    a {
      color: #003366;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    footer {
      margin-top: 30px;
      text-align: center;
      background-color: #003366;
      color: white;
      padding: 15px;
    }
  </style>
</head>
<body>
  <header>Kontak Kami</header>

  <div class="container">
    <h2>Hubungi Teco Cell</h2>
    <p>Jika Anda memiliki pertanyaan, saran, atau kendala terkait layanan kami, silakan hubungi kami melalui informasi di bawah ini:</p>

    <div class="info">
      <p><strong>Alamat:</strong> Jl. Raya Dalopo No. 147 Krajan, Kabupaten Madiun, Jawa Timur 63174</p>
      <p><strong>Telepon:</strong> 0812-3456-7890</p>
      <p><strong>Email:</strong> <a href="mailto:support@tecocell.id">support@tecocell.id</a></p>
      <p><strong>Jam Operasional:</strong> Senin - Sabtu, 08.00 - 17.00 WIB</p>
    </div>

    <p>Terima kasih telah mempercayai layanan kami!</p>
    <p><a href="menuutama.php">&larr; Kembali ke Menu Utama</a></p>
  </div>

  <footer>
    &copy; 2025 TECO CELL
  </footer>
</body>
</html>
