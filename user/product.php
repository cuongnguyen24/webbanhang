<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';

// Lấy dữ liệu từ CSDL
// GROUP_CONCAT - kết hợp tất cả các kích cỡ (size) của mỗi sản phẩm thành một chuỗi, ngăn cách bởi dấu phẩy
//  ORDER BY size.tenSize sắp xếp các kích cỡ theo thứ tự tăng dần.
$sql = "SELECT sanpham.*, GROUP_CONCAT(size.tenSize ORDER BY size.tenSize SEPARATOR ', ') as sizes, anhSanPham.duongDanAnh 
        FROM sanpham
        INNER JOIN sizesanpham ON sanpham.maSanPham = sizesanpham.maSanPham
        INNER JOIN size ON sizesanpham.maSize = size.maSize
        INNER JOIN anhSanPham ON sanpham.maSanPham = anhSanPham.maSanPham
        GROUP BY sanpham.maSanPham, anhSanPham.duongDanAnh
";
$result = mysqli_query($conn, $sql);
$sanphams = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sanphams[] = $row;
    }
}

// Lấy maKhachHang theo bảng taikhoan dựa vào username
$sql_get_khachHang = "SELECT khachhang.maKhachHang FROM khachhang 
                    INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                    WHERE tenTaiKhoan = '$username'";
$result_maKhachHang = mysqli_query($conn, $sql_get_khachHang);
if (mysqli_num_rows($result_maKhachHang) > 0) {
    $row_maKhachHang = mysqli_fetch_assoc($result_maKhachHang); // Sửa tên biến từ $result_maKhachHang thành $row_maKhachHang
    $maKhachHang = $row_maKhachHang['maKhachHang'];
} else {
    // Xử lý khi không tìm thấy tên tài khoản (username) trong bảng taikhoan
    die("Không tìm thấy tên tài khoản trong CSDL");
}

// Xử lý gửi kết quả qua cart.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maSanPham = $_POST['maSanPham'];
    $tenSanPham = $_POST['tenSanPham'];
    $giaBan = $_POST['giaBan'];
    $duongDanAnh = $_POST['duongDanAnh'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
    $sql_check = "SELECT * FROM giohang WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$maSanPham' AND maSize = '$size'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
        $sql_update = "UPDATE giohang SET soLuong = soLuong + $quantity WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$maSanPham' AND maSize = '$size'";
        mysqli_query($conn, $sql_update);
    } else {
        // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
        $sql_insert = "INSERT INTO giohang (maKhachHang, maSanPham, maSize, soLuong) 
                      VALUES ('$maKhachHang', '$maSanPham', '$size', $quantity)";
        mysqli_query($conn, $sql_insert);
    }


    // Chuyển hướng về trang giỏ hàng
    header('Location: ./cart.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="../assets/style.css" />
    <link rel="stylesheet" href="../assets/reset.css" />
    <link rel="stylesheet" href="../assets/cuongstyle.css" />
    <link rel="stylesheet" href="../assets/cart.css?v=<?php echo time() ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include '../layout/header.php'; ?>
    <div class="main__layout__account main__layout__account_cart">
        <div class="main__layout__container main__layout__container__2 ">
            <div class="card card-left card-left-cart" style="width: 65%; height: 100%">
                <!-- Thông tin giỏ hàng -->
                <div class="cart">
                    <?php if (!empty($sanphams)) : ?>
                        <?php foreach ($sanphams as $sanpham) : ?>
                            <div class="cart-item">
                                <img src="<?php echo $sanpham['duongDanAnh']; ?>" alt="img <?php echo $sanpham['tenSanPham']; ?>">
                                <div class="item-details">
                                    <h2><?php echo $sanpham['tenSanPham']; ?></h2>
                                    <p>Giá: <?php echo number_format($sanpham['giaBan'], 0, ',', '.'); ?> VND</p>
                                    <form method="post">
                                        <input type="hidden" name="maSanPham" value="<?php echo $sanpham['maSanPham']; ?>">
                                        <input type="hidden" name="tenSanPham" value="<?php echo $sanpham['tenSanPham']; ?>">
                                        <input type="hidden" name="giaBan" value="<?php echo $sanpham['giaBan']; ?>">
                                        <input type="hidden" name="duongDanAnh" value="<?php echo $sanpham['duongDanAnh']; ?>">
                                        <div class="controls">
                                            <div class="size-controls">
                                                <label for="size_<?php echo $sanpham['maSanPham']; ?>">Kích cỡ:</label>
                                                <select id="size_<?php echo $sanpham['maSanPham']; ?>" name="size">
                                                    <?php
                                                    $sizes = explode(', ', $sanpham['sizes']);
                                                    foreach ($sizes as $size) {
                                                        echo "<option value=\"$size\">$size</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="quantity-controls">
                                            <label for="quantity_<?php echo $sanpham['maSanPham']; ?>">Số lượng:</label>
                                            <button type="button" class="quantity-btn" onclick="decrementQuantity('quantity_<?php echo $sanpham['maSanPham']; ?>')">-</button>
                                            <input type="number" id="quantity_<?php echo $sanpham['maSanPham']; ?>" name="quantity" value="1" min="1">
                                            <button type="button" class="quantity-btn" onclick="incrementQuantity('quantity_<?php echo $sanpham['maSanPham']; ?>')">+</button>
                                        </div>
                                        <button type="submit" class="addcart-btn">Thêm vào giỏ hàng</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Không có sản phẩm nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '../layout/footer.php'; ?>
    <script>
        function incrementQuantity(inputId) {
            const input = document.getElementById(inputId);
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(inputId) {
            const input = document.getElementById(inputId);
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
</body>

</html>