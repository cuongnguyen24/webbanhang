<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
$role = $_SESSION["role"]; // lấy role từ session
if ($role == 1) {
  $maQuanLy = $_GET['maQuanLy'];
} else if ($role == 3) {
  $maKhachHang = $_GET['maKhachHang'];
} else if ($role == 2) {
  $maNhanVien = $_GET['maNhanVien'];
}
$Name = "";
$Male = "";
$Bod = "";
require_once '../admin/connect.php';
if ($role == 1) {
  $sql = "SELECT * FROM quanly WHERE maQuanLy = '$maQuanLy'";
} else if ($role == 3) {
  $sql = "SELECT * FROM khachhang WHERE maKhachHang = '$maKhachHang'";
} else if ($role == 2) {
  $sql = "SELECT * FROM nhanvien WHERE maNhanVien = '$maNhanVien'";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $Name = $row['hoTen'];
    $Male = $row['gioiTinh'];
    $Bod = $row['ngaySinh'];
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ form và gọi hàm cập nhật dữ liệu vào CSDL
  $fullname = $_POST["fullNameUpdate"];
  $maleUpdate = $_POST['genderUpdate'];
  $dateInput = $_POST['birthday'];
  $convertedDate = date('Y-m-d', strtotime($dateInput));

  if ($role == 1) {
    $sql = "UPDATE quanly SET hoTen = '$fullname', gioiTinh = '$maleUpdate', ngaysinh = '$convertedDate' 
    WHERE maQuanLy = '$maQuanLy'";
  } else if ($role == 3) {
    $sql = "UPDATE khachhang SET hoTen = '$fullname', gioiTinh = '$maleUpdate', ngaysinh = '$convertedDate' 
    WHERE maKhachHang = '$maKhachHang'";
  } else if ($role == 2) {
    $sql = "UPDATE nhanvien SET hoTen = '$fullname', gioiTinh = '$maleUpdate', ngaysinh = '$convertedDate' 
    WHERE maNhanVien = '$maNhanVien'";
  }

  if ($conn->query($sql) === TRUE) {
    if ($role == 1) {
      echo '<script>
        alert("Cập nhật thông tin thành công");
        window.location.href = "../admin/accountadmin.php";
      </script>';
    } else if ($role == 3) {
      echo '<script>
        alert("Cập nhật thông tin thành công");
        window.location.href = "./accountcustomer.php";
      </script>';
    } else if ($role == 2) {
      echo '<script>
        alert("Cập nhật thông tin thành công");
        window.location.href = "./accountstaff.php";
      </script>';
    }
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cập nhật thông tin</title>
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
            <p><a class="link-opacity-100 text-body-secondary" href="#">Chỉnh sửa thông tin</a></p>
          </li>
          <hr>
          <?php if ($role == 3) { ?>
          <li class="list-group-item">
            <p><a class="link-opacity-100 text-body-secondary" href="./ordercustomer.php">Đơn hàng</a></p>
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
          <h5 class="card-title">Cập nhật thông tin cá nhân</h5>
          <form id="updateAccountForm" method="POST">
            <div class="updateAccount_form">
              <div class="updateAccount_form_group">
                <label>Họ và tên</label>
                <input type="text" id="fullNameUpdate" name="fullNameUpdate" value="<?php echo $Name ?>">
                <span id="fullNameUpdateError" style="color: red;"></span>
              </div>
              <div class="updateAccount_form_group">
                <label>Giới tính</label>
                <div class="row">
                  <div class="col">
                    <input type="radio" value="0" name="genderUpdate" <?php if ($Male === '0') echo 'checked'; ?>>
                    </label>Nữ</label>
                  </div>
                  <div class="col">
                    <div class="col">
                      <input type="radio" value="1" name="genderUpdate" <?php if ($Male === '1') echo 'checked'; ?>>
                      </label>Nam</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="updateAccount_form_group">
                <label>Ngày sinh</label>
                <input type="date" id="birthday" name="birthday" value="<?php echo $Bod; ?>">
                <span id="birthdayError" style="color: red;"></span>
              </div>
              <div class="updateAccount_form_group">
                <button type="submit" class="btn-primary-update">Cập nhật</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
  <?php
  include '../layout/footer.php';
  ?>
</body>

</html>