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
    $mail->Subject = 'Mã OTP đăng nhập của bạn';
    $mail->Body = "Mã OTP của bạn là: $otp";
    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}
?>
