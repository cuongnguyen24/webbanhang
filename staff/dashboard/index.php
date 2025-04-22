<?php
session_start();
$username = $_SESSION["username"];
require_once '../connect.php';
//Lấy thông tin staff
$sql = "SELECT nhanvien.hoTen FROM taikhoan
        INNER JOIN nhanvien ON taikhoan.maTaiKhoan = nhanvien.maTaiKhoan 
        WHERE taikhoan.tenTaiKhoan = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row["hoTen"];
    }
} else {
    echo "Không có kết quả";
}

// Lấy tổng đơn hàng trong tháng
$sql = "SELECT COUNT(*) as totalOrders 
        FROM donhang 
        WHERE MONTH(ngayLapDon) = MONTH(CURDATE()) 
        AND YEAR(ngayLapDon) = YEAR(CURDATE())";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $soLuongDon = $row['totalOrders'];
}

// Lấy tổng đơn hàng trong tháng trước
$sql = "SELECT COUNT(*) as totalOrders 
        FROM donhang 
        WHERE MONTH(ngayLapDon) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
        AND YEAR(ngayLapDon) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $soLuongDonThangTruoc = $row['totalOrders'];
} else {
    $soLuongDonThangTruoc = 0;
}

// Tính phần trăm thay đổi của tổng đơn hàng trong tháng
if ($soLuongDonThangTruoc > 0) {
    $phanTramDonHang = (($soLuongDon - $soLuongDonThangTruoc) / $soLuongDonThangTruoc) * 100;
} else {
    $phanTramDonHang = $soLuongDon > 0 ? 100 : 0; // Nếu tháng trước không có đơn nào, phần trăm thay đổi là 100% hoặc 0%
}
$phanTramTongDonHangTrongThang = number_format($phanTramDonHang, 0);

// Lấy tổng doanh thu trong tháng
$sql_doanhthu = "SELECT SUM(tongGiaTri) as tongDoanhThu
    FROM donhang 
    WHERE MONTH(ngayLapDon) = MONTH(CURDATE()) AND YEAR(ngayLapDon) = YEAR(CURDATE())";
$result = mysqli_query($conn, $sql_doanhthu);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $tongDoanhThu = $row['tongDoanhThu'];
}

// Lấy tổng doanh thu trong tháng trước
$sql_doanhthu_thangtruoc = "SELECT SUM(tongGiaTri) as tongDoanhThu 
                            FROM donhang 
                            WHERE MONTH(ngayLapDon) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                            AND YEAR(ngayLapDon) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
$result = mysqli_query($conn, $sql_doanhthu_thangtruoc);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $tongDoanhThuThangTruoc = $row['tongDoanhThu'];
} else {
    $tongDoanhThuThangTruoc = 0;
}

// Tính phần trăm thay đổi của tổng doanh thu giữa hai tháng
if ($tongDoanhThuThangTruoc > 0) {
    $phanTramDoanhThu = (($tongDoanhThu - $tongDoanhThuThangTruoc) / $tongDoanhThuThangTruoc) * 100;
} else {
    $phanTramDoanhThu = $tongDoanhThu > 0 ? 100 : 0; // Nếu tháng trước không có doanh thu, phần trăm thay đổi là 100% hoặc 0%
}
$phanTramTongDoanhThu = number_format($phanTramDoanhThu, 0);

// Lấy tổng sản phẩm đã bán trong tháng
$sql = "SELECT SUM(chitietdonhang.soLuong) as tongSpDaBanTrongThang
        FROM donhang
        INNER JOIN chitietdonhang ON donhang.maDonHang = chitietdonhang.maDonHang
        WHERE donhang.tinhTrang NOT IN (1, 5, 6, 7) 
        AND MONTH(ngayLapDon) = MONTH(CURDATE()) 
        AND YEAR(ngayLapDon) = YEAR(CURDATE())
        ";
$result_tongSpDaBanTrongThang = mysqli_query($conn, $sql);
if ($result_tongSpDaBanTrongThang) {
    $row = mysqli_fetch_assoc($result_tongSpDaBanTrongThang);
    $tongSpDaBanTrongThang = $row['tongSpDaBanTrongThang'];
}

// Lấy tổng sản phẩm đã bán trong tháng trước
$sql = "SELECT SUM(chitietdonhang.soLuong) as tongSpDaBanTrongThangTruoc
        FROM donhang
        INNER JOIN chitietdonhang ON donhang.maDonHang = chitietdonhang.maDonHang
        WHERE donhang.tinhTrang NOT IN (1, 5, 6, 7) 
        AND MONTH(ngayLapDon) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
        AND YEAR(ngayLapDon) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
        ";
$result_tongSpDaBanTrongThangTruoc = mysqli_query($conn, $sql);
if ($result_tongSpDaBanTrongThangTruoc) {
    $row = mysqli_fetch_assoc($result_tongSpDaBanTrongThangTruoc);
    $tongSpDaBanTrongThangTruoc = $row['tongSpDaBanTrongThangTruoc'];
}

// Tính phần trăm thay đổi của tổng sản phẩm đã bán giữa hai tháng
if ($tongSpDaBanTrongThangTruoc > 0) {
    $phanTramSanPhamDaBan = (($tongSpDaBanTrongThang - $tongSpDaBanTrongThangTruoc) / $tongSpDaBanTrongThangTruoc) * 100;
} else {
    $phanTramSanPhamDaBan = $tongSpDaBanTrongThang > 0 ? 100 : 0; // Nếu tháng trước không có doanh thu, phần trăm thay đổi là 100% hoặc 0%
}
$phanTramSanPhamDaBan = number_format($phanTramSanPhamDaBan, 0);

// Lấy tổng đơn trong ngày
$sql = "SELECT COUNT(*) as totalOrdersDay 
        FROM donhang 
        WHERE DATE(ngayLapDon) = CURDATE()";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $soLuongDonTrongNgay = $row['totalOrdersDay'];
}

// Lấy tổng đơn hàng trong ngày trước ngày hiện tại
$sql = "SELECT COUNT(*) as soLuongDonTruocNgayHienTai 
        FROM donhang 
        WHERE DATE(ngayLapDon) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $soLuongDonTruocNgayHienTai = $row['soLuongDonTruocNgayHienTai'];
}

// Tính phần trăm thay đổi của tổng đơn hàng trong ngày
if ($soLuongDonTruocNgayHienTai > 0) {
    $phanTramDonHang = (($soLuongDonTrongNgay - $soLuongDonTruocNgayHienTai) / $soLuongDonTruocNgayHienTai) * 100;
} else {
    $phanTramDonHang = $soLuongDonTrongNgay > 0 ? 100 : 0; // Nếu ngày hôm qua không có đơn nào, phần trăm thay đổi là 100% hoặc 0%
}
$phanTramTongDonHangTrongNgay = number_format($phanTramDonHang, 2);


// Lấy tổng đơn đã gửi trong ngày
$sql = "SELECT COUNT(*) as soLuongDonGuiTrongNgay 
        FROM donhang 
        WHERE tinhTrang = 2 AND DATE(ngayLapDon) = CURDATE()";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $soLuongDonGuiTrongNgay = $row['soLuongDonGuiTrongNgay'];
}

// Lấy tổng đơn đã gửi trong ngày hôm qua
$sql_yesterday = "SELECT COUNT(*) as soLuongDonGuiTruocNgay 
                FROM donhang 
                WHERE tinhTrang = 2 AND DATE(ngayLapDon) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
$result_yesterday = mysqli_query($conn, $sql_yesterday);
if ($result_yesterday) {
    $row_yesterday = mysqli_fetch_assoc($result_yesterday);
    $soLuongDonGuiTruocNgay = $row_yesterday['soLuongDonGuiTruocNgay'];
}

// Tính phần trăm thay đổi đơn hàng đã gửi
if ($soLuongDonGuiTruocNgay > 0) {
    $phanTramDaGui = (($soLuongDonGuiTrongNgay - $soLuongDonGuiTruocNgay) / $soLuongDonGuiTruocNgay) * 100;
} else {
    $phanTramDaGui = $soLuongDonGuiTrongNgay > 0 ? 100 : 0; // Nếu ngày hôm qua không có đơn nào, phần trăm thay đổi là 100% hoặc 0%
}
$phanTramDaGuiTrongNgay = number_format($phanTramDaGui, 2);


// Lấy tổng đơn chờ duyệt
$sql = "SELECT COUNT(*) as soLuongDonChoDuyet 
        FROM donhang 
        WHERE tinhTrang = 1 ";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $soLuongDonChoDuyet = $row['soLuongDonChoDuyet'];
}

// Lấy tổng sp đã bán lấy theo tình trạng đã duyệt = 2, liên quan đến chi tiết đơn hàng
$sql =
    "WITH soLuongBan AS (
    SELECT sanpham.maSanPham, sanpham.tenSanPham, SUM(chitietdonhang.soLuong) AS soLuongSPDaBan
    FROM donhang
    INNER JOIN chitietdonhang ON donhang.maDonHang = chitietdonhang.maDonHang
    INNER JOIN sanpham ON chitietdonhang.maSanPham = sanpham.maSanPham
    WHERE donhang.tinhTrang NOT IN (1, 5, 6, 7)
    GROUP BY sanpham.maSanPham, sanpham.tenSanPham
    ORDER BY soLuongSPDaBan DESC
    LIMIT 5
),
tongSoLuong AS (
    SELECT maSanPham, SUM(soLuong) AS tongSoLuong
    FROM sizesanpham
    GROUP BY maSanPham
)
SELECT
    soLuongBan.maSanPham,
    soLuongBan.tenSanPham,
    soLuongBan.soLuongSPDaBan,
    tongSoLuong.tongSoLuong - soLuongBan.soLuongSPDaBan AS soLuongTonKho
