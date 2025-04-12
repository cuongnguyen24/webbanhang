<?php
    include_once("../../connect.php");
    $maDonHang =  $_GET['smdh'];
    $sql = "SELECT *, khachhang.hoTen, khachhang.email, khachhang.soDienThoai
            FROM donhang 
            JOIN khachhang ON donhang.maKhachHang = khachhang.maKhachHang
            WHERE maDonHang = '$maDonHang'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Không tìm thấy chi tiết đơn hàng'); history.back();</script>";
        exit;
    }
?>
<link rel="stylesheet" href="./detail.css">
<div id="order_detail">
    <div class="wrapper">
        <div id="title">
            Chi tiết đơn hàng
        </div>
        <div class="content">
        <div class="left">
            <div class="element_1st">
                <div class="left">
                    <div class="top">
                        Đơn hàng: 
                        <div id="order_code">
                            <?php
                                echo $maDonHang;
                            ?>
                        </div>
                    </div>
                    <div class="bot">
                        <?php
                        echo $row['ngayLapDon'];
                        ?>
                    </div>
                </div>
                <div class="right">
                    <div class="status">
                        <?php
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
                        ?>
                        <div class="<?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                        </div>
                        <a id="status_button"><i class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                </div>
            </div>
            <div class="element_2nd">
                    <div class="title">
                        KHÁCH HÀNG
                    </div>
                    <div class="content">
                        <div class="name">
                            <?php  echo $row['hoTen'];?>
                        </div>
                        <div class="phonenumber">
                            <?php  echo $row['soDienThoai']; ?>
                        </div>
                    </div>
            </div>
            <div class="element_3rd">
                <table>
                        <thead id="header__form">
                            <tr id="row">
                                <th>ID</th>
                                <th>Mã Đơn Hàng</th>
                                <th>Mã Sản Phẩm</th>
                                <th>Mã Size</th>
                                <th>Số Lượng</th>
                                <th>Đơn Giá</i></th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num_detail = 1;
                                $sql_table = "SELECT * FROM chitietdonhang WHERE maDonHang = '$maDonHang'";
                                $result_table = mysqli_query($conn, $sql_table);
                                if (mysqli_num_rows($result) > 0) {
                                        while ($row_table = mysqli_fetch_assoc($result_table)) {
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo ($num_detail++) ?></td>
                                                <td><?php echo $maDonHang ?></td>
                                                <td><?php echo $row_table['maSanPham'] ?></td>
                                                <td><?php echo $row_table['maSize'] ?></td>
                                                <td><?php echo $row_table['soLuong'] ?></td>
                                                <td><?php echo $row_table['donGia'] ?></td>
                                                <td><?php echo $row_table['thanhTien'] ?></td>
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
        </div>
        <div class="right">
            <div class="element_1st">
                <div class="title">
                    PHƯƠNG THỨC THANH TOÁN
                </div>
                <div class="content">
                    <?php
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
                        ?>
                        <div class="<?php echo $paymentMethodClass; ?>">
                            <?php echo $paymentMethodText; ?>
                        </div>
                </div>
            </div>
            <div class="element_2nd">
            <?php $total_price = 0; ?> 
                <div class="title">
                    TỔNG GIÁ TRỊ
                </div>
                <div class="top">
                    <div class="left">
                    <?php
                        $sql_table = "SELECT *, khuyenmaidonhang.maKhuyenMai, khuyenmai.tenKhuyenMai, khuyenmai.phanTram 
                        FROM chitietdonhang
                        LEFT JOIN khuyenmaidonhang ON chitietdonhang.maDonHang = khuyenmaidonhang.maDonHang
                        LEFT JOIN khuyenmai ON khuyenmaidonhang.maKhuyenMai = khuyenmai.maKhuyenMai
                        WHERE chitietdonhang.maDonHang = '$maDonHang'";
                        $tenKhuyenMai=null;
                        $result_table = mysqli_query($conn, $sql_table);
                        if (mysqli_num_rows($result) > 0) {
                                while ($row_table = mysqli_fetch_assoc($result_table)) {
                                    if (isset($row_table['tenKhuyenMai'])) {
                                        $tenKhuyenMai = $row_table['tenKhuyenMai'];
                                    }
                                    ?>
                                    <div class="product_code">
                                    <?php echo $row_table['maSanPham'] ?></td>
                                    </div>
                                    
                            <?php
                                }
                                ?>
                                <div style="margin-top:10px">Tổng tiền:</div>
                                <div class="maKM" ><?php echo 'Mã khuyến mãi: ';
                                echo $tenKhuyenMai;?> </div><?php
                                
                            } else {
                                echo "Không có dữ liệu";
                            }
                        ?>
                    </div>
                    <div class="right">

                    <?php
                        $sql_table = "SELECT *, khuyenmaidonhang.maKhuyenMai, khuyenmai.tenKhuyenMai, khuyenmai.phanTram 
                        FROM chitietdonhang
                        LEFT JOIN khuyenmaidonhang ON chitietdonhang.maDonHang = khuyenmaidonhang.maDonHang
                        LEFT JOIN khuyenmai ON khuyenmaidonhang.maKhuyenMai = khuyenmai.maKhuyenMai
                        WHERE chitietdonhang.maDonHang = '$maDonHang'";
                        $result_table = mysqli_query($conn, $sql_table);
                        $total_price = 0; // Khởi tạo tổng giá trị là 0
                        $phanTramGiamGia = null;
                        $phanTram = 0;
                        if (mysqli_num_rows($result) > 0) {
                                while ($row_table = mysqli_fetch_assoc($result_table)) {
                                    $total_price = $total_price + $row_table['thanhTien'];
                                    ?>
                                    <div class="price">
                                        <!-- number_format(number, decimals, decimal_separator, thousand_separator) -->
                                    <?php echo number_format($row_table['thanhTien'], 0, ',', '.'); ?> 
                                    </div>
                                    <?php
                                    
                                    if (isset($row_table['phanTram'])) {
                                        $phanTramGiamGia = $row_table['phanTram'] . " %";
                                        $phanTram = $row_table['phanTram'];
                                    }
                                    ?>
                            <?php
                                }
                                ?>
                                <div style="margin-top:10px"><?php echo number_format($total_price, 0, ',', '.'); ?></div>
                                <div class="phantramgiamgia"><?php echo $phanTramGiamGia; ?></div><?php   
                                

                            } else {
                                echo "Không có dữ liệu";
                            }
                           
                        ?>
                    </div>
                </div>
                <div class="bot">
                    <div class="line">
                    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
                    </div>
                    <div class="content">
                        <div class="left">
                            Cần thanh toán: 
                        </div>
                        <div class="right">
                            <?php
                            if (isset($phanTram) && is_numeric($phanTram)) {
                                $discount_amount = ($phanTram / 100) * $total_price; 
                                $total_price =$total_price - $discount_amount;
                            }
                            echo number_format($total_price, 0, ',', '.');
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="element_3rd">
                <a id="cancel_button">
                Đóng
                </a>
                
            </div>
            
        </div>
        </div>
        <!-- xử lý sửa trạng thái đơn hàng -->
        <?php
if (isset($_POST['btnStatus'])) {
    $cboStatusOrder = $_POST['cboStatusOrder'];
    // Lấy trạng thái hiện tại của đơn hàng từ cơ sở dữ liệu
    $sqlGetStatus = "SELECT tinhTrang FROM donhang WHERE maDonHang = '$maDonHang'";
    $resultGetStatus = mysqli_query($conn, $sqlGetStatus);
    if (mysqli_num_rows($resultGetStatus) > 0) {
        $rowStatus = mysqli_fetch_assoc($resultGetStatus);
        $currentStatus = $rowStatus['tinhTrang'];
        // Kiểm tra nếu đơn hàng đang ở trạng thái "Đang giao" trở đi, không cho phép chuyển về trạng thái "Chờ xác nhận" hoặc "Chờ lấy hàng"
        if ($currentStatus >= 3 && $cboStatusOrder <= 2) {
            echo "<script>alert('Không thể chuyển đơn hàng về trạng thái chờ xác nhận hoặc chờ lấy hàng khi đang ở trạng thái đang giao trở đi');</script>";
        } else {
            // Cập nhật trạng thái đơn hàng
            $sqlStatus = "UPDATE donhang SET tinhTrang = '$cboStatusOrder' WHERE maDonHang = '$maDonHang'";
            if (mysqli_query($conn, $sqlStatus)) {
                echo "<script>alert('Sửa trạng thái đơn hàng thành công');</script>";
                echo "<script>window.history.back();</script>";
                // Nếu cập nhật thành công và từ "Chờ lấy hàng" sang "Đang giao", thực hiện trừ số lượng sản phẩm
                if ($currentStatus == 2 && $cboStatusOrder == 3) {
                    // Lấy danh sách chi tiết đơn hàng và join với bảng size để cập nhật số lượng
                    $sqlUpdateQuantity = "
                        UPDATE sizesanpham
                        INNER JOIN chitietdonhang ON sizesanpham.maSanPham = chitietdonhang.maSanPham AND sizesanpham.maSize = chitietdonhang.maSize
                        SET sizesanpham.soLuong = sizesanpham.soLuong - chitietdonhang.soLuong
                        WHERE chitietdonhang.maSanPham = sizesanpham.maSanPham AND chitietdonhang.maSize = sizesanpham.maSize AND sizesanpham.soLuong > 0
                    ";
                    mysqli_query($conn, $sqlUpdateQuantity);
                }
            } else {
                echo "<script>alert('Sửa trạng thái đơn hàng thất bại: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Không tìm thấy đơn hàng');</script>";
    }
}
?>



        <form method="post">
            <div id="status_edit">
                <label >Thay đổi trạng thái đơn hàng</label>
                <div class="Status">
                            <select id="status_order" class="combobox" name="cboStatusOrder">
                                <option value="<?php echo $row['tinhTrang'] ?>"><?php echo $statusText; ?></option>
                                <option value="1">Chờ xác nhận</option>
                                <option value="2">Chờ lấy hàng</option>
                                <option value="3">Đang giao</option>
                                <option value="4">Giao thành công</option>
                                <option value="5">Giao thất bại</option>
                                <option value="6">Hủy đơn</option>
                                <option value="7">Hoàn hàng </option>
                            </select>
                        <div class="flex_button">
                            <button name="btnStatus" type="submit" id="btnStatus">
                                Xác nhận
                            </button>
                            <button type ="submit" id="btnCloseStatus">Đóng</button>
                        </div>
                        <div id="bot"></div>
                        
                </div>
            </div>
        </form>
        <script src="./order_detail.js"></script>
      <script src="./detail.js"></script>
    </div>
    
</div>