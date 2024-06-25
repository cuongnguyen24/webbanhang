<?php

$conn = mysqli_connect('localhost', 'root', '', 'webbanhang');
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
