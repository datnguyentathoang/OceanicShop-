<?php
include('php/login.php');
?>
<!DOCTYPE html>

<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oceanic | Đăng nhập, đăng ký</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="wrapper">
    <form method="POST">
      <h2>Login</h2>
        <p><?php echo  $_SESSION['message']; ?></p>
        <div class="input-field">
        <input type="text" name="taikhoan" required>
        <label>Tên đăng nhập</label>
      </div>
      <div class="input-field">
        <input type="password" name="matkhau" required>
        <label>Nhập mật khẩu</label>
      </div>
      <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p>Ghi nhớ đăng nhập</p>
        </label>
        <a href="#">Quên mật khẩu?</a>
      </div>
      <button type="submit" name="submit">Đăng nhập</button>
      <div class="register">
        <p>Không có tài khoản? <a href="register.php">Đăng ký</a></p>
      </div>
    </form>
  </div>
</body>
</html>