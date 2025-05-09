<?php
session_start();
include('connect.php');

$_SESSION['message'] = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['taikhoan']) || empty($_POST['matkhau']) || empty($_POST['checkmk'])) {
        $_SESSION['message']= "Vui lòng điền đầy đủ thông tin";
    } else if ($_POST['matkhau'] != $_POST['checkmk']) {
        $_SESSION['message'] = "Mật khẩu và nhập lại mật khẩu không trùng khớp";
    } else {
        $tk = mysqli_real_escape_string($conn, $_POST['taikhoan']);
        $mk = $_POST['matkhau'];

        $truyvanlaytk = "SELECT username FROM taikhoan WHERE username = '$tk'";
        $chaylen_laytk = mysqli_query($conn, $truyvanlaytk);

        if (mysqli_num_rows($chaylen_laytk) > 0) {
            $_SESSION['message'] = "Tài khoản đã tồn tại, vui lòng chọn tên khác";
        } else {

            $mk_mahoa = password_hash($mk, PASSWORD_DEFAULT);

            $truyvan_them = "INSERT INTO taikhoan (username, password) VALUES ('$tk', '$mk_mahoa')";
            $ketqua = mysqli_query($conn, $truyvan_them);

            if ($ketqua) {
                $_SESSION['message'] = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['message'] = "Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.";
            }
        }
    }
}
?>
