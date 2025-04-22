<?php
    include_once("../../connect.php");
    $maKhuyenMai =  $_GET['smkm'];
    // Bắt đầu giao dịch
    mysqli_begin_transaction($conn);
    try {
        // Truy vấn xóa từ bảng nhanvien
        $delete_sql_nhanvien = "DELETE FROM khuyenmai WHERE maKhuyenMai = '$maKhuyenMai'";
        mysqli_query($conn, $delete_sql_nhanvien);
        // Commit nếu không có lỗi
        mysqli_commit($conn);
        echo "<script>
        alert('Xóa thành công');
        window.location.href = '/admin/dashboard/promotion/index.php';
        </script>";
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        mysqli_rollback($con);
        echo "<script>alert('Xóa thất bại'); history.back();</script>";
    }
?>
