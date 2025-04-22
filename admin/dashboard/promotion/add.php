<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mã khuyến mãi</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
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
            <a href="../index.php" class="">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                
                <a href="../staff/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Nhân viên</h3>
                </a>
                <a href="../order/" class="">
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
                    
                </a>

                <a href="../products/" class="">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="../promotion/" class="active">
                    <i class="fa-solid fa-ticket"></i>
                    <h3>Khuyến mãi</h3>
                </a>
                <a href="/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <!-- ---------------------END OF ASIDE---------------- -->
        <main>
        <?php
        include_once("../../connect.php");

        if (isset($_POST['btnSubmit'])) {
            // Lấy dữ liệu người dùng nhập đưa vào biến
            $maKhuyenMai = $_POST['txtMaKhuyenMai'];
            $tenKhuyenMai = $_POST['txtTenKhuyenMai'];
            $phanTram = $_POST['txtPhanTram'];
            $ngayKhuyenMai = $_POST['txtNgayKhuyenMai'];
            $ngayHetHan = $_POST['txtNgayHetHan'];
            $trangThai = $_POST['cbTrangThai'];
            // Kiểm tra dữ liệu rỗng trước
            if (empty($maKhuyenMai) || empty($tenKhuyenMai) || empty($phanTram) || empty($ngayKhuyenMai) || empty($ngayHetHan) || empty($trangThai)) {
                echo "<script>alert('Các trường dữ liệu không được để trống'); history.back();</script>";
                return;
            }
            // Kiểm tra ngày bắt đầu và ngày kết thúc
            $dateStart = strtotime($ngayKhuyenMai);
            $dateEnd = strtotime($ngayHetHan);
            if ($dateStart > $dateEnd) {
                echo "<script>alert('Ngày bắt đầu khuyến mãi phải nhỏ hơn ngày kết thúc'); history.back();</script>";
                return;
            }
            // Kiểm tra tên khuyến mãi đã tồn tại hay chưa
            $checkQuery = "SELECT * FROM khuyenmai WHERE tenKhuyenMai = '$tenKhuyenMai'";
            $checkResult = mysqli_query($conn, $checkQuery);
            if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                echo "<script>alert('Tên khuyến mãi đã tồn tại trong hệ thống! Vui lòng nhập tên nhân viên khác.'); history.back();</script>";
                return;
            }
            // Kiểm tra trùng mã Khuyến mại
            $checkAccountQuery = "SELECT * FROM khuyenmai WHERE maKhuyenMai = '$maKhuyenMai'";
            $checkAccountResult = mysqli_query($conn, $checkAccountQuery);
            if ($checkAccountResult && mysqli_num_rows($checkAccountResult) > 0) {
                echo "<script>alert('Mã khuyễn mại đã tồn tại! Vui lòng nhập mã khác.'); history.back();</script>";
                return;
            }
            // Câu lệnh SQL để thêm mới vào bảng khuyenmai
            $sqlKhuyenMai = "INSERT INTO khuyenmai (maKhuyenMai, tenKhuyenMai, phanTram, ngayKhuyenMai, ngayHetHan, trangThai) 
            VALUES ('$maKhuyenMai', '$tenKhuyenMai','$phanTram', '$ngayKhuyenMai', '$ngayHetHan', '$trangThai')";

            // Thực thi câu lệnh SQL
            if (mysqli_query($conn, $sqlKhuyenMai)) {
            echo "<script>alert('Thêm mới khuyến mãi thành công'); window.location.href = '/admin/dashboard/promotion/index.php';</script>";
            } else {
            echo "<script>alert('Thêm mới khuyến mãi thất bại');</script>";
            }
        }
        ?>
            <div class="main">
                <div id="back">
                    <i class="fa-solid fa-angle-left"></i>
                    <a href="/admin/dashboard/promotion/index.php">Quay lại</a>
                </div>
                <div class="wrapper">
                    <div></div>
                    <p class="title">
                        THÊM MÃ KHUYẾN MÃI
                    </p>
                    <div class="content">
                    <form method="post" id="form">
                        <div class="row">
                            <div class="attribute">
                                <label>Mã Khuyến Mãi</label>
                                <div class="decor">
                                    <input type="text" class="input" id="maKhuyenMai" placeholder="Nhập Mã Khuyến Mãi" name="txtMaKhuyenMai" >
                                </div>
                                
                            </div>
                            <div class="attribute">
                                <label>Tên Khuyến Mãi</label>
                                <div class="decor">
                                    <input type="text" class="input" id="tenKhuyenMai" placeholder="Nhập Tên Khuyến Mãi" name="txtTenKhuyenMai" >
                                </div>
                            </div>
                        </div>
                        <div class="attribute">
                            <label>Phần Trăm Khuyến Mãi</label>
                            <div class="decor">
                                <input type="text" class="input" id="phanTram" placeholder="Nhập Phần Trăm Khuyến Mãi" name="txtPhanTram">
                            </div>
                        </div>
                        <div class="row">
                            <div class="attribute">
                                <label>Ngày Khuyến Mãi</label>
                                <div class="decor">
                                    <input type="date" class="input" id="ngayKhuyenMai" placeholder="Nhập Ngày Khuyến Mãi" name="txtNgayKhuyenMai">
                                </div>
                            </div>
                            <div class="attribute">
                                <label >Ngày Hết Hạn</label>
                                <div class="decor">
                                    <input type="date" class="input" id="ngayHetHan" placeholder="Nhập Ngày Hết Hạn" name="txtNgayHetHan">
                                </div>
                            </div>
                        </div>
                         <div class="status">
                            <label>Trạng Thái</label>
                            <div class="decor">
                                <select id="tinhTrang" class="combobox" name="cbTrangThai">
                                    <option value="1">Khả dụng</option>
                                    <option value="2">Không khả dụng</option>
                                </select>
                            </div>
                        </div>
                        <div id="button_add">
                            <button onclick="" name="btnSubmit" type="submit" id="btnSubmit">
                                Thêm thông tin
                            </button>
                        </div>
                        <div id ="bottom"></div>
                        
    <script src="./add.js"></script>
        </div>
    </div>
</html>
        </main>
    </div>
    <script src="../index.js"></script>
</body>

</html>
