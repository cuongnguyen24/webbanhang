<?php
    include_once("../../connect.php");
    $maNhanVien =  $_GET['smnv'];
    $maTaiKhoan =  $_GET['smtaikhoan'];
    // Bắt đầu giao dịch
    mysqli_begin_transaction($conn);

    try {
        // Truy vấn xóa từ bảng nhanvien
        $delete_sql_nhanvien = "DELETE FROM nhanvien WHERE maNhanVien = '$maNhanVien'";
        mysqli_query($conn, $delete_sql_nhanvien);

        // Truy vấn xóa từ bảng taikhoan
        $delete_sql_taikhoan = "DELETE FROM taikhoan WHERE maTaiKhoan = '$maTaiKhoan'";
        mysqli_query($conn, $delete_sql_taikhoan);

        // Commit nếu không có lỗi
        mysqli_commit($conn);
        echo "<script>
        alert('Xóa thành công');
        window.location.href = '/admin/dashboard/staff/index.php';
        </script>";
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        mysqli_rollback($con);
        echo "<script>alert('Xóa thất bại'); history.back();</script>";
    }
?>
