<?php
session_start();
$username = $_SESSION["username"]; 
require_once '../admin/connect.php';
$maDonHang = isset($_GET['maDonHang']) ? $_GET['maDonHang'] : '';
// Cập nhật tình trạng đơn hàng thành 6 (Đã hủy)
$sql = "UPDATE donhang SET tinhTrang = 6 WHERE maDonHang = '$maDonHang'";
if (mysqli_query($conn, $sql)) {  
    echo "<script>alert('Hủy đơn hàng thành công!');";
    echo "window.location.href = 'orderdetail.php?maDonHang=$maDonHang';";
    echo "</script>";
} else {  
    echo "Lỗi khi hủy đơn hàng: " . mysqli_error($conn);
}
exit();
?>