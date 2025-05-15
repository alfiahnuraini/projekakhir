<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Dashboard Admin</title></head>
<body>
  <h2>Selamat datang, <?php echo $_SESSION['admin']; ?>!</h2>
  <a href="logout.php">Logout</a>
</body>
</html>