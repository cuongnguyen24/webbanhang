<?php
session_start();
require_once '../admin/connect.php';
if (isset($_POST["dangnhap_otp"])) {
    $email = $_POST["email_lg"];
    $otp = mt_rand(100000, 999999);
    // Tạo mã OTP ngẫu nhiên    
    // Lưu mã OTP và email vào session    
    $_SESSION["otp"] = $otp;
    $_SESSION["email"] = $email;
    // Gửi email chứa mã OTP    

    if (sendOTPEmail($email, $otp)) {
        echo '<script>            
    alert("Mã OTP đã được gửi đến email của bạn.");            
    window.location.href = "./login_otp.php";        
    </script>';
    } else {
        echo '<script>            
    alert("Gửi email thất bại. Vui lòng thử lại.");        
    </script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = $_POST["otp_input"];

    if (isset($_SESSION["otp"]) && isset($_SESSION["email"])) {
        $otp = $_SESSION["otp"];
        $email = $_SESSION["email"];

        if ($otp_input == $_SESSION['otp']) {
            // Đăng nhập thành công
            $sql = "SELECT tk.*, pq.tenPhanQuyen, kh.email 
                    FROM taikhoan tk
                    JOIN phanquyen pq ON tk.maPhanQuyen = pq.maPhanQuyen
                    JOIN khachhang kh ON tk.maTaiKhoan = kh.maTaiKhoan
                    WHERE kh.email = '$email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION["loged"] = true;
                $_SESSION["username"] = $row["tenTaiKhoan"];
                $role = $row["maPhanQuyen"];
                $_SESSION["role"] = $role;

                // Lưu session giỏ hàng
                // $maKhachHang = getMaKhachHang($conn, $row["tenTaiKhoan"]);
                // if ($maKhachHang) {
                //     $sql_cart = "SELECT COUNT(*) AS totalProducts FROM giohang WHERE maKhachHang = '$maKhachHang'";
                //     $result_cart = mysqli_query($conn, $sql_cart);
                //     if ($result_cart && mysqli_num_rows($result_cart) > 0) {
                //         $row_cart = mysqli_fetch_assoc($result_cart);
                //         $_SESSION['totalProducts'] = $row_cart['totalProducts'];
                //     }
                // }

                if ($role == 1) {
                    echo '<script>
                        alert("Đăng nhập thành công");
                        window.location.href = "../admin/accountadmin.php";
                    </script>';
                } else if ($role == 3) {
                    echo '<script>
                        alert("Đăng nhập thành công");
                        window.location.href = "./accountcustomer.php";
                    </script>';
                } else if ($role == 2) {
                    echo '<script>
                        alert("Đăng nhập thành công");
                        window.location.href = "./accountstaff.php";
                    </script>';
                }
            } else {
                echo '<script>
                    alert("Đăng nhập không thành công. Vui lòng thử lại.");
                </script>';
            }
        } else {
            echo '<script>
                alert("Mã OTP không chính xác. Vui lòng thử lại.");
            </script>';
        }
    } else {
        echo '<script>
            alert("Không tìm thấy mã OTP. Vui lòng đăng nhập lại.");
            window.location.href = "./login.php";
        </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập với OTP</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/reset.css">
    <link rel="stylesheet" href="../assets/cuongstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>
    <?php include '../layout/header.php'; ?>

    <div class="main__layout_register">
        <div class="main__layout_register_container">
            <div class="main__layout_register_container_head">
                <div class="title_register">ĐĂNG NHẬP VỚI OTP</div>
            </div>
            <div class="main__layout_register_container_content">
                <form method="POST">
                    <div class="register_form">
                        <div class="register_form_group">
                            <label>Nhập email</label>
                            <input type="email" id="email_lg" name="email_lg">
                        </div>
                        <div class="register_form_group">
                            <button type="submit" name="dangnhap_otp" class="btn-primary-dangky">Gửi mã OTP</button>
                        </div>
                        <div class="register_form_group">
                            <label>Nhập mã OTP</label>
                            <input type="text" id="otp_input" name="otp_input">
                        </div>
                        <div class="register_form_group">
                            <button type="submit" class="btn-primary-dangky">XÁC NHẬN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>

</html>