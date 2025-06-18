<?php
// Tangani form saat disubmit
$hash = '';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Buat hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hash Password Generator</title>
</head>
<body>
  <h2>Hash Password Generator</h2>
  <form method="POST">
    <label for="password">Masukkan Password:</label><br>
    <input type="text" id="password" name="password" required><br><br>
    <button type="submit">Generate Hash</button>
  </form>

  <?php if (!empty($hash)): ?>
    <h3>Password Asli:</h3>
    <p><?= htmlspecialchars($password) ?></p>
    <h3>Hasil Hash:</h3>
    <textarea rows="4" cols="80" readonly><?= $hash ?></textarea>
  <?php endif; ?>
</body>
</html>
