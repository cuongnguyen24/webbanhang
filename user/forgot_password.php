<?php
session_start();
require_once '../admin/connect.php';
if (isset($_POST["changepass_otp"])) {
    $email = $_POST["email_lg"];
    $newpassword = mt_rand(100000, 999999);
    // Tạo mã password ngẫu nhiên    
    // Lưu mã password mới vào session    
    $_SESSION["newpassword"] = $newpassword;
    $_SESSION["email"] = $email;
    // Gửi email chứa mã OTP    

    if (sendNewPass($email, $newpassword)) {
        // Nếu gửi email thành công, cập nhật mật khẩu trong cơ sở dữ liệu
        $sql = "UPDATE taikhoan tk
                JOIN khachhang kh ON tk.maTaiKhoan = kh.maTaiKhoan
                SET tk.matkhau = '$newpassword'
                WHERE kh.email = '$email'";
        $stmt = mysqli_prepare($conn, $sql);
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>            
                alert("Mật khẩu mới đã được gửi đến email của bạn.");            
                window.location.href = "../index.php";        
            </script>';
        }else{
            echo '<script>            
                alert("Gửi email thất bại. Vui lòng thử lại.");        
            </script>';
        }
        mysqli_stmt_close($stmt);
    }else {
        echo '<script>
            alert("Gửi email thất bại. Vui lòng thử lại.");
        </script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
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
                <div class="title_register">ĐẶT LẠI MẬT KHẨU</div>
            </div>
            <div class="main__layout_register_container_content">
                <form method="POST">
                    <div class="register_form">
                        <div class="register_form_group">
                            <label>Nhập email</label>
                            <input type="email" id="email_lg" name="email_lg">
                        </div>
                        <div class="register_form_group">
                            <button type="submit" name="changepass_otp" class="btn-primary-dangky">Gửi mật khẩu mới</button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>

</html>