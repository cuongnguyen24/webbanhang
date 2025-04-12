<?php
session_start();

// Chức năng Đăng xuất đơn giản là xóa giá trị của người dùng đã đăng nhập trong SESSION
// Và điều hướng người dùng về trang chúng ta mong muốn

// Nếu trong SESSION có giá trị của key 'email_logged' <-> người dùng đã đăng nhập thành công
// Điều hướng người dùng về trang DASHBOARD
if(isset($_SESSION["loged"])) {
    unset($_SESSION["loged"]);
    unset($_SESSION["role"]);
    unset($_SESSION["username"]);
    echo '<script>
                        alert("Đăng xuất thành công");
                        window.location.href = "../index.php";
                    </script>';
}
else {
    echo 'Người dùng chưa đăng nhập. Không thể đăng xuất dược!'; die;
}
?>