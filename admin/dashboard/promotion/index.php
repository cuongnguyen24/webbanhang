<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khuyến mãi</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../style.css">
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
            ?>
            <!-- main__layout -->
            <div class="main__layout">
                <div id="title_form">
                <label >QUẢN LÝ KHUYẾN MÃI</label>
                </div>
                
                <div class="add">
                    <label for="">Danh sách khuyến mãi</label>
                    <a id="add_button" href="/admin/dashboard/promotion/add.php">
                        <i class="fa-solid fa-plus"></i>
                        THÊM MÃ KHUYẾN MÃI
                    </a>
                </div>
                <!-- search_html -->
                <div class="search">
                    <form method="POST" action="" id="search_form">
                        <input type="text" name="txtSearch" id="txtSearch" placeholder="   Tìm tên mã khuyến mãi">
                        <button name="btnSearch" id="btnSearch" title="Tìm kiếm theo tên nhân viên"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
                <div class="aaaa"></div>
                <div class="wrapper" id="tblQLTK" style="display: <?php echo isset($_POST['btnSearch']) && !empty($_POST['txtSearch']) ? 'none' : 'block'; ?>">
                <!-- table -->
                <table>
                        <thead id="header__form">
                            <tr id="row">
                                <th>ID</th>
                                <th>Mã Khuyến Mãi</th>
                                <th>Tên Mã Khuyến Mãi</th>
                                <th>Giá Trị Giảm</th>
                                <th>Ngày Khuyến Mãi</th>
                                <th>Ngày Hết Hạn</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 1;
                            $sql = "SELECT *
                                    FROM khuyenmai";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $formattedNgayKhuyenMai = date('d/m/Y', strtotime($row['ngayKhuyenMai']));
                                    $formattedNgayHetHan = date('d/m/Y', strtotime($row['ngayHetHan']));
                                    $currentDate = date('Y-m-d');
                                    $ngayHetHan = date('Y-m-d', strtotime($row['ngayHetHan']));

                                    if ($ngayHetHan < $currentDate) {
                                        $row['trangThai'] = 2; // Set status to "Không khả dụng"
                                    }
                                    switch ($row['trangThai']) {
                                        case 1:
                                            $trangThai = "Khả dụng";
                                            $statusClass = "status_promotion_1";
                                            break;
                                        case 2:
                                            $trangThai = "Không khả dụng";
                                            $statusClass = "status_promotion_2";
                                            break;
                                        default:
                                            $trangThai = "Không xác định";
                                            $statusClass = "";
                                            break;
                                    }
                                    $phanTram = $row['phanTram'] . "%";
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo ($num++) ?></td>
                                        <td><?php echo $row['maKhuyenMai'] ?></td>
                                        <td><?php echo $row['tenKhuyenMai'] ?></td>
                                        <td><?php echo $phanTram ?></td>
                                        <td><?php echo $formattedNgayKhuyenMai ?></td>
                                        <td><?php echo $formattedNgayHetHan ?></td>
                                        <td>
                                        <div class="<?php echo $statusClass; ?>">
                                                <?php echo $trangThai; ?>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="act__button">
                                            <a href="/webbanhang/admin/dashboard/promotion/edit.php?smkm=<?php echo $row['maKhuyenMai'] ?>" class="button-link" id="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a onclick="return confirm('Bạn có muốn xóa không ?')" href="/webbanhang/admin/dashboard/promotion/delete.php?smkm=<?php echo $row['maKhuyenMai'] ?>" class="button-link" id="delete_button"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="wrapper" id="tbl_after_Search" style="display: <?php echo isset($_POST['btnSearch']) && !empty($_POST['txtSearch']) ? 'block' : 'none'; ?>">
                <!-- table -->
                <table>
                        <thead id="header__form">
                            <tr id="row">
                                <th>ID</th>
                                <th>Mã Khuyến Mãi</th>
                                <th>Tên Mã Khuyến Mãi</th>
                                <th>Giá Trị Giảm</th>
                                <th>Ngày Khuyến Mãi</th>
                                <th>Ngày Hết Hạn</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['btnSearch']) && !empty($_POST['txtSearch'])) {
                            $key_Search = mysqli_real_escape_string($conn, $_POST['txtSearch']);
                            $num = 1;
                            $sql = "SELECT *
                                    FROM khuyenmai WHERE tenKhuyenMai LIKE N'%$key_Search%'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $formattedNgayKhuyenMai = date('d/m/Y', strtotime($row['ngayKhuyenMai']));
                                    $formattedNgayHetHan = date('d/m/Y', strtotime($row['ngayHetHan']));
                                    switch ($row['trangThai']) {
                                        case 1:
                                            $trangThai = "Khả dụng";
                                            $statusClass = "status_promotion_1";
                                            break;
                                        case 2:
                                            $trangThai = "Không khả dụng";
                                            $statusClass = "status_promotion_2";
                                            break;
                                        default:
                                            $trangThai = "Không xác định";
                                            $statusClass = "";
                                            break;
                                    }
                                    $phanTram = $row['phanTram'] . "%";
                                    ?>
                                    <tr>
                                        <td><?php echo ($num++) ?></td>
                                        <td><?php echo $row['maKhuyenMai'] ?></td>
                                        <td><?php echo $row['tenKhuyenMai'] ?></td>
                                        <td><?php echo $phanTram ?></td>
                                        <td><?php echo $formattedNgayKhuyenMai ?></td>
                                        <td><?php echo $formattedNgayHetHan ?></td>
                                        <td>
                                        <div class="<?php echo $statusClass; ?>">
                                                <?php echo $trangThai; ?>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="act__button">
                                            <a href="/webbanhang/admin/dashboard/promotion/edit.php?smkm=<?php echo $row['maKhuyenMai'] ?>" class="button-link" id="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a onclick="return confirm('Bạn có muốn xóa không ?')" href="/webbanhang/admin/dashboard/promotion/delete.php?smkm=<?php echo $row['maKhuyenMai'] ?>" class="button-link" id="delete_button"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                            }
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
                    </div>
                </main>
    </div>
    <script src="../index.js"></script>
</body>

</html>
