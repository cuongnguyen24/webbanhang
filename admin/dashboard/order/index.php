
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/" alt="">
                    <h2>NOUS<span> ADMIN</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="sidebar">
                <a href="../index.html" class="">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                <a href="../customer/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Khách hàng</h3>
                </a>
                <a href="../staff/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Nhân viên</h3>
                </a>
                <a href="../order/" class="active">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h3>Đơn hàng</h3>
                </a>

                <a href="../Nhacungcap/" class="">
                    <i class="fa-solid fa-clipboard"></i>
                    <h3>Nhà cung cấp</h3>
                </a>

                <a href="../Danhmuc/" class="">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    <span class="Message-count">26</span>
                </a>

                <a href="../products/" class="">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="../report/" class="">
                    <i class="fa-solid fa-exclamation"></i>
                    <h3>Báo cáo</h3>
                </a>
                <a href="../settings/" class="">
                    <i class="fa-solid fa-gear"></i>
                    <h3>Cài đặt</h3>
                </a>
                <a href="#">
                    <i class="fa-solid fa-plus"></i>
                    <h3>Thêm sản phẩm</h3>
                </a>
                <a href="/websiteechcom/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <!-- ---------------------END OF ASIDE---------------- -->
         <!-- MAIN -->
        <main>
            
<?php
            include_once("../../connect.php");
            ?>
            <!-- main__layout -->
            <div class="main__layout">
                <div id="title_form">
                <label >QUẢN LÝ ĐƠN HÀNG</label>
                </div>
                
                <div class="add">
                    <label for="">Danh sách đơn hàng</label>
                </div>
                <!-- search_html -->
                <div class="search">
                    <form method="POST" action="" id="search_form">
                        <input type="text" name="txtSearch" id="txtSearch" placeholder="   Tìm họ tên nhân viên">
                        <button name="btnSearch" id="btnSearch" ><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
                
                <div class="wrapper" id="tblQLTK" style="display: <?php echo isset($_POST['btnSearch']) && !empty($_POST['txtSearch']) ? 'none' : 'block'; ?>">
                <!-- table -->
                <table>
                        <thead id="header__form">
                            <tr id="row">
                                <th>ID</th>
                                <th>Mã Đơn Hàng</th>
                                <th>Mã Khách Hàng </th>
                                <th>Ngày Lập Đơn</th>
                                <th>Chi tiết</i></th>
                                <th>Địa chỉ khách hàng</th>
                                <th>Tổng Giá trị</th>
                                <th>Tình trạng</th>
                                <th>Phương thức thanh toán</th>
                                <th>Tình trạng thanh toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 1;
                            $sql = "SELECT * FROM donhang";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $formattedNgayLapDon = date('d/m/Y', strtotime($row['ngayLapDon']));
                                    // tình trạng đơn hàng
                                    $statusText = '';
                                    switch ($row['tinhTrang']) {
                                        case 1:
                                            $statusText = "Chờ xác nhận";
                                            $statusClass = "status_order_1";
                                            break;
                                        case 2:
                                            $statusText = "Chờ lấy hàng";
                                            $statusClass = "status_order_2";
                                            break;
                                        case 3:
                                            $statusText = "Đang giao";
                                            $statusClass = "status_order_3";
                                            break;
                                        case 4:
                                            $statusText = "Giao thành công";
                                            $statusClass = "status_order_4";
                                            break;
                                        case 5:
                                            $statusText = "Giao thất bại";
                                            $statusClass = "status_order_5";
                                            break;
                                        case 6:
                                            $statusText = "Hủy đơn";
                                            $statusClass = "status_order_6";
                                            break;
                                        case 7:
                                            $statusText = "Hoàn hàng";
                                            $statusClass = "status_order_7";
                                            break;
                                        default:
                                            $statusText = "Không xác định";
                                            $statusClass = "";
                                            break;
                                    }
                                    // xử lý phương thức thanh toán
                                    $paymentMethodText = '';
                                    $paymentMethodClass = ''; 
                                    
                                    switch ($row['phuongThucThanhToan']) {
                                        case 1:
                                            $paymentMethodText = "Thanh toán khi nhận hàng";
                                            $paymentMethodClass = "payment_method_1";
                                            break;
                                        case 2:
                                            $paymentMethodText = "Thẻ tín dụng";
                                            $paymentMethodClass = "payment_method_2";
                                            break;
                                        case 3:
                                            $paymentMethodText = "Ví điện tử";
                                            $paymentMethodClass = "payment_method_3";
                                            break;
                                        default:
                                            $paymentMethodText = "Không xác định";
                                            $paymentMethodClass = "";
                                            break;
                                    }
                                    // tình trạng thanh toán
                                    $paymentStatusText = '';
                                    $paymentStatusClass = ''; 
                                    
                                    switch ($row['tinhTrangThanhToan']) {
                                        case 1:
                                            $paymentStatusText = "Đã thanh toán";
                                            $paymentStatusClass = "payment_status_1";
                                            break;
                                        case 2:
                                            $paymentStatusText = "Chưa thanh toán";
                                            $paymentStatusClass = "payment_status_2";
                                            break;
                                        default:
                                            $paymentStatusText = "Không xác định";
                                            $paymentStatusClass = "";
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo ($num++) ?></td>
                                        <td><?php echo $row['maDonHang'] ?></td>
                                        <td><?php echo $row['maKhachHang'] ?></td>
                                        <td><?php echo $formattedNgayLapDon ?></td>
                                        <td>
                                            <a id="detail_button" title="Xem chi tiết đơn hàng" href="/webbanhang/admin/dashboard/order/order_detail.php?smnv=<?php echo $row['maDonHang'] ?> ">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                        <td><?php echo $row['diaChiKhachHang'] ?></td>
                                        <td><?php echo htmlspecialchars($row['tongGiaTri']) ?></td>
                                        <td>
                                            <div class="<?php echo $statusClass; ?>">
                                                <?php echo $statusText; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="<?php echo $paymentMethodClass; ?>">
                                                <?php echo $paymentMethodText; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="<?php echo $paymentStatusClass; ?>">
                                                <?php echo $paymentStatusText; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "Không có dữ liệu";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
        </main>
    </div>
    <script src="../index.js"></script>
</body>

</html>
