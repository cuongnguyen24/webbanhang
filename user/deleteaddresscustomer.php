<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';
$maDiaChi = $_GET['maDiaChi'];
$sql = "DELETE  FROM diachi WHERE maDiaChi = '$maDiaChi'";
$result = mysqli_query($conn, $sql);
if ($result > 0) {
  echo '<script>
          alert("Xóa địa chỉ thành công");
          window.location.href = "./addresscustomer.php";
        </script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="./assets/style.css" />
  <link rel="stylesheet" href="./assets/reset.css" />
  <link rel="stylesheet" href="./assets/Cuongstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
</body>

</html>