<?php
session_start();
include('connect.php');

$_SESSION['message'] ="";
$tk_temp = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['taikhoan']) || empty($_POST['matkhau'])) {
        $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin";
    } else {
        $tk = mysqli_real_escape_string($conn, $_POST['taikhoan']);
        $mk = $_POST['matkhau'];
        $tk_temp = htmlspecialchars($tk); 

        $truyvanlaytk = "SELECT username, password FROM taikhoan WHERE username = '$tk'";
        $chaylen_laytk = mysqli_query($conn, $truyvanlaytk);

        if (mysqli_num_rows($chaylen_laytk) == 0) {
            $_SESSION['message'] = "Tài khoản không tồn tại";
        } else {
            $dltk = mysqli_fetch_assoc($chaylen_laytk);
            $tk_csdl = $dltk['username'];
            $mk_csdl = $dltk['password'];

            if (password_verify($mk, $mk_csdl)) {
                $_SESSION['tknguoidung'] = $tk_csdl;
                $_SESSION['TIMER'] = time();
                $_SESSION['message'] = "";
                header('Location: public/Homepage.php');
                exit();
            } else {
                $_SESSION['message'] = "Mật khẩu không đúng";
            }
        }
    }
}
?>