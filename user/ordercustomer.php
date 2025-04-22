<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';

$sqlCustomer = "SELECT khachhang.hoTen, khachhang.email, khachhang.soDienThoai, khachhang.maDiaChi, khachhang.maKhachHang FROM taikhoan
                INNER JOIN khachhang ON taikhoan.maTaiKhoan = khachhang.maTaiKhoan WHERE taikhoan.tenTaiKhoan = '$username'";

$resultCustomer = mysqli_query($conn, $sqlCustomer);
if (mysqli_num_rows($resultCustomer) > 0) {
  while ($row = mysqli_fetch_assoc($resultCustomer)) {
    $name = $row["hoTen"];
    $makhach = $row["maKhachHang"];
  }
} else {
  echo "Không có kết quả";
}

// Xử lý truy vấn theo tham số GET
$action = isset($_GET['action']) ? $_GET['action'] : 'all';
$whereClause = "";

switch ($action) {
  case 'all':
    $whereClause = "";
    break;
  case 'processing':
    $whereClause = "AND donhang.tinhTrang = '1'";
    break;
  case 'shipped':
    $whereClause = "AND donhang.tinhTrang = '3'";
    break;
  case 'delivered':
    $whereClause = "AND donhang.tinhTrang = '4'";
    break;
  case 'cancelled':
    $whereClause = "AND donhang.tinhTrang = '6'";
    break;
}

$sqlOrders = "SELECT donhang.maDonHang, donhang.tinhTrang, donhang.tongGiaTri,
              (SELECT COUNT(*) FROM chitietdonhang WHERE chitietdonhang.maDonHang = donhang.maDonHang) AS tongSanPham
              FROM donhang 
              INNER JOIN khachhang ON donhang.maKhachHang = khachhang.maKhachHang
              INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
              WHERE taikhoan.tenTaiKhoan = '$username' $whereClause";

$resultOrders = mysqli_query($conn, $sqlOrders);



function getStatusText($status)
{
  switch ($status) {
    case '1':
      return 'Đang xử lý';
    case '2':
      return 'Chờ lấy hàng';
    case '3':
      return 'Đang vận chuyển';
    case '4':
      return 'Đã giao';
    case '5':
      return 'Giao thất bại';
    case '6':
      return 'Đã hủy';
    case '7':
      return 'Hàng hoàn';
    default:
      return 'Không xác định';
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đơn hàng của bạn</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <link rel="stylesheet" href="../assets/reset.css" />
  <link rel="stylesheet" href="../assets/cuongstyle.css" />
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
          <h5 class="card-title">Đơn hàng của bạn</h5>
          <div class="list-group list-group-horizontal list-group-full-width" style="justify-content: space-between;">
            <a href="?action=all" class="list-group-item list-group-item-action border-bottom-red">Tất cả</a>
            <a href="?action=processing" class="list-group-item list-group-item-action border-bottom-red">Đang xử lý</a>
            <a href="?action=shipped" class="list-group-item list-group-item-action border-bottom-red">Đang vận chuyển</a>
            <a href="?action=delivered" class="list-group-item list-group-item-action border-bottom-red">Đã giao</a>
            <a href="?action=cancelled" class="list-group-item list-group-item-action border-bottom-red">Đã hủy</a>
          </div>
          <div id="order-content">
            <!-- Nội dung đơn hàng sẽ được cập nhật ở đây -->
            <table>
              <thead>
                <tr>
                  <th>Mã đơn hàng</th>
                  <th>Tổng sản phẩm</th>
                  <th>Tổng giá trị</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (mysqli_num_rows($resultOrders) > 0) {
                  while ($row = mysqli_fetch_assoc($resultOrders)) {
                    $statusText = getStatusText($row["tinhTrang"]);
                    echo "<tr>";
                    echo "<td>" . $row["maDonHang"] . "</td>";
                    echo "<td>" . $row["tongSanPham"] . " sản phẩm</td>";
                    echo "<td>" . number_format($row["tongGiaTri"], 0, ',', '.') . " VND</td>";
                    echo "<td>" . $statusText . "</td>";
                    echo "<td><a href='orderdetail.php?maDonHang=" . $row["maDonHang"] . "' class='detail-link'>Chi tiết</a></td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='3'>Không có đơn hàng nào.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include '../layout/footer.php'; ?>

</body>

</html>