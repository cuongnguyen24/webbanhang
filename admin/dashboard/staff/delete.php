<?php
    include_once("connect_q.php");
    $maNhanVien =  $_GET['smnv'];
    $maTaiKhoan =  $_GET['smtaikhoan'];
    // Bắt đầu giao dịch
    mysqli_begin_transaction($con);

    try {
        // Truy vấn xóa từ bảng nhanvien
        $delete_sql_nhanvien = "DELETE FROM nhanvien WHERE maNhanVien = '$maNhanVien'";
        mysqli_query($con, $delete_sql_nhanvien);

        // Truy vấn xóa từ bảng taikhoan
        $delete_sql_taikhoan = "DELETE FROM taikhoan WHERE maTaiKhoan = '$maTaiKhoan'";
        mysqli_query($con, $delete_sql_taikhoan);

        // Commit nếu không có lỗi
        mysqli_commit($con);
        echo "<script>
        alert('Xóa thành công');
        window.location.href = '/webbanhang/admin/dashboard/staff/index.php';
        </script>";
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        mysqli_rollback($con);
        echo "<script>alert('Xóa thất bại'); history.back();</script>";
    }
?>