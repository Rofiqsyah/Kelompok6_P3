<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomor = trim($_POST["nomor"]);
    $provider = $_POST["provider"];
    $nominal = (int)$_POST["nominal"];
    $username = $_SESSION["username"];

    if (!preg_match('/^08[0-9]{8,11}$/', $nomor)) {
        echo "<script>alert('Nomor tidak valid!');history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO pulsa (nomor, provider, nominal, user, tanggal) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssis", $nomor, $provider, $nominal, $username);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Pulsa berhasil dikirim!'); window.location='menuutama.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengiriman Pulsa</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      padding: 30px;
    }
    .form-box {
      max-width: 400px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #003366;
    }
    label {
      display: block;
      margin-top: 15px;
    }
    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      background-color: #003366;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background-color: #002244;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Form Pengiriman Pulsa</h2>
    <form method="POST" action="">
      <label for="nomor">Nomor HP</label>
      <input type="text" name="nomor" id="nomor" placeholder="Contoh: 081234567890" required>

      <label for="provider">Provider</label>
      <select name="provider" id="provider" required>
        <option value="Telkomsel">Telkomsel</option>
        <option value="XL">XL</option>
        <option value="Axis">Axis</option>
        <option value="Tri">Tri</option>
        <option value="Indosat">Indosat</option>
        <option value="Smartfren">Smartfren</option>
      </select>

      <label for="nominal">Nominal Pulsa</label>
      <select name="nominal" id="nominal" required>
        <option value="5000">Rp 5.000</option>
        <option value="10000">Rp 10.000</option>
        <option value="20000">Rp 20.000</option>
        <option value="50000">Rp 50.000</option>
        <option value="100000">Rp 100.000</option>
      </select>

      <button type="submit">Kirim Pulsa</button>
    </form>
  </div>
</body>
</html>
