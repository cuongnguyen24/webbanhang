<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';

// Lấy maKhachHang từ bảng khachhang dựa vào tên tài khoản
$sql_get_maKhachHang = "SELECT khachhang.maKhachHang FROM khachhang 
                        INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                        WHERE tenTaiKhoan = '$username'";
$result_maKhachHang = mysqli_query($conn, $sql_get_maKhachHang);

if (mysqli_num_rows($result_maKhachHang) > 0) {
    $row = mysqli_fetch_assoc($result_maKhachHang);
    $maKhachHang = $row['maKhachHang'];
} else {
    die("Không tìm thấy thông tin khách hàng");
}

// Xử lý xóa sản phẩm khỏi giỏ hàng khi nhận request từ cart.php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['maKhachHang']) && isset($_GET['maSanPham'])) {
    $maKhachHang = $_GET['maKhachHang'];
    $maSanPham = $_GET['maSanPham'];

    // Xóa sản phẩm khỏi giỏ hàng
    $sql_delete = "DELETE FROM sanphamyeuthich WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$maSanPham'";
    $result_delete = mysqli_query($conn, $sql_delete);

    if ($result_delete) {
        echo '<script>
                alert("Xóa sản phẩm khỏi sản phẩm yêu thích thành công!");
                window.location.href = "./wishlist.php";
              </script>';
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Xóa Sản Phẩm Khỏi Giỏ Hàng</title>
    <link rel="stylesheet" href="./assets/style.css" />
    <link rel="stylesheet" href="./assets/reset.css" />
    <link rel="stylesheet" href="./assets/Cuongstyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
</body>

</html>
