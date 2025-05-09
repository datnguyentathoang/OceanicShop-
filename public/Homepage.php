<?php
session_start(); 
include('../php/connect.php');
include('../php/sanphamhelper.php');
$sanpham = new SanPhamHelper($conn);
// Xử lý thêm/xóa sản phẩm khỏi giỏ hàng
$sanpham->addToCart();
$sanpham->removeFromCart();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/png" href="../img/11zon_cropped.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <title>Oceanic US</title>
</head>
<body>
    <div class="header-link">
        <div class="menu">
            <a href="#">Find store</a>
            <a href="#">Contact Us</a>
            <div class="dropdown">
                <a href="#">Tiếng Việt <span class="arrow">▼</span></a>
                <div class="dropdown-menu">
                    <a href="#">🇻🇳 Tiếng Việt</a>
                    <a href="#">🇺🇸 English</a>
                    <a href="#">🇫🇷 Français</a>
                </div>
            </div>
        </div>
        <div class="marquee-container">
            <div class="marquee-text">✨ Trang sức tinh tế – Khẳng định đẳng cấp ✨
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Chỉ có tại Oceanic - Hòn ngọc viễn đông</div>
        </div>
        <div class="right-menu">
            <a href="https://www.linkedin.com/in/dat-nguyen-94b59a331/" target="_blank">
                <i class="fa-brands fa-linkedin"></i>
            </a>
            <a href="https://github.com/datnguyentathoang" target="_blank">
                <i class="fa-brands fa-github"></i>
            </a>
        </div>
    </div>
    <div class="Main-Header">
        <div class="logo">
            <a href="index.html">
                <img src="../img/result_white.png" alt="Logo">
                <div class="shine"></div>
            </a>
        </div>
        <div class="Main-menu">
            <a href="Homepage.php">Home</a>
            <a href="">About</a>
            <a href="">Service</a>
            <a id="openCartBtn" href="#" data-bs-toggle="modal" data-bs-target="#cartModal">Carts</a>
        </div>
        <div class="login">
            <?php
            if (isset($_SESSION['tknguoidung'])) {
                echo '
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Hello
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../php/logout.php">Đăng xuất</a></li>
                    <li><a class="dropdown-item" href="#">Thông tin tài khoản</a></li>
                </ul>';
            } else {
                echo '<a href="../index.php">Đăng nhập / Đăng ký</a>';
            }
            ?>
        </div>
    </div>
    <div class="frame">
        <img src="https://i.pinimg.com/736x/4b/48/9d/4b489dc74fcea56d6867687afbaccb2a.jpg" class="frame-background" alt="Background">
        <div class="slideshow-container">
            <div class="slideshow">
                <img src="../img/cuban.png" class="slideshow-image" alt="Slide 1">
                <img src="https://i.pinimg.com/736x/da/a0/ea/daa0eaf8a3f2090936f7f74ffd3a9b1c.jpg" class="slideshow-image" alt="Slide 2">
                <img src="../img/content-bg-3.jpg" class="slideshow-image" alt="Slide 3">
                <img src="https://i.pinimg.com/736x/35/e7/0b/35e70b500748d00480074b3914c953dd.jpg" class="slideshow-image" alt="Slide 4">
            </div>
        </div>
        <div class="banner-text">
            <h1>Oceanic</h1>
            <h2><i>Hyper Generation</i></h2>
            <br><br><br>
            <h3>Đẳng cấp tạo nên sự khác biệt</h3>
        </div>
    </div>
    <div class="wrapper">
        <div class="card card-nature">
            <div class="card-info">
                <h2>Lắc tay</h2>
                <p>Vẻ đẹp vượt thời gian, tỏa sáng cùng bạn.</p>
                <a href="#">Xem thêm</a>
            </div>
        </div>
        <div class="card card-city">
            <div class="card-info">
                <h2>Dây chuyền</h2>
                <p>Cho vẻ đẹp tỏa sáng từ tim.</p>
                <a href="#">Xem ngay</a>
            </div>
        </div>
        <div class="card card-tech">
            <div class="card-info">
                <h2>Nhẫn</h2>
                <p>Duyên dáng cổ tay, tỏa sáng phong cách.</p>
                <a href="#">Xem ngay</a>
            </div>
        </div>
    </div>
    <div class="overview">
        <h3>Tổng quan sản phẩm</h3>
        <br>
        <nav class="main-menu">
            <ul>
                <li class="allpr"><a href="#">Tất cả sản phẩm</a></li>
                <li><a class="small-choose" href="#">Dây chuyền</a></li>
                <li><a class="small-choose" href="#">Nhẫn</a></li>
                <li><a class="small-choose" href="#">Lắc tay</a></li>
                <li><a class="small-choose" href="#">Bông tai</a></li>
                <li><a class="small-choose" href="#">Grill</a></li>
            </ul>
        </nav>
        <div class="product-grid">
            <?php
            $sanpham->select();
            ?>
        </div>
    </div>

    <!-- Modal giỏ hàng -->
    <?php $sanpham->displayCart(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
 
</body>
</html>