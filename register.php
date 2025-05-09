<?php
include('php/dangky.php');
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
      <h2>Register</h2>
        <p><?php echo  $_SESSION['message']; ?></p>
        <div class="input-field">
        <input type="text" name="taikhoan" required>
        <label>Tên đăng nhập</label>
      </div>
      <div class="input-field">
        <input type="password" name="matkhau" required>
        <label>Nhập mật khẩu</label>
      </div>
      <div class="input-field">
        <input type="password" name="checkmk" required>
        <label>Nhập lại mật khẩu</label>
      </div>
      <button type="submit" name="submit">Đăng ký</button>
    
    </form>
  </div>
</body>
</html>