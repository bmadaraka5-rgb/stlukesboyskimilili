<?php
session_start();

// === ADMIN CREDENTIALS – TYPE YOUR OWN PASSWORD HERE ===
$ADMIN_USERNAME = 'admin';
$ADMIN_PASSWORD = 'Admin@2025';   // <<<--- TYPE YOUR OWN PASSWORD HERE

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Simple check
    if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_username'] = $ADMIN_USERNAME;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Wrong username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Failed</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { background: #f8f9fa; }
    .box { max-width: 400px; margin: 100px auto; padding: 2rem; background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <div class="box text-center">
    <div class="alert alert-danger">
      <h5>Login Failed</h5>
      <p><?= htmlspecialchars($error) ?></p>
      <a href="login.html" class="btn btn-primary">Try Again</a>
    </div>
  </div>
</body>
</html>