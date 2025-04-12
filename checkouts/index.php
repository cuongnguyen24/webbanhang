<?php

session_start();
$totalProducts = isset($_SESSION['totalProducts']) ? $_SESSION['totalProducts'] : 0;
require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/connect.php");


if (!isset($_SESSION["username"])) {
    echo '<script>alert("Bạn cần đăng nhập trước")
    window.location.href = "";</script>
    ';
exit();
}

    $key= "DH";
    $query="SELECT max(CONVERT(SUBSTRING(maDonHang, 3), int)) as nid FROM `donhang`";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0)
    {
        $data = mysqli_fetch_assoc($result)['nid'];          
        $id = $key . ($data + 1);
    }
    else{
        $id = $key."1";
    }


$username = $_SESSION["username"];

$query = "SELECT * FROM taikhoan INNER JOIN khachhang ON taikhoan.maTaiKhoan = khachhang.maTaiKhoan INNER JOIN diachi ON khachhang.maKhachHang = diachi.maKhachHang WHERE tenTaiKhoan = '$username' AND diachi.tinhtrang = 1";
$result = mysqli_query($conn,$query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $hoTen= $row["hoTen"];
        $email = $row["email"];
        $soDienThoai = $row["soDienThoai"];
        $tenDiaChi = $row["tenDiaChi"];
        
    }
    } else {
        echo '<script>alert("Chưa điền đủ thông tin cá nhân!")
        window.location.href = "/user/accountcustomer.php";
        </script>';
        
}
$sql_get_maKhachHang = "SELECT khachhang.maKhachHang FROM khachhang 
                        INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                        WHERE tenTaiKhoan = '$username'";
$result_maKhachHang = mysqli_query($conn, $sql_get_maKhachHang);

if (mysqli_num_rows($result_maKhachHang) > 0) {
    $row_maKhachHang = mysqli_fetch_assoc($result_maKhachHang);
    $maKhachHang = $row_maKhachHang['maKhachHang'];

    // Lấy thông tin sản phẩm trong giỏ hàng của khách hàng từ bảng giohang
    $sql_cart = "SELECT giohang.*, sanpham.tenSanPham, sanpham.giaBan, sanpham.duongDanAnhChung
                 FROM giohang 
                 INNER JOIN sanpham ON giohang.maSanPham = sanpham.maSanPham 
                 INNER JOIN size ON giohang.maSize = size.maSize 
                 WHERE giohang.maKhachHang = '$maKhachHang'";
    $result_cart = mysqli_query($conn, $sql_cart);
    $cart = [];

    if (mysqli_num_rows($result_cart) > 0) {
        while ($row = mysqli_fetch_assoc($result_cart)) {
            $cart[] = $row;
        }
    }
} else {
    die("Không tìm thấy thông tin khách hàng");
    
}

// Tính toán tổng tiền và số lượng sản phẩm trong giỏ hàng
$totalQuantity = 0;
$totalAmount = 0;
$ship_price = 15000;
$totalProducts = count($cart); // Số lượng các sản phẩm trong giỏ hàng
foreach ($cart as $item) {
    $totalQuantity += $item['soLuong'];
    $totalAmount += $item['giaBan'] * $item['soLuong'];
}
 
 $amountDiscount = 0 ;
 $price = $totalAmount  ;
 
$thanhtoan = 1;


if(isset($_POST['discount']))
{
    $discount = $_POST['id_discount'];
    $query = "SELECT * FROM khuyenmai Where maKhuyenMai = '$discount' AND trangThai = 1";
    $result_discount = mysqli_query($conn, $query);
    if (mysqli_num_rows($result_discount) > 0) {
        while ($row = mysqli_fetch_assoc($result_discount)) {
            $percent = $row['phanTram'];
        }
        $_SESSION['discount'] =  $discount;
        $amountDiscount = $totalAmount;
        $amountDiscount *= $percent/100;
        $price -= $amountDiscount;
        $_SESSION['price'] = $price;
        echo '<script>alert("Áp dụng thành công!")</script>';
    }
    else
    {
        echo '<script>alert("Mã khuyến mãi không hợp lệ!")</script>';
        
    }
    
}

if(isset($_POST['pay']))
{
    echo $eprice = $_SESSION['price'] + $ship_price;
    if($_SESSION['totalProducts']>0)
    {

    $hoTen= $_POST["name"];
    $soDienThoai = $_POST["phone"];
    $thanhtoan = $_POST["thanhtoan"];
    if($thanhtoan == 3 || $thanhtoan == 2)
    {
        $tinhtrangthanhtoan = 1;
    }
    else
        $tinhtrangthanhtoan = 2;

        // TẠO ĐƠN HÀNG TRONG ĐƠN HÀNG
    $query_donhang = "INSERT INTO donhang VALUES ('$id', '$maKhachHang', CURDATE(), '$tenDiaChi', '$eprice', '1','$thanhtoan','$tinhtrangthanhtoan')";
    $result = mysqli_query($conn,$query_donhang);
    
        // TẠO ĐƠN HÀNG TRONG CHI TIẾT ĐƠN HÀNG
       
        foreach ($cart as $item) {
            $totalQuantity += $item['soLuong'];
            $totalAmount += $item['giaBan'] * $item['soLuong'];
            $maSanPham = $item['maSanPham'];
            $maSize = $item['maSize'];
            $soLuong = $item['soLuong'];
            $donGia = $item['giaBan'];
            $thanhtien = $soLuong * $donGia;

            $query_ctdonhang = "INSERT INTO chitietdonhang VALUES ('$id', '$maSanPham', '$maSize', '$soLuong', '$donGia', '$thanhtien')";
            $result = mysqli_query($conn,$query_ctdonhang);


            // Trừ số lượng trong size sản phẩm
            // $query_delSize = "UPDATE sizesanpham SET soluong = soluong - $soLuong WHERE maSanPham = '$maSanPham' AND maSize = '$maSize'";
            // $result = mysqli_query($conn,$query_delSize);
        }
        $discount = $_SESSION['discount'];
        $query = "INSERT INTO khuyenmaidonhang VALUES ('$id', '$discount')";
        $result_discountorder = mysqli_query($conn, $query);
        
        //Xóa sản phẩm trong giỏ hàng
        //echo $maKhachHang;
        $query_delCart = "DELETE FROM giohang WHERE maKhachHang = '$maKhachHang'";
        $result = mysqli_query($conn,$query_delCart);

        echo ' <script>
                alert("Đặt hàng hàng thành công ");
                window.location.href = "/user/ordercustomer.php";
            </script>';
    }
    else
    {
        echo ' <script>
        alert("Giỏ hàng chưa có gì để đặt cả!");
        window.location.href = "";
        </script>';
        unset($_SESSION['discount']);

    }
        
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./assets/reset.css" />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="content">
        <div class="wrap">
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="order-summary order-summary-is-collapsed">
                    <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                    <div class="order-summary-sections">
                        <div class="order-summary-section order-summary-section-product-list" data-order-summary-section="line-items">
                            <table class="product-table">
                                <thead>
                                    <tr>
                                        <th scope="col"><span class="visually-hidden">Hình ảnh</span></th>
                                        <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                        <th scope="col"><span class="visually-hidden">Số lượng</span></th>
                                        <th scope="col"><span class="visually-hidden">Giá</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($cart)) : ?>
                                    <?php foreach ($cart as $item) : ?>
                                        <tr class="product" >
                                            <td class="product-image">
                                                <div class="product-thumbnail">
                                                    <div class="product-thumbnail-wrapper">
                                                        <img class="product-thumbnail-image" alt="<?php echo $item['tenSanPham']; ?>" src="<?php echo '/webbanhang/admin/dashboard/products/'.$item['duongDanAnhChung']; ?>" alt="img <?php echo $item['tenSanPham']; ?>">
                                                    </div>
                                                <span class="product-thumbnail-quantity" aria-hidden="true"><?php echo $item['soLuong']; ?></span>
                                                </div>
                                            </td>
                                            <td class="product-description">
                                                <span class="product-description-name order-summary-emphasis"><?php echo $item['tenSanPham']; ?></span>
                                                <br>
                                                    <span class="product-description-variant order-summary-small-text">
                                                        <?php echo $item['maSize']; ?>
                                                    </span>
                                            </td>
                                                <td class="product-quantity visually-hidden"><?php echo $item['soLuong']; ?></td>
                                                <td class="product-price">
                                                    <span class="order-summary-emphasis"><?php echo number_format($item['giaBan'], 0, ',', '.'); ?></span>
                                                </td>
                                            </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>Giỏ hàng của bạn đang trống.</p>
                                <?php endif; ?>

                                    
                                    
                                        
                                    
                                </tbody>
                            </table>
                        </div>
                        
                            
                        <div class="order-summary-section order-summary-section-total-lines payment-lines" data-order-summary-section="payment-lines">
                            <table class="total-line-table">
                                <thead>
                                    <tr>
                                        <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                        <th scope="col"><span class="visually-hidden">Giá</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="total-line total-line-subtotal">
                                        <td class="total-line-name">Tạm tính</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis" data-checkout-subtotal-price-target="57150000">
                                            <?php echo number_format($totalAmount, 0, ',', '.');?>đ
                                            </span>
                                        </td>
                                    </tr>
                                    
                                    
                                        
                                            <tr class="total-line total-line-redeem redeem-membership">
                                                <td class="total-line-name">Khuyến mãi (Giảm  <?php echo (isset($percent)) ? $percent : 0?>%)</td>
                                                <td class="total-line-price">
                                                    <span class="order-summary-emphasis">
                                                        - <?php echo number_format($amountDiscount, 0, ',', '.'); ?>₫
                                                    </span>
                                                </td>
                                            </tr>
                                        
                                    
                                    <tr class="total-line total-line-shipping">
                                        <td class="total-line-name">Phí vận chuyển</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis" data-checkout-total-shipping-target="0">
                                                
                                                    <?php echo number_format($ship_price, 0, ',', '.');?>đ
                                                
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="total-line-table-footer">
                                    <tr class="total-line">
                                        <td class="total-line-name payment-due-label">
                                            <span class="payment-due-label-total">Tổng cộng</span>
                                        </td>
                                        <td class="total-line-name payment-due">
                                            <span class="payment-due-currency">VND</span>
                                            <span class="payment-due-price" data-checkout-payment-due-target="57150000">
                                            <?php echo number_format($price + $ship_price, 0, ',', '.');?>đ
                                            </span>
                                            <span class="checkout_version" display:none="" data_checkout_version="53">
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="main">
                <div class="main-header">
                <a href="/webbanhang/" class="logo">			
                    <img src="/webbanhang/assets/img/logo.webp" alt="">        
                </a>
                </div>
                
                <div class="main-content">
                    <div class="step">
                        <div class="step-sections">
                            <div class="section">
                                <div class="section-header">
                                    <h2 class="section-title">Thông tin giao hàng</h2>
                                </div>

                                <div class="section-content section-customer-information">
                                    <div class="logged-in-customer-information">
                                        <div class="logged-in-customer-information-avatar">
                                            <a href="/webbanhang/user/accountcustomer.php" style="color: black">
                                                <div class="border">
                                                    <i class="fa-solid fa-user-tie"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="logged-in-customer-information-paragraph"><?php echo $hoTen.'<br>('.$email.' )'?></div>
                                    </div>
                                </div>

                                <form class="fieldset" method="POST">

                                <div class="field field-required">
                                    <div class="field-input-wrapper">
                                        <span>Họ và tên</span>
                                        <label class="field-label" for="billing_address_full_name"><?php echo $hoTen;?></label>
                                        <input placeholder="Họ và tên" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_full_name" name="name" disabled value="<?php echo $hoTen;?>" autocomplete="false">
                                    </div>
                                    
                                        <p class="field-message field-message-error">Vui lòng nhập họ tên</p>
                                    
                                </div>

                                <div class="field field-required">
                                    <div class="field-input-wrapper">
                                        <span>Số điện thoại</span>
                                        <label class="field-label" for="billing_address_full_name"><?php echo $soDienThoai;?></label>
                                        <input placeholder="Số điện thoại" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_full_name" name="phone" disabled value="<?php echo $soDienThoai;?>" autocomplete="false">
                                    </div>
                                    
                                        <p class="field-message field-message-error">Vui lòng nhập Số điện thoại</p>
                                    
                                </div>

                                <div class="field field-required">
                                    
                                    <div class="field-input-wrapper">
                                        <span>Địa chỉ</span>
                                        <label class="field-label" for="billing_address_full_name"><?php echo $tenDiaChi;?></label>
                                        <input placeholder="Địa chỉ" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_full_name" disabled name="address" value="<?php echo $tenDiaChi;?>" autocomplete="false">
                                    </div>
                                    
                                        <p class="field-message field-message-error">Địa chỉ</p>
                                    
                                </div>

                                <div class="field field-show-floating-label">
                                    <div class="field-input-wrapper field-input-wrapper-select">
                                        <span>Thanh toán bằng...</span>
                                        <label class="field-label" for="stored_addresses"></label>
                                        <select name="thanhtoan" class="field-input">
                                            <option value="1">Thanh toán khi nhận hàng</option>
                                            <option value="2">Thẻ tín dụng</option>
                                            <option value="3">Ví điện tử</option>
                                        </select>
                        
                                    </div>
                                </div>
                                
                                <div class="field field-required" >
                                   
                                    <span>Mã khuyến mãi</span>
                                    <div class="field-input-wrapper" style="display: flex">
                                        
                                        <label class="field-label" for="billing_address_full_name"></label>
                                        <input placeholder="Mã giảm giá" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_full_name" name="id_discount" value="<?php if(isset($_SESSION['discount'])) echo $_SESSION['discount']?>" style="width: 30%; margin-right: 15px; height: 50%">
                                        <button type="submit" class="discount" name="discount" id="discount" style="
                                            background-color: #DB9087;
                                            color: #fff;
                                            border: none;
                                            padding: 10px 10px;
                                            font-size: 1rem;
                                            cursor: pointer;
                                            border-radius: 5px;
                                        ">áp dụng</button>
                                    </div>
                                    
                                    
                                        <p class="field-message field-message-error">Địa chỉ</p>
                                    
                                </div>
                                <input type="text" style="display: none" name="cast" value="<?php echo $price + $ship_price?>">
                                <div class="form_pay">
                                    <div class="go_to_cart">
                                        <a href="/webbanhang/user/cart.php">giỏ hàng</a>
                                    </div>
                                    
                                        <button type="submit" class="pay" name="pay" id="pay">Thanh toán</button>
                                    
                                    
                                </div>

                                </form>
                            </div>
                        </div>
                        <div class="step-footer">

                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</body>
</html>
