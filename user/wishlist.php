<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>
        alert("Bạn cần đăng nhập trước đã!")
        window.location.href = "/index.php";
      </script>';
  }

$username = $_SESSION["username"]; // Lấy tên tài khoản từ session

require_once '../admin/connect.php';

// Lấy maKhachHang từ bảng khachhang dựa vào tên tài khoản
$sql_get_maKhachHang = "SELECT khachhang.maKhachHang FROM khachhang 
                        INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                        WHERE tenTaiKhoan = '$username'";
$result_maKhachHang = mysqli_query($conn, $sql_get_maKhachHang);

if (mysqli_num_rows($result_maKhachHang) > 0) {
    $row_maKhachHang = mysqli_fetch_assoc($result_maKhachHang);
    $maKhachHang = $row_maKhachHang['maKhachHang'];
    
    // Lấy thông tin sản phẩm trong giỏ hàng của khách hàng từ bảng giohang
    $sql_wishlist = "SELECT * FROM sanphamyeuthich INNER JOIN sanpham on sanpham.maSanPham = sanphamyeuthich.maSanPham WHERE sanphamyeuthich.maKhachHang = '$maKhachHang'";
    $result_wishlist = mysqli_query($conn, $sql_wishlist);
    $wishlist = [];

    if (mysqli_num_rows($result_wishlist) > 0) {
        while ($row = mysqli_fetch_assoc($result_wishlist)) {
            $wishlist[] = $row;
        }
    }
} else {
    die("Không tìm thấy thông tin khách hàng");
}

// Tính toán tổng tiền và số lượng sản phẩm trong giỏ hàng
$totalQuantity = 0;
$totalAmount = 0;
$totalWishlist = count($wishlist);
$_SESSION['totalWishlist'] = $totalWishlist;

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sản phẩm yêu thích</title>
    <link rel="stylesheet" href="../assets/style.css" />
    <link rel="stylesheet" href="../assets/reset.css" />
    <link rel="stylesheet" href="../assets/cuongstyle.css" />
    <link rel="stylesheet" href="../assets/cart.css?v=<?php echo time() ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>

    <?php include($_SERVER["DOCUMENT_ROOT"] . "/layout/header.php"); ?>
    <div class="main__layout__account main__layout__account_cart">
    <h1 style="font-size: 25px; text-align: center; color: black">SẢN PHẨM YÊU THÍCH</h1>
        <div class="main__layout__container main__layout__container__2 ">
          
            <div class="card card-left card-left-cart" style="width: 65%; height: 100%">
                <!-- Thông tin giỏ hàng -->
                <div class="cart">
                    <?php if (!empty($wishlist)) : ?>
                        <?php foreach ($wishlist as $item) : ?>
                            <div class="cart-item">
                                <a href="<?php echo $item['chitietsp']; ?>"><img src="<?php echo '/admin/dashboard/products/'.$item['duongDanAnhChung']; ?>" alt="img <?php echo $item['tenSanPham']; ?>"></a>
                                
                                <div class="item-details">
                                    <h2><?php echo $item['tenSanPham']; ?></h2>
                                    <p>Giá: <?php echo number_format($item['giaBan'], 0, ',', '.'); ?> VND</p>
                                   
                                    <form action="deletewishlist.php" method="get" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi sản phẩm yêu thích?');">
                                        <input type="hidden" name="maKhachHang" value="<?php echo $item['maKhachHang']; ?>">
                                        <input type="hidden" name="maSanPham" value="<?php echo $item['maSanPham']; ?>">
                                        <button type="submit" class="remove-btn">Xóa</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Sản phẩm yêu thích của bạn đang trống.</p>
                    <?php endif; ?>
                </div>
            </div>


            <!-- <div class="card card-right" style="width: 35%;">
                <form class="total" method="POST">
                    <div class="cart-detail">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <h2>Thông tin giỏ hàng</h2>
                    </div>
                    <h3>Tạm tính (<?php echo $totalProducts; ?> sản phẩm)</h3>
                    <h3>Tổng thanh toán: <?php echo number_format($totalAmount, 0, ',', '.'); ?> VND</h3>
                    <button class="checkout-btn" name="checkout-btn" id="checkout-btn">Đặt hàng</button>
                </form>
            </div> -->
        </div>
    </div>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/collections/includes/footer.php"); ?>
</body>

</html>
