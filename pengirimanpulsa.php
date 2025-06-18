<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nomor_hp = $_POST['nomor'];
  $provider = $_POST['provider'];
  $nominal = $_POST['nominal'];
  $metode = $_POST['metode'];
  $tanggal = date("Y-m-d H:i:s");

  $stmt = $conn->prepare("INSERT INTO pengirimanpulsa (nomor_hp, provider, nominal, metode, tanggal) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nomor_hp, $provider, $nominal, $metode, $tanggal);
  
  if ($stmt->execute()) {
    echo "<script>alert('✅ Pulsa berhasil dikirim ke $nomor_hp'); window.location.href='pengirimanpulsa.php';</script>";
  } else {
    echo "<script>alert('Gagal mengirim pulsa');</script>";
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pengiriman Pulsa</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #002B5B, #00599C);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #333;
    }
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      max-width: 400px;
      width: 90%;
    }
    h2 {
      text-align: center;
      color: #002B5B;
      margin-bottom: 25px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    button {
      margin-top: 25px;
      width: 100%;
      padding: 12px;
      background-color: #002B5B;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background-color: #00599C;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Pengiriman Pulsa</h2>
    <form method="POST" onsubmit="return validateForm()">
      <label for="nomor">Nomor HP Tujuan:</label>
      <input type="text" id="nomor" name="nomor" placeholder="08xxxxxxxx" required>

      <label for="provider">Provider:</label>
      <select id="provider" name="provider">
        <option>Telkomsel</option>
        <option>Indosat</option>
        <option>XL</option>
        <option>Tri</option>
      </select>

      <label for="nominal">Nominal Pulsa:</label>
      <select id="nominal" name="nominal">
        <option value="5000">Rp5.000</option>
        <option value="10000">Rp10.000</option>
        <option value="20000">Rp20.000</option>
        <option value="50000">Rp50.000</option>
        <option value="100000">Rp100.000</option>
      </select>

      <label for="metode">Metode Pembayaran:</label>
      <select id="metode" name="metode">
        <option>Transfer Bank</option>
        <option>QRIS</option>
        <option>COD</option>
      </select>

      <button type="submit">Kirim Pulsa</button>
    </form>
  </div>

  <script>
    function validateForm() {
      const nomor = document.getElementById("nomor").value.trim();
      const valid = /^08\\d{8,11}$/.test(nomor);
      if (!valid) {
        alert("Nomor HP tidak valid. Harus dimulai dengan 08 dan 10-13 digit.");
        return false;
      }
      return true;
    }
  </script>

</body>
</html>
