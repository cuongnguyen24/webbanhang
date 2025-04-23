<?php
$conn = mysqli_connect('192.168.1.208', 'myuserr', '12ssss21', 'myproject_db');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Thêm hàm gửi email OTP
function sendOTPEmail($email, $otp)
{
    // Cài đặt thư viện gửi email (ví dụ: PHPMailer)    
    require_once '../PHPMailer-master/src/PHPMailer.php';
    require_once '../PHPMailer-master/src/SMTP.php';
    require_once '../PHPMailer-master/src/Exception.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cuongngba7@gmail.com';
    $mail->Password = 'xkgu adii vaqr ghdp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('cuongngba7@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Ma OTP dang nhap NOUS cua ban';
    $mail->Body = '
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXiK5jVNGdbVj8VzZe2wPo9IDCyoF78V6JrA&s" alt="anh">
    <br>Nous xin chào!<br>
    Chào mừng bạn đã quay trở lại với Nous.<br>
    Hãy nhập OTP để quay lại mua sắm nhé.<br>
    Mã OTP của bạn là: ' . $otp;
    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}

// Thêm hàm gửi new pass OTP
function sendNewPass($email, $newpassword)
{
    // Cài đặt thư viện gửi email (ví dụ: PHPMailer)    
    require_once '../PHPMailer-master/src/PHPMailer.php';
    require_once '../PHPMailer-master/src/SMTP.php';
    require_once '../PHPMailer-master/src/Exception.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cuongngba7@gmail.com';
    $mail->Password = 'xkgu adii vaqr ghdp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('cuongngba7@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Mat khau moi cua tai khoan NOUS';
    $mail->Body = '
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXiK5jVNGdbVj8VzZe2wPo9IDCyoF78V6JrA&s" alt="anh">
    <br>Nous xin chào!<br>
    Đây là mật khẩu mới cho tài khoản của bạn.<br>
    Hãy nhập mật khẩu mới này để quay lại mua sắm nhé.<br>
    Mật khẩu mới của bạn là: ' . $newpassword;
    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}