FROM soLuongBan
INNER JOIN tongSoLuong ON soLuongBan.maSanPham = tongSoLuong.maSanPham
ORDER BY soLuongBan.soLuongSPDaBan DESC
";
$result_topSP = mysqli_query($conn, $sql);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/" alt="">
                    <h2>NOUS<span> STAFF</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="sidebar">
                <a href="#" class="active">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>
               
                <a href="./order/" class="">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h3>Đơn hàng</h3>
                </a>

                <a href="/staff/accountstaff.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>

        <!-- ---------------------END OF ASIDE---------------- -->
        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>

            <div class="insights">
                <div class="sale">
                    <i class="fa-solid fa-chart-bar"></i>
                    <div class="middle">
                        <div class="left">
                            <h3>Tổng doanh thu</h3>
                            <h1><?php echo "$tongDoanhThu"; ?> VND</h1>
                        </div>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>

                        </svg>
                        <div class="number">
                            <p><?php echo "$phanTramTongDoanhThu"; ?> %</p>
                        </div>
                    </div>
                    <small class="text-muted">Trong tháng này</small>
                </div>
                <!-- ----------------END OF SALES--------------- -->
                

                <div class="expensive">
                    <i class="fa-solid fa-chart-line"></i>
                    <div class="middle">
                        <div class="left">
                            <h3>Tổng số đơn hàng</h3>
                            <h1><?php echo "$soLuongDon"; ?></h1>
                        </div>

                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                        </svg>
                        <div class="number">
                            <p><?php echo "$phanTramTongDonHangTrongThang"; ?> %</p>
                        </div>
                    </div>
                    <small class="text-muted">Trong tháng này</small>
                </div>
                <!-- ----------------END OF EXPENSIVE--------------- -->
                <div class="income">
                    <i class="fa-solid fa-chart-area"></i>
                    <div class="middle">
                        <div class="left">
                            <h3>Tổng sản phẩm đã bán</h3>
                            <h1><?php echo "$tongSpDaBanTrongThang"; ?></h1>
                        </div>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                        </svg>
                        <div class="number">
                            <p><?php echo "$phanTramSanPhamDaBan"; ?> %</p>
                        </div>
                    </div>
                    <small class="text-muted">Trong tháng này</small>
                </div>
                <!-- ----------------END OF INCOME--------------- -->

            </div>
            <!-- ------------------END OF INSIGHTS ------------- -->


            <div class="recent-order">
                <h2>Sản phẩm bán chạy</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Mã sản phẩm</th>
                            <th>Đã bán</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Duyệt qua các kết quả trả về    
                        if ($result_topSP) {
                            while ($row = mysqli_fetch_assoc($result_topSP)) {
                                $maSpBanChay = $row['maSanPham'];
                                $tenSpBanChay = $row['tenSanPham'];
                                $soLuongSpBanChay = $row['soLuongSPDaBan'];
                                $soLuongTonKho = $row['soLuongTonKho'];
                        ?>
                                <tr>
                                    <td><?php echo $tenSpBanChay; ?></td>
                                    <td><?php echo $maSpBanChay; ?></td>
                                    <td><?php echo $soLuongSpBanChay; ?></td>
                                    <td class="warning"><?php echo $soLuongTonKho; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!-- <a href="#">Show All</a> -->
            </div>
        </main>

        <!-- -------------------END OF MAIN --------------------- -->

        <div class="right">
            <div class="top">
                <button id="menu_btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <!-- <div class="theme-toggler">
                    <i class="fa-regular fa-sun active" id="lightModeToggle"></i>
                    <i class="fa-solid fa-moon" id="darkModeToggle"></i>
                </div> -->
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo "$name"; ?></b></p>
                        <small class="text-muted"> Staff</small>
                    </div>
                    <div class="profile-photo">
                        <img src="/assets/img/baby_homeAbout.webp" alt="">
                    </div>
                </div>
            </div>

            <!-- END OF TOP -->

            <div class="sales_analytics">
                <h2>Sales Analytics</h2>
                <a href="./order/">
                    <div class="item online">
                        <div class="icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div class="right">
                            <div class="info">
                                <h3>Tổng số đơn hàng</h3>
                                <small class="text-muted">Trong 24 giờ qua</small>
                            </div>
                            <h5 class="danger"><?php echo ($phanTramDonHang >= 0 ? '+' : '') . $phanTramTongDonHangTrongNgay . '%'; ?></h5>
                            <h3><?php echo "$soLuongDonTrongNgay"; ?></h3>
                        </div>
                    </div>
                </a>
                
                <a href="./order/">
                    <div class="item customers">
                        <div class="icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div class="right">
                            <div class="info">
                                <h3>Đơn hàng đã gửi</h3>
                                <small class="text-muted">Trong 24 giờ qua</small>
                            </div>
                            <h5 class="danger"><?php echo ($phanTramDaGui >= 0 ? '+' : '') . $phanTramDaGuiTrongNgay . '%'; ?></h5>
                            <h3><?php echo "$soLuongDonGuiTrongNgay"; ?></h3>
                        </div>
                    </div>
                </a>

                <a href="./order/">
                    <div class="item boom">
                        <div class="icon">
                            <i class="fa-solid fa-bomb"></i>
                        </div>
                        <div class="right">
                            <div class="info">
                                <h3>Đơn hàng chờ duyệt</h3>
                            </div>
                            <h3><?php echo "$soLuongDonChoDuyet"; ?></h3>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
    <script src="./index.js"></script>
</body>

</html>
