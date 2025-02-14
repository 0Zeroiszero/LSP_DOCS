<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login Staff</title>

  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <div class="login-container">
    <h2>LOGIN STAFF</h2>
    <form method="post" action="controller/login.php">
      <div class="input-group">
        <span class="icon">&#128100;</span>
        <input type="text" placeholder="Masukkan Username Staff" name="username" required>
      </div>
      <div class="input-group">
        <span class="icon">&#128273;</span>
        <input type="password" placeholder="Masukkan Password Staff" name="password" required>
      </div>
      <p><?= isset($login_err) ? $login_err : ''; ?></p>
      <button type="submit">LOGIN</button>
    </form>
  </div>
</body>
</html>
