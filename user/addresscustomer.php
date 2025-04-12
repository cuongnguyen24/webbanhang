<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Địa chỉ của tôi</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <link rel="stylesheet" href="../assets/reset.css" />
  <link rel="stylesheet" href="../assets/cuongstyle.css?v=<?php echo time() ?>" />
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
            $sql = "SELECT khachhang.hoTen, khachhang.email, khachhang.soDienThoai, khachhang.maDiaChi, khachhang.maKhachHang FROM taikhoan
            INNER JOIN khachhang ON taikhoan.maTaiKhoan = khachhang.maTaiKhoan WHERE taikhoan.tenTaiKhoan = '$username'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $name = $row["hoTen"];
                $diachi = $row["maDiaChi"];
                $makhach = $row["maKhachHang"];
              }
            } else {
              echo "Không có kết quả";
            }

            $sql1 = "SELECT diachi.tenDiaChi, diachi.tinhTrang, diachi.maDiaChi FROM khachhang 
                INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                INNER JOIN diachi ON khachhang.maKhachHang = diachi.maKhachHang
                WHERE taikhoan.tenTaiKhoan = '$username';
                ";
             $result = mysqli_query($conn, $sql1);

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
            <p><a class="link-opacity-100 text-body-secondary" href="#">Địa chỉ giao hàng</a></p>
          </li>
          <hr>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./logout.php">Đăng Xuất</a></p>
          </li>
        </ul>
      </div>

      <div class="card card-right card-right-customer" style="width: 70%;">
        <div class="card-body">
          <h5 class="card-title">Địa chỉ của tôi</h5>
          <?php
          if (mysqli_num_rows($result) > 0) {
            echo '
                <table>
                  <thead>
                    <th></th>
                    <th></th>
                  </thead>
                ';
            while ($row = mysqli_fetch_assoc($result)) {
              echo '
                    <tbody>
                      <tr>
                        <td>' . $row['tenDiaChi'] . '</td>
                        <td>' . ($row['tinhTrang'] == 1 ? '<div class="default-address">Mặc định</div>' : '') . '</td>
                        <td>
                          <a href="./editaddress.php?maDiaChi=' . $row["maDiaChi"] . '">Sửa</a>
                          <a onclick = "return confirm(\'Bạn có muốn xóa\');" href="./deleteaddresscustomer.php?maDiaChi=' . $row["maDiaChi"] . '">Xóa</a>
                        </td>
                      </tr>
                    </tbody>
                  ';
            }
            echo '</table>';
          } else {
            echo 'Không có địa chỉ !!!<br>';
          }
          ?>
          <a href="./addnewaddress.php" style="margin: 0 auto;">Thêm địa chỉ mới</a>
        </div>
      </div>
    </div>
  </div>
  <?php
  include '../layout/footer.php';
  mysqli_close($conn);
  ?>
</body>

</html>