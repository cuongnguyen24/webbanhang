<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhân viên</title>
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

                
                <a href="../staff/" class="active">
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
                <a href="../promotion/" class="">
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
            $maNhanVien=$_GET['smnv'];
            $query = "SELECT nhanvien.*, taikhoan.tenTaiKhoan, taikhoan.matKhau, taikhoan.maPhanQuyen
                                    FROM nhanvien
                                    JOIN taikhoan ON nhanvien.maTaiKhoan = taikhoan.maTaiKhoan WHERE maNhanVien= '$maNhanVien'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "<script>alert('Không tìm thấy nhân viên'); history.back();</script>";
                exit;
            }
            if (isset($_POST['btnSubmit'])) {
                // Lấy dữ liệu người dùng nhập đưa vào biến
                $tenTaiKhoan = $_POST['txtTenTaiKhoan'];
                $matKhau = $_POST['txtMatKhau'];
                $hoTen = $_POST['txtHoTen'];
                $maPhanQuyen = $_POST['cbPhanQuyen'];
                $ngaySinh = $_POST['txtNgaySinh'];
                $diaChi = $_POST['txtDiaChi'];
                //Xử lý giới tính
                if (isset($_POST['Sex']) && $_POST['Sex'] === 'male') {
                    $gioiTinh = 1;
                } else {
                    $gioiTinh = 0;
                }
                $email = $_POST['txtEmail'];
                $soDienThoai = $_POST['txtSoDienThoai'];
                $ghiChu = $_POST['txtGhiChu'];
                // Xử lý ngày sinh
                $ngaySinh = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['txtNgaySinh'])));

                // Kiểm tra dữ liệu rỗng trước
                if ( empty($tenTaiKhoan) || empty($matKhau) || empty($hoTen) || empty($ngaySinh) || empty($diaChi) || !isset($_POST['Sex']) || empty($email) || empty($soDienThoai) ) {
                    echo "<script>alert('Các trường dữ liệu không được để trống'); history.back();</script>";
                    return;
                }
                $emailBanDau = $row['email'];
                $emailMoi = $_POST['txtEmail'];
                // Kiểm tra trùng email
                if ($emailMoi != $emailBanDau) {
                    // Kiểm tra xem email mới đã tồn tại chưa
                    $checkEmailQuery = "SELECT * FROM nhanvien WHERE email = '$emailMoi' AND email != '$emailBanDau'";
                    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
                    if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
                        echo "<script>alert('Email đã tồn tại!'); history.back();</script>";
                        exit;
                    }
                }
                // Kiểm tra email
                $emailDomain = substr($email, -10);
                if ($emailDomain !== '@gmail.com') {
                    echo "<script>alert('Email phải có đuôi @gmail.com!'); history.back();</script>";
                    return;
                }
                // Kiểm tra ngày sinh không lớn hơn ngày hiện tại
                    $today = date('Y-m-d');
                    if ($ngaySinh > $today) {
                        echo "<script>alert('Ngày sinh không được lớn hơn ngày hiện tại'); history.back();</script>";
                        return;
                    }
                // Kiểm tra số điện thoại
                $phoneLength = strlen($soDienThoai);
                if ($phoneLength < 9 || $phoneLength > 11) {
                    echo "<script>alert('Số điện thoại phải có từ 9 đến 11 chữ số!'); history.back();</script>";
                    return;
                }
                $hoTenBanDau = $row['hoTen'];
                $hoTenMoi = $_POST['txtHoTen'];
                // Kiểm tra tên nhân viên đã tồn tại hay chưa
                if ($hoTenMoi != $hoTenBanDau) {
                    $checkHoTenQuery = "SELECT * FROM nhanvien WHERE hoTen = '$hoTenMoi'";
                    $checkHoTenResult = mysqli_query($conn, $checkHoTenQuery);
                    if ($checkHoTenResult && mysqli_num_rows($checkHoTenResult) > 0) {
                        echo "<script>alert('Tên nhân viên đã tồn tại trong hệ thống! Vui lòng nhập tên nhân viên khác.'); history.back();</script>";
                        exit;
                    }
                }
                $tenTaiKhoanMoi = $_POST['txtTenTaiKhoan'];
                $tenTaiKhoanBanDau = $row['tenTaiKhoan'];
                // Nếu tên tài khoản mới khác tên tài khoản ban đầu
                if ($tenTaiKhoanMoi != $tenTaiKhoanBanDau) {
                    // Kiểm tra xem tên tài khoản mới đã tồn tại trong bảng taikhoan hay chưa
                    $checkAccountQuery = "SELECT * FROM taikhoan WHERE tenTaiKhoan = '$tenTaiKhoanMoi'";
                    $checkAccountResult = mysqli_query($conn, $checkAccountQuery);

                    if ($checkAccountResult && mysqli_num_rows($checkAccountResult) > 0) {
                        echo "<script>alert('Tên tài khoản đã tồn tại trong hệ thống! Vui lòng nhập thông tin khác.'); history.back();</script>";
                        return;
                    }
                }
                //check trùng mã nhân viên
                $maNhanVienBanDau = $row['maNhanVien'];
                $maNhanVienMoi = $_POST['txtMaNhanVien'];
                // Kiểm tra xem mã nhân viên mới có khác mã nhân viên ban đầu không
                if ($maNhanVienMoi != $maNhanVienBanDau) {
                    // Kiểm tra xem mã nhân viên mới đã tồn tại chưa
                    $checkQuery = "SELECT * FROM nhanvien WHERE maNhanVien = '$maNhanVienMoi'";
                    $checkResult = mysqli_query($conn, $checkQuery);
                    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                        echo "<script>alert('Mã nhân viên đã tồn tại trong hệ thống! Vui lòng nhập mã nhân viên khác.'); history.back();</script>";
                        exit;
                    }
                }
                // Kiểm tra và bắt lỗi trùng mã tài khoản
                // $maTaiKhoanMoi = $_POST['txtMaTaiKhoan'];
                // $maTaiKhoanBanDau = $row['maTaiKhoan'];
                // if ($maTaiKhoanMoi != $maTaiKhoanBanDau) {
                //     // Truy vấn kiểm tra mã tài khoản mới
                //     $checkAccountCodeQuery = "SELECT * FROM taikhoan WHERE tenTaiKhoan = '$tenTaiKhoanMoi'";
                //     $checkAccountCodeResult = mysqli_query($conn, $checkAccountCodeQuery);
                //     if ($checkAccountCodeResult && mysqli_num_rows($checkAccountCodeResult) > 0) {
                //         echo "<script>alert('Mã tài khoản đã tồn tại trong hệ thống! Vui lòng nhập thông tin khác.'); history.back();</script>";
                //         return;
                //     }
                // }
                // Kiểm tra và cập nhật thông tin tài khoản trong bảng taikhoan
                $checkTaiKhoanQuery = "SELECT * FROM taikhoan WHERE maTaiKhoan = '$maTaiKhoan'";
                $checkTaiKhoanResult = mysqli_query($conn, $checkTaiKhoanQuery);

                if (!$checkTaiKhoanResult) {
                    echo "<script>alert('Lỗi kiểm tra tài khoản: " . mysqli_error($conn) . "'); history.back();</script>";
                    exit;
                }

                if (mysqli_num_rows($checkTaiKhoanResult) == 0) {
                    // Nếu mã tài khoản không tồn tại, thêm mới vào bảng taikhoan
                    $insertTaiKhoanQuery = "INSERT INTO taikhoan (maTaiKhoan, tenTaiKhoan, matKhau, maPhanQuyen)
                                        VALUES ('$maTaiKhoan', '$tenTaiKhoan', '$matKhau', '$maPhanQuyen')";
                    if (!mysqli_query($conn, $insertTaiKhoanQuery)) {
                        echo "<script>alert('Thêm mới tài khoản thất bại: " . mysqli_error($conn) . "');</script>";
                        return;
                    } 
                } else {
                    // Nếu mã tài khoản đã tồn tại, cập nhật thông tin tài khoản
                    $updateTaiKhoanQuery = "UPDATE taikhoan SET tenTaiKhoan = '$tenTaiKhoan', matKhau = '$matKhau', maPhanQuyen = '$maPhanQuyen'
                                        WHERE maTaiKhoan = '$maTaiKhoan'";
                    if (!mysqli_query($conn, $updateTaiKhoanQuery)) {
                        echo "<script>alert('Cập nhật tài khoản thất bại: " . mysqli_error($conn) . "');</script>";
                        return;
                    }
                }

                // Cập nhật thông tin nhân viên trong bảng nhanvien
                $sqlNhanVien = "UPDATE nhanvien SET hoTen = '$hoTen', ngaySinh = '$ngaySinh', diaChi = '$diaChi',
                                gioiTinh = '$gioiTinh', email = '$email', soDienThoai = '$soDienThoai', ghiChu = '$ghiChu'
                                WHERE maNhanVien = '$maNhanVien'";
                if (mysqli_query($conn, $sqlNhanVien)) {
                    echo "<script>alert('Sửa thông tin nhân viên thành công'); window.location.href = '/admin/dashboard/staff/index.php';</script>";
                } else {
                    echo "<script>alert('Sửa thông tin nhân viên thất bại: " . mysqli_error($conn) . "');</script>";
                }
            }
            ?>

            <div class="main">
                <div id="back">
                    <i class="fa-solid fa-angle-left"></i>
                    <a href="/admin/dashboard/staff/index.php">Quay lại</a>
                </div>
                <div class="wrapper">
                    <div></div>
                    <p class="title">
                        SỬA NHÂN VIÊN
                    </p>
                    <div class="content">
                    <form method="post" id="form">
                        <div class="row">
                        <input type="hidden" name="maNhanVienBanDau" value="<?php echo isset($row['maNhanVien']) ? $row['maNhanVien'] : ''; ?>">
                            <div class="attribute">
                                <label>Mã Nhân Viên</label>
                                <div class="decor">
                                    <input type="text" class="input" id="maNhanVien" placeholder="Nhập Mã Nhân Viên" name="txtMaNhanVien" value="<?php echo $row['maNhanVien'] ?>" disabled>
                                </div>
                                
                            </div>
                            <div class="attribute">
                                <label>Mã Tài Khoản</label>
                                <div class="decor">
                                    <input type="text" class="input" id="maNhanVien" placeholder="Nhập Mã Tài Khoản" name="txtMaTaiKhoan" value="<?php echo $row['maTaiKhoan'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="attribute">
                                <label>Tên tài khoản</label>
                                <div class="decor">
                                    <input type="text" class="input" id="tenTaiKhoan" placeholder="Nhập Tên Tài Khoản" name="txtTenTaiKhoan" value="<?php echo $row['tenTaiKhoan'] ?>">
                                </div>
                            </div>
                            <div class="attribute">
                                <label >Mật khẩu</label>
                                <div class="decor">
                                    <input type="text" class="input" id="matKhau" placeholder="Nhập mật khẩu" name="txtMatKhau" value="<?php echo $row['matKhau'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="permission">
                            <label>Mã phân quyền</label>
                            <div class="decor">
                                <select id="phanQuyen" class="combobox" name="cbPhanQuyen">
                                    <option value="3">Nhân viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="attribute">
                            <label>Họ tên</label>
                            <div class="decor">
                                <input type="text" class="input" id="hoTen" placeholder="Nhập Họ Tên" name="txtHoTen" value="<?php echo $row['hoTen'] ?>">
                            </div>
                        </div>
                        <div class="attribute">
                            <label>Ngày Sinh</label>
                            <div class="decor">
                                <input type="date" id="date" class="input" name="txtNgaySinh" value="<?php echo $row['ngaySinh'] ?>">
                            </div>
                        </div>
                        <div class="attribute">
                            <label>Địa chỉ</label>
                            <div class="decor">
                                <input type="text" class="input" id="diaChi" placeholder="Nhập Địa Chỉ" name="txtDiaChi" value="<?php echo $row['diaChi'] ?>">
                            </div>
                        </div>
                        <div class="sex" >
                            <label >Giới tính</label>
                            <div class="about">
                                <div class="attribute__sex">
                                    <input type="radio" id="radio_button" name="Sex" checked value="male" <?php if($row['gioiTinh'] == 1) echo "checked"; ?>>
                                    <label for="">Nam</label>
                                </div>
                                <div class="attribute__sex">
                                    <input type="radio" id="radio_button" name="Sex" value="female" <?php if($row['gioiTinh'] == 0) echo "checked"; ?>>
                                    <label for="">Nữ</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="attribute">
                            <label>Email</label>
                            <div class="decor">
                                <input type="text" class="input" id="email" placeholder="Nhập Email" name="txtEmail" value="<?php echo $row['email'] ?>">
                            </div>
                            <div id="error__email-message">
                            <i class="fa-solid fa-circle-exclamation"></i>
                                Email không đúng định dạng !

                            </div>
                        </div>
                        <div class="attribute">
                            <label>Số điện thoại</label>
                            <div class="decor">
                                <input type="text" class="input" id="soDienThoai" placeholder="Nhập Số Điện Thoại" name="txtSoDienThoai" value="<?php echo $row['soDienThoai'] ?>">
                            </div>
                            <div id="error__sdt-message">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Số điện thoại phải từ 9-11 số !
                            </div>
                        </div>
                        <div class="attribute">
                            <label>Ghi chú<label>
                            <div class="decor">
                                <input type="text" class="input" id="ghiChu" placeholder="Nhập Ghi Chú" name="txtGhiChu" value="<?php echo $row['ghiChu'] ?>">
                            </div>
                            <div class="border_bottom"></div>    
                        </div>
                        <div class="margin_error">
                            <div id="errorDiv" class="error-message">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Hãy nhập đầy đủ thông tin !
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
