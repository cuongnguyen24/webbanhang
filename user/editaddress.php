<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';
$maDiaChi = $_GET['maDiaChi'];
$diaChi = "";

$sql = "SELECT * FROM diachi WHERE maDiaChi = '$maDiaChi'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $diaChi = $row['tenDiaChi'];
  }
}

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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $editAdress = $_POST['editaddress'];
  $setDefault = isset($_POST['setDefault']) ? $_POST['setDefault'] : 0;

  $conn = mysqli_connect("localhost", "root", "", "webbanhang");

  if ($setDefault == 1) {
    // Đặt các địa chỉ khác thành ko mặc định
    $sqlUpdateOthers = "UPDATE diachi SET tinhTrang = 0 WHERE maKhachHang = '$makhach' AND maDiaChi != '$maDiaChi'";

    // Chuyển địa chỉ hiện tại thành mặc định
    $sqlUpdateMe = "UPDATE diachi SET tinhTrang = 1 WHERE maKhachHang = '$makhach' AND maDiaChi = '$maDiaChi'";
    $resultUpdateOthers = mysqli_query($conn, $sqlUpdateOthers);

    if (!$resultUpdateOthers) {
      mysqli_rollback($conn);
      echo '<script>
              alert("Lỗi khi cập nhật địa chỉ khác về tinhTrang = 0");
              window.location.href = "./addresscustomer.php";
              </script>';
      exit();
    }

    $resultUpdateMe = mysqli_query($conn, $sqlUpdateMe);
    if (!$sqlUpdateMe) {
      mysqli_rollback($conn);
      echo '<script>
              alert("Lỗi khi cập nhật địa chỉ hiện tại về tinhTrang = 1");
              window.location.href = "./addresscustomer.php";
              </script>';
      exit();
    }
  }

  if (!$conn) {
    echo "Ket noi khong thanh cong: " . mysqli_connect_error();
  } else {
    $sqlUpdateAddress = "UPDATE diachi SET tenDiaChi ='" . $editAdress . "' WHERE maDiaChi = '" . $maDiaChi . "' ";
    $resultUpdateAddress = mysqli_query($conn, $sqlUpdateAddress);
    if (!$resultUpdateAddress) {
      mysqli_rollback($conn);
      echo '<script>
          alert("Sửa địa chỉ thất bại");
          window.location.href = "./addresscustomer.php";
          </script>';
      exit();
    } else {
      echo '<script>
      alert("Sửa địa chỉ thành công");
      window.location.href = "./addresscustomer.php";
      </script>';
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sửa địa chỉ</title>
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
          <h5 class="card-title">Sửa địa chỉ</h5>
          <form id="changePasswordForm" method="POST">
            <div class="updateAccount_form_group">
              <label>Địa chỉ</label>
              <input type="text" id="editaddress" name="editaddress" value="<?php echo $diaChi ?>">
            </div>
            <label>
              <input type="checkbox" id="setDefault" name="setDefault" value="1"> Đặt làm địa chỉ mặc định
            </label>
            <div class="updateAccount_form_group">
              <button type="submit" class="btn-primary-update">Lưu</button>
          </form>
          <a href="./addresscustomer.php" style="margin: 0 auto;">Quay lại</a>
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