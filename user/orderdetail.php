<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';

// Lấy mã đơn hàng từ tham số GET
$maDonHang = isset($_GET['maDonHang']) ? $_GET['maDonHang'] : '';

$sqlCustomer = "SELECT khachhang.hoTen, khachhang.email, khachhang.soDienThoai, diachi.tenDiaChi, khachhang.maKhachHang 
                FROM taikhoan
                INNER JOIN khachhang ON taikhoan.maTaiKhoan = khachhang.maTaiKhoan
                INNER JOIN diachi ON khachhang.maKhachHang = diachi.maKhachHang
                WHERE taikhoan.tenTaiKhoan = '$username'";

$resultCustomer = mysqli_query($conn, $sqlCustomer);
if (mysqli_num_rows($resultCustomer) > 0) {
  while ($row = mysqli_fetch_assoc($resultCustomer)) {
    $name = $row["hoTen"];
    $makhach = $row["maKhachHang"];
    $sdtKhachHang = $row["soDienThoai"];
  }
} else {
  echo "Không có kết quả";
}

// Lấy tổng giá trị và địa chỉ đơn hàng do khách đặt
$sqlOrders = "SELECT donhang.diaChiKhachHang, donhang.tongGiaTri, donhang.tinhTrang
                FROM donhang
                INNER JOIN khachhang ON donhang.maKhachHang = khachhang.maKhachHang
                INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                INNER JOIN diachi ON khachhang.maKhachHang = diachi.maKhachHang
                WHERE taikhoan.tenTaiKhoan = '$username' AND donhang.maDonHang = '$maDonHang'";

$resultOrders = mysqli_query($conn, $sqlOrders);
if (mysqli_num_rows($resultOrders) > 0) {
  while ($row = mysqli_fetch_assoc($resultOrders)) {
    $diaChi = $row["diaChiKhachHang"];
    $tongGiaTri = $row["tongGiaTri"];
    $tinhTrang = $row["tinhTrang"];
  }
} else {
  echo "Không có kết quả";
}

//Lấy chi tiết sản phẩm của đơn hàng
$sqlOrdersDetail = "SELECT sanpham.duongDanAnhChung, sanpham.TenSanPham, sanpham.chitietsp, chitietdonhang.soLuong, chitietdonhang.maSize, chitietdonhang.thanhTien
                FROM donhang
                INNER JOIN chitietdonhang ON donhang.maDonHang = chitietdonhang.maDonHang
                INNER JOIN sanpham ON chitietdonhang.maSanPham = sanpham.maSanPham
                INNER JOIN khachhang ON donhang.maKhachHang = khachhang.maKhachHang
                INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                WHERE taikhoan.tenTaiKhoan = '$username' AND donhang.maDonHang = '$maDonHang'";

$resultOrdersDetail = mysqli_query($conn, $sqlOrdersDetail);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thông tin đơn hàng</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <link rel="stylesheet" href="../assets/reset.css" />
  <link rel="stylesheet" href="../assets/cuongstyle.css?v=<?php echo time() ?>" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>
  <?php include '../layout/header.php'; ?>

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
            <p><a class="link-opacity-100 text-body-secondary" href="">Đơn hàng</a></p>
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

      <div class="card card-right card-right-customer" style="width: 70%;">
        <div class="card-body">
          <h5 class="card-title">Thông tin đơn hàng</h5>
          <div>
            <p>Địa chỉ nhận hàng:<br>
              <?php echo "$name"; ?> - <?php echo "$sdtKhachHang"; ?><br>
              <?php echo "$diaChi"; ?>
            </p>

          </div>
          <div id="order-content">
            <!-- Nội dung đơn hàng sẽ được cập nhật ở đây -->
            <table>
              <thead>
                <tr>
                  <th>Ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Số Lượng</th>
                  <th>Size</th>
                  <th>Giá</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (mysqli_num_rows($resultOrdersDetail) > 0) {
                  while ($row = mysqli_fetch_assoc($resultOrdersDetail)) {
                    echo "<tr>";
                    echo "<td><a href='" . $row["chitietsp"] . "'><img src='/admin/dashboard/products/" . $row["duongDanAnhChung"] . "' alt='Product Image' style='width: 70px; height: 70px;'></a></td>";
                    echo "<td><a href='" . $row["chitietsp"] . "' style='color: black;'>" . $row["TenSanPham"] . "</a></td>";
                    echo "<td>" . $row["soLuong"] . "</td>";
                    echo "<td>" . $row["maSize"] . "</td>";
                    echo "<td>" . number_format($row["thanhTien"], 0, ',', '.') . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='5'>Không có sản phẩm nào.</td></tr>";
                }
                ?>
                <p>Tổng giá trị: <?php echo number_format($tongGiaTri, 0, ',', '.'); ?> VNĐ</p>
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <button class="btn btn-primary" onclick="window.location.href='./ordercustomer.php'">Quay lại</button>
          <?php if ($tinhTrang == 1) { ?>
            <button class="btn btn-danger" onclick="cancelOrder('<?php echo $maDonHang; ?>')">Hủy đơn</button>
          <?php } else { ?>
            <button class="btn btn-danger" disabled>Hủy đơn</button>
          <?php } ?>
        </div>
      </div>
    </div>

    <?php include '../layout/footer.php'; ?>

    <script>
      function cancelOrder(maDonHang) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
          window.location.href = './cancelorder.php?maDonHang=' + maDonHang;
        }
      }
    </script>
</body>

</html>
