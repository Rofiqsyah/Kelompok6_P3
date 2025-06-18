<?php
$koneksi = new mysqli("localhost", "root", "", "teco_cell");
$result = $koneksi->query("SELECT * FROM pengguna ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pengguna</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #001f3f, #003366);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 50px;
    }

    .container {
      background: #fff;
      color: #333;
      border-radius: 12px;
      padding: 30px;
      width: 90%;
      max-width: 800px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      color: #001f3f;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #003366;
      color: #fff;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .back-link {
      margin-top: 20px;
      text-align: center;
    }

    .back-link a {
      text-decoration: none;
      color: #003366;
      font-weight: 600;
    }

    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Daftar Pengguna Terdaftar</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>

    <div class="back-link">
      <a href="daftar.html">&larr; Kembali ke Form Daftar</a>
    </div>
  </div>
</body>
</html>
