<?php
class SanPhamHelper {
    protected $conn;
   
    public function __construct($conn) {
        $this->conn = $conn;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function select() {
        $query = "SELECT sp.*, th.ten_thuong_hieu, dm.ten_danh_muc
                  FROM san_pham sp
                  LEFT JOIN thuong_hieu th ON sp.ma_thuong_hieu = th.ma_thuong_hieu
                  LEFT JOIN danh_muc dm ON sp.ma_danh_muc = dm.ma_danh_muc";

        $runQuery = mysqli_query($this->conn, $query);

        if (!$runQuery) {
            echo '<div class="error">Lỗi truy vấn cơ sở dữ liệu: ' . mysqli_error($this->conn) . '</div>';
            return;
        }

        if (mysqli_num_rows($runQuery) == 0) {
            echo '<div class="no-data">Không có dữ liệu</div>';
        } else {
            while ($readData = mysqli_fetch_assoc($runQuery)) {
                $maSp = $readData["ma_san_pham"];
                $ten = htmlspecialchars($readData["ten_san_pham"], ENT_QUOTES, 'UTF-8');
                $gia = number_format($readData["gia_niem_yet"], 0, ',', '.');
                $url = htmlspecialchars($readData["url"], ENT_QUOTES, 'UTF-8');
                $mo_ta = !empty($readData["mo_ta"]) ? nl2br(htmlspecialchars($readData["mo_ta"], ENT_QUOTES, 'UTF-8')) : "Không có mô tả.";
                $thuong_hieu = htmlspecialchars($readData["ten_thuong_hieu"] ?? 'Chưa cập nhật', ENT_QUOTES, 'UTF-8');
                $danh_muc = htmlspecialchars($readData["ten_danh_muc"] ?? 'Chưa cập nhật', ENT_QUOTES, 'UTF-8');

                $modalId = 'exampleModal_' . $maSp;

                echo '
                <a href="#" class="product-link" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">
                    <div class="product-item">
                        <img src="' . $url . '" alt="' . $ten . '">
                        <span class="product-name modal-title" style="text-decoration: none;">' . $ten . '</span>
                        <i class="fa-solid fa-heart" aria-label="Thêm vào yêu thích"></i>
                        <b>' . $gia . ' ₫</b>
                    </div>
                </a>';

                echo <<<HTML
                <div class="modal fade" id="{$modalId}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">{$ten}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                      </div>
                      <div class="modal-body">
                        <img src="{$url}" alt="{$ten}" class="img-fluid mb-3 rounded">
                        <ul class="list-group mb-3">
                          <li class="list-group-item"><strong>Thương hiệu:</strong> {$thuong_hieu}</li>
                          <li class="list-group-item"><strong>Danh mục:</strong> {$danh_muc}</li>
                          <li class="list-group-item"><strong>Giá:</strong> {$gia} ₫</li>
                        </ul>
                        <div>
                          <h6>Mô tả sản phẩm</h6>
                          <p>{$mo_ta}</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <form action="" method="POST">
                            <input type="hidden" name="ma_san_pham" value="{$maSp}">
                            <input type="hidden" name="ten_san_pham" value="{$ten}">
                            <input type="hidden" name="gia" value="{$readData['gia_niem_yet']}">
                            <input type="hidden" name="url" value="{$url}">
                            <input type="number" name="so_luong" value="1" min="1" style="width: 60px;">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Thêm vào giỏ hàng</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                HTML;
            }
        }
    }

    public function addToCart() {
        if (isset($_POST['add_to_cart'])) {
            $maSp = $_POST['ma_san_pham'];
            $tenSp = $_POST['ten_san_pham'];
            $gia = $_POST['gia'];
            $url = $_POST['url'];
            $soLuong = isset($_POST['so_luong']) ? (int)$_POST['so_luong'] : 1;
            if(!isset($_SESSION['tknguoidung'])){
              $_SESSION['message'] = "Bạn cần đăng nhập để mua sản phẩm";
              header('location: ../index.php');
              exit();
              
            }
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$maSp])) {
                $_SESSION['cart'][$maSp]['so_luong'] += $soLuong;
            } else {
                $_SESSION['cart'][$maSp] = [
                    'ten_san_pham' => $tenSp,
                    'gia' => $gia,
                    'url' => $url,
                    'so_luong' => $soLuong
                ];
            }

            echo '<div class="alert alert-success">Đã thêm sản phẩm vào giỏ hàng!</div>';
        }
    }

    public function displayCart() {
    
        echo '
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">';
             
                      
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo '<div class="alert alert-info">Giỏ hàng trống</div>';
        } else {
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Hình ảnh</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Tổng</th><th>Thao tác</th></tr></thead>';
            echo '<tbody>';

            $tongTien = 0;
            foreach ($_SESSION['cart'] as $maSp => $item) {
                $thanhTien = $item['gia'] * $item['so_luong'];
                $tongTien += $thanhTien;

                echo '<tr>';
                echo '<td><img src="' . htmlspecialchars($item['url']) . '" alt="' . htmlspecialchars($item['ten_san_pham']) . '" style="width: 50px;"></td>';
                echo '<td>' . htmlspecialchars($item['ten_san_pham']) . '</td>';
                echo '<td>' . number_format($item['gia'], 0, ',', '.') . ' ₫</td>';
                echo '<td>' . $item['so_luong'] . '</td>';
                echo '<td>' . number_format($thanhTien, 0, ',', '.') . ' ₫</td>';
                echo '<td>
                        <form action="" method="POST">
                            <input type="hidden" name="ma_san_pham" value="' . $maSp . '">
                            <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                      </td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '<div class="cart-total"><strong>Tổng cộng: ' . number_format($tongTien, 0, ',', '.') . ' ₫</strong></div>';
        }

        echo '
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <a href="checkout.php" class="btn btn-primary">Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>';
      
    }

    public function removeFromCart() {
        if (isset($_POST['remove_from_cart']) && isset($_POST['ma_san_pham'])) {
            $maSp = $_POST['ma_san_pham'];
            if (isset($_SESSION['cart'][$maSp])) {
                unset($_SESSION['cart'][$maSp]);
                echo '<div class="alert alert-success">Đã xóa sản phẩm khỏi giỏ hàng!</div>';
            }
        }
    }
}
?>