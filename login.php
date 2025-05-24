<?php
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "saung_bahagia";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Proses login
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password']; 

  $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $_SESSION['admin'] = $email;
    header("Location: index.php");
    exit;
  } else {
    $error = "email atau Password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <style>
    body {
      background: #fff5dc;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: #fffaf1;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 300px;
    }

    h2 {
      text-align: center;
      color: #3b240b;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #f7943e;
      border-radius: 5px;
    }

    button {
      width: 100%;
      background: #f7943e;
      border: none;
      color: white;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Login Admin</h2>
  <form action="" method="POST">
    <input type="text" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
    <?php if ($error): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
  </form>
</div>

</body>
</html>