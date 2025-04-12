<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
$role = $_SESSION["role"]; // lấy role từ session
require_once '../admin/connect.php';
if ($role == 1) {
  $sql = "SELECT quanly.hoTen FROM taikhoan
            INNER JOIN quanly ON taikhoan.maTaiKhoan = quanly.maTaiKhoan 
            WHERE taikhoan.tenTaiKhoan = '$username'";
} else if ($role == 3) {
  $sql = "SELECT khachhang.hoTen FROM taikhoan
            INNER JOIN khachhang ON taikhoan.maTaiKhoan = khachhang.maTaiKhoan 
            WHERE taikhoan.tenTaiKhoan = '$username'";
} else if ($role == 2) {
  $sql = "SELECT nhanvien.hoTen FROM taikhoan
            INNER JOIN nhanvien ON taikhoan.maTaiKhoan = nhanvien.maTaiKhoan 
            WHERE taikhoan.tenTaiKhoan = '$username'";
}

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $name = $row["hoTen"];
  }
} else {
  echo "Không có kết quả";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ form và gọi hàm lưu dữ liệu vào CSDL
  $oldPass = $_POST["oldPass"];
  $newPass = $_POST["newPass"];

  $sql1 = $conn->prepare("SELECT matKhau FROM taikhoan WHERE tenTaiKhoan = ?");
  $sql1->bind_param("s", $username);
  $sql1->execute();
  $result = $sql1->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pass = $row['matKhau'];
    if ($oldPass == $pass) {
      // Cập nhật mật khẩu mới vào cơ sở dữ liệu
      $sql = $conn->prepare("UPDATE taikhoan SET matKhau = ? WHERE tenTaiKhoan = ?");
      $sql->bind_param("ss", $newPass, $username);
      if ($sql->execute() === TRUE) {
        if ($role == 1) {
          echo '<script>
            alert("Đổi mật khẩu thành công");
            window.location.href = "../admin/accountadmin.php";
          </script>';
        } else if ($role == 3) {
          echo '<script>
            alert("Đổi mật khẩu thành công");
            window.location.href = "./accountcustomer.php";
          </script>';
        } else if ($role == 2) {
          echo '<script>
            alert("Đổi mật khẩu thành công");
            window.location.href = "./accountstaff.php";
          </script>';
        }
        exit();
      } else {
        echo "Error: " . $sql->error;
      }
    } else {
      echo '<script>
        alert("Vui lòng nhập đúng mật khẩu cũ");
      </script>';
    }
  }
  $sql1->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đổi mật khẩu</title>
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
          <?php if ($role == 3) { ?>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="#">Đơn hàng</a></p>
          </li>
          <hr>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./addresscustomer.php">Địa chỉ giao hàng</a></p>
          </li>
          <hr>
          <?php } ?>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./logout.php">Đăng Xuất</a></p>
          </li>
        </ul>
      </div>

      <div class="card card-right" style="width: 70%;">
        <div class="card-body">
          <h5 class="card-title">Đổi mật khẩu</h5>
          <form id="changePasswordForm" method="POST">
            <div class="updateAccount_form_group">
              <label>Mật khẩu cũ</label>
              <input type="password" id="oldPass" name="oldPass">
              <span id="oldPassError" style="color: red;"></span>
            </div>
            <div class="updateAccount_form_group">
              <label>Mật khẩu mới</label>
              <input type="password" id="newPass" name="newPass">
              <span id="newPassError" style="color: red;"></span>
            </div>
            <div class="updateAccount_form_group">
              <button type="submit" class="btn-primary-update">Lưu</button>
          </form>
        </div>
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