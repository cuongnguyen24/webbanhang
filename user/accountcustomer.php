<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
//echo "$username";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thông tin cá nhân</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <link rel="stylesheet" href="../assets/reset.css" />
  <link rel="stylesheet" href="../assets/cuongstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>
  <?php
  include '../layout/header.php';
  
  ?>

  <div class="main__layout__account">
    <div class="main__layout__container main__layout__container__2">
      <div class="card card-left" style="width: 30%; height: 100%">
        <div class="card-body">
          <h2 class="card-title">
            <div class="user-icon">
              <i class="fa-regular fa-user"></i>
            </div>
            <?php
            require_once '../admin/connect.php';
            $sql = "SELECT khachhang.hoTen, khachhang.email, khachhang.soDienThoai, khachhang.maDiaChi, khachhang.maKhachHang FROM taikhoan
            INNER JOIN khachhang ON taikhoan.maTaiKhoan = khachhang.maTaiKhoan WHERE taikhoan.tenTaiKhoan = '$username'";
            
            $sql2 = "SELECT diachi.tenDiaChi FROM khachhang 
            INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
            INNER JOIN diachi ON khachhang.maKhachHang = diachi.maKhachHang
            WHERE taikhoan.tenTaiKhoan = '$username' AND diachi.tinhTrang = 1;
            ";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $name = $row["hoTen"];
                $mail = $row["email"];
                $sdt = $row["soDienThoai"];
                $makhach = $row["maKhachHang"];
              }
            } else {
              echo "Không có kết quả";
            }
            
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
              while ($row = mysqli_fetch_assoc($result2)) {
                $diachi = $row["tenDiaChi"];
                
              }
            } else {
              $diachi = ""; // không có địa chỉ thì ko hiện gì
              echo "Không lay duoc dc";
            }
            ?>
            <?php echo $name; ?>
          </h2>
          <hr>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./accountcustomerupdate.php?maKhachHang=<?php echo $makhach; ?>">Chỉnh sửa thông tin</a></p>
          </li>
          <hr>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./ordercustomer.php">Đơn hàng</a></p>
          </li>
          <hr>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./addresscustomer.php">Địa chỉ giao hàng</a></p>
          </li>
          <hr>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./logout.php">Đăng Xuất</a></p>
          </li>
        </ul>
      </div>

      <div class="card card-right" style="width: 70%;">
        <div class="card-body">
          <h5 class="card-title">Thông tin tài khoản khách hàng</h5>
          <hr>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <p>Tên: <?php echo $name; ?><br>
                Email: <?php echo $mail; ?><br>
                Số điện thoại: <?php echo $sdt; ?></p>
            </li>
            <hr>
            <li class="list-group-item">
              <p>Địa chỉ: <?php echo $diachi; ?></p>
            </li>
          </ul>
          <a href="./changepassword.php" class="btn-changepass">Đổi mật khẩu</a>
        </div>
      </div>
    </div>

  </div>

  <?php
  include '../layout/footer.php';
  ?>

</body>

</html>
