
<?php
                session_start();
                
                
                
                require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/connect.php");
                

                // Xử lý gửi kết quả qua cart.php
                
                $flag = 1;
                $URI = $_SERVER['REQUEST_URI'];
                
                $query1 = "  SELECT * 
                            FROM sanpham
                            WHERE chitietsp = '$URI'";
                $result = mysqli_query($conn, $query1);
                if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tenSanPham = $row["tenSanPham"];
                    $maSanPham = $row["maSanPham"];
                    $giaBan = $row["giaBan"];
                    $maDanhMuc = $row["maDanhMuc"];
                }
                } else {
                echo "Không có kết quả";
                }

                $query = "SELECT SUM(sizesanpham.soLuong) AS soluong
                    FROM sizesanpham
                    INNER JOIN sanpham ON sizesanpham.maSanPham = sanpham.maSanPham
                    WHERE sanpham.maSanPham = '$maSanPham' AND sizesanpham.soLuong > 0
                    ";
                $result = mysqli_query($conn,$query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $count_tinhtrang = $row["soluong"];
                    
                }
                
                
                $sizetonkho = 0;
                $size = 0;
                $count_cart = 0;
                $quantity = 0;
                if(isset($_POST['addToCart']))
                {
                    $username = $_SESSION["username"];
                    if (!isset($_SESSION["username"])) {
                        echo '<script>alert("Bạn cần đăng nhập trước")
                        window.location.href = "/";</script>
                        ';
                    exit();
                    }

                    // Lấy maKhachHang từ bảng khachhang dựa vào tên tài khoản
                    $sql_get_maKhachHang = "SELECT khachhang.maKhachHang FROM khachhang 
                                            INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                                            WHERE tenTaiKhoan = '$username'";
                    $result_maKhachHang = mysqli_query($conn, $sql_get_maKhachHang);
                    
                    
                    if (mysqli_num_rows($result_maKhachHang) > 0) {
                        $row_maKhachHang = mysqli_fetch_assoc($result_maKhachHang);
                        $maKhachHang = $row_maKhachHang['maKhachHang'];
                        $size = $_POST["sizesp"];
                        $quantity = $_POST["soluongsp"];
                        
                        
                        
                        $query = "SELECT * FROM sizesanpham WHERE maSanPham = '$maSanPham' AND maSize = '$size'";
                        $result = mysqli_query($conn,$query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sizetonkho = $row["soLuong"];
                                // echo $size . $sizetonkho;
                            }
                        } else {
                        // echo "Không có kết quả";
                        
                        }


                        
                        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
                        $sql_check = "SELECT * FROM giohang WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$maSanPham' AND maSize = '$size'";
                        $result_check = mysqli_query($conn, $sql_check);
        
                        if (mysqli_num_rows($result_check) > 0) {
                            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                            while ($row = mysqli_fetch_assoc($result_check)) {
                                $count_cart = $row["soLuong"];
                                if($count_cart + $quantity <= $sizetonkho)
                                {
                                    
                                    $sql_update = "UPDATE giohang SET soLuong = soLuong + $quantity WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$maSanPham' AND maSize = '$size'";
                                    mysqli_query($conn, $sql_update);
                                    echo '<script>alert("Sản phẩm đã được thêm vào giỏ hàng!")</script>';
                                }
                                else{
                                    $flag = 0;
                                }
                                
                            }
                            
                        } else {
                            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
                            if($count_cart + $quantity <= $sizetonkho)
                                {
                                    $sql_insert = "INSERT INTO giohang (maKhachHang, maSanPham, maSize, soLuong)
                                    VALUES ('$maKhachHang', '$maSanPham', '$size', $quantity)";
                                    mysqli_query($conn, $sql_insert);
                                    echo '<script>alert("Sản phẩm đã được thêm vào giỏ hàng!")</script>';
                                }
                                else{
                                    $flag = 0;
                                }
                            
                        }

                        

                        // Chuyển hướng về trang giỏ hàng
                       if($flag == 1)
                       {
                        // echo '<script>
                        // window.location.href = "/user/cart.php";</script>
                        // ';
                        // exit();
                       }

                        
                        
                    } else {
                        
                        echo '<script>alert("Bạn cần đăng nhập trước")
                        window.location.href = "/";</script>
                        ';
                    }
                    
                }
                else if(isset($_POST['gotowl']))
                {
                    $username = $_SESSION["username"];
                    
                    if (!isset($_SESSION["username"])) {
                        echo '<script>alert("Bạn cần đăng nhập trước")
                        window.location.href = "/";</script>
                        ';
                    exit();
                    }

                    $sql_get_maKhachHang = "SELECT khachhang.maKhachHang FROM khachhang 
                    INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
                    WHERE tenTaiKhoan = '$username'";


                    $result_maKhachHang = mysqli_query($conn, $sql_get_maKhachHang);
                    if (mysqli_num_rows($result_maKhachHang) > 0) {
                        $row_maKhachHang = mysqli_fetch_assoc($result_maKhachHang);
                        $maKhachHang = $row_maKhachHang['maKhachHang'];
                    }
                        
                    $query_check = "SELECT * FROM sanphamyeuthich WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$maSanPham'";

                    $result = mysqli_query($conn,$query_check);

                    if(mysqli_num_rows($result)==0)
                    {
                        $query_insert = "INSERT INTO sanphamyeuthich (maKhachHang, maSanPham) VALUES ('$maKhachHang', '$maSanPham')";
                        
                        $result_insert = mysqli_query($conn,$query_insert);
                        echo '<script>alert("Thêm vào giỏ hàng thành công!")</script>';
                    }
                    else
                    {
                        echo '<script>alert("Sản phẩm này hiện đã có trong sản phẩm yêu thích rồi!")</script>';
                    }

                    
                }

                    

                
                ?>
    
                <!DOCTYPE html>
                <html lang="en">
                <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title><?php echo $tenSanPham?></title>
                <link rel="stylesheet" href="/assets/style.css" />
                <link rel="stylesheet" href="/assets/reset.css" />
                <link rel="stylesheet" href="../assets/cuongstyle.css" />
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link rel="stylesheet" href="/assets/w3.css">
                <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
                </head>
                <body>
                <?php
                include ($_SERVER["DOCUMENT_ROOT"] . "/collections/includes/login.php");
                include($_SERVER["DOCUMENT_ROOT"] . "/layout/header.php");
                ?>
                <div class="main-layout">
                    <div class="collection template-collection">
                        <div class="breadcrum-shop ">
                            <div class="breadcrum-wrap container container-xl">
                                <ol class="breadcrum">
                                    <li class="breadcrum-item">
                                        <a href="/">Trang chủ</a>
                                    </li>
                                    <li class="breadcrum-item">
                                        <span style="padding-right: 12px;">/</span>
                                        <?php
                                        require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/connect.php");
                                        $query = "SELECT * FROM danhmuc WHERE maDanhMuc = '$maDanhMuc'";
                                        $result = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<a href="'.$row["url"].'"><span>'.$row["tenDanhMuc"].'</span></a>';
                                            }
                                        } else {
                                            echo "Không có kết quả";
                                            }
                                        
                                        
                                        ?>
                                        
                                    </li>
                                    <li class="breadcrum-item active">
                                        <span style="padding-right: 12px;">/</span>
                                        <span><?php echo $tenSanPham?></span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <div class="container">
                            <div class="productWrap">
                                <div class="productWrapAll">
                                    <div class="productWrapLeft">
                                        <div class="w3-container">
                                        </div>
                                        <div class="w3-content" style="max-width:546px">
                                            <?php 
                                                    require_once ($_SERVER["DOCUMENT_ROOT"] . "/admin/connect.php");
                                                    $query = "SELECT *
                                                    FROM anhsanpham
                                                    WHERE maSanPham = '$maSanPham'
                                                    ";
                                                    $id = 1;
                                                    $image = [];
                                                    $result = mysqli_query($conn, $query);
                                                    if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        array_push($image , $row["duongDanAnh"]);
                                                    }
                                                    $len = count($image);
                                                    echo ' <img class="mySlides" src="/admin/dashboard/products/'.$image[0].'" style="width:100%;">';
                                                    for ($i = 1; $i < $len ; $i++){
                                                        
                                                        
                                                        echo ' <img class="mySlides" src="/admin/dashboard/products/'.$image[$i].'" style="width:100%;display:none">';
                                                        
                                                        ;
                                                    }
                                                    
                                                    echo '<div class=" w3-section in-row" style="width: 556px;">';
                                                    foreach($image as $duongDanAnh) {
                                                        
                                                        
                                                        
                                                        echo '
                                                        <div class="w3-col ">
                                                        <img class="demo w3-opacity w3-hover-opacity-off" src="/admin/dashboard/products/'.$duongDanAnh.'" style="width:121px;cursor:pointer" onclick="currentDiv('.$id++.')">
                                                        </div>
                                                    ';
                                                    }
                                                    
                                                    } else {
                                                    echo "Không có kết quả";
                                                    }
                                                    
                                                    
                                                    
                                                
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="productWrapRight">
                                            <form class="productWrapDetail" method="POST" >
                                                <div class="productWrapDetailTitle">
                                                    <h1 class="productTitle"><?php echo $tenSanPham?></h1>
                                                    
                                                        <div class="productWishlist"> 

                                                            <button type="submit" name ="gotowl"  class="setWishlist" data-handle="bo-lien-coc-mau-xanh-da-troi">
                                                                
                                                                <i class="fa-regular fa-heart"></i>
                                                                
                                                            </button>
                                                            <span>Thêm vào yêu thích</span>
                                                            
                                                        </div>
                                                    
                                                    
                                                </div>
    
                                                <div class="productInfoStatus">
                                                    <span class="productInfoStatus_tt">Tình trạng:</span>
                                                    <span class="productInfoStatus_check">
                                                    <?php 
                                                        if($count_tinhtrang > 0)
                                                        {
                                                            echo "Còn hàng";
                                                        }
                                                        else
                                                            echo "Hết hàng"
                                                    ?>
                                                    </span>
                                                </div>
    
                                                <div class="productSku">
                                                    Mã sản phẩm: <strong><?php echo $maSanPham?></strong>
                                                </div>
    
                                                <div class="productPrice">
                                                    <div class="productPriceBox">
                                                        <span class="productPriceBox_tt">Giá:</span>
                                                            <p class="productPriceBox_price">
                                                                <span class="productPriceMain"><?php echo number_format($giaBan, 0, ',', '.') . 'đ'?></span>
                                                                <del class="productPriceCompare d-none"><?php echo $giaBan?></del>									
                                                                <span class="productDiscount d-none">-0%</span> 
                                                            </p>
                                                    </div>
                                                </div>
    
    
                                                <div class="product-rating d-none">
                                                    <div class="product-rating--star">
                                                        <div class="star-rate">
                                                            <span class="ic-star"></span>
                                                            <span class="ic-star"></span>
                                                            <span class="ic-star"></span>
                                                            <span class="ic-star"></span>
                                                            <span class="ic-star"></span>
                                                        </div>
                                                        <div class="star-rate star-fill" data-rate="" style="width: 0%;">
                                                            <span class="ic-star-fill"></span>
                                                            <span class="ic-star-fill"></span>
                                                            <span class="ic-star-fill"></span>
                                                            <span class="ic-star-fill"></span>
                                                            <span class="ic-star-fill"></span>
                                                        </div>
                                                    </div>
                                                    <div class="product-rating--total">
                                                        <span class="number"><strong>(0)</strong> đánh giá</span>
                                                    </div>
                                                </div>
    
    
                                                <div class="product-swatch">
                                                    <div class="product-sw-line product-sw-option-2 product-sw-size" data-option="option2">
                                                        <div class="dflex-new">
                                                            <div class="product-sw-title a">Kích thước</div>
                                                            <form action="" method="POST" class="check_size">
                                                                <button type="submit" class="sizeGuide" href="javascript:void(0);" data-fancybox="sizechart" data-src="#sizechart">Kiểm tra số lượng</button>
                                                                
                                                            </form>
                                                            
                                                            
                                                        </div>
                                                        <div class="product-sw-select">
                                                            <?php
                                                                    $query = "SELECT IFNULL(soLuong, 0) AS soLuong FROM sizesanpham WHERE (maSanPham = '$maSanPham' AND maSize = 'S')  LIMIT 1";
                                                                    $result = mysqli_query($conn, $query);
                                                                    if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        
                                                                        $soLuong = 0;
                                                                        $soLuong = $row["soLuong"];
                                                                        if($soLuong>0)
                                                                        {
                                                                            echo '<div class="product-sw-select-item " data-cus="0 - 3M" data-height="55 - 61" data-weight="3.5 - 5.5" data-option2="0M">
                                                                            <div class="product-sw-select-item-span ">S</div></div>';
                                                                        }
                                                                        else if ($soLuong <= 0)
                                                                        echo '<div class="product-sw-select-item soldOut " data-cus="0 - 3M" data-height="55 - 61" data-weight="3.5 - 5.5" data-option2="0M">
                                                                         <div class="product-sw-select-item-span ">S</div></div>';
                                                                    }
                                                                    } 

                                                                ?>
                                                                
                                                            
                                                            
                                                            
                                                            <?php
                                                                    $query = "SELECT IFNULL(soLuong, 0) AS soLuong FROM sizesanpham WHERE (maSanPham = '$maSanPham' AND maSize = 'M')  LIMIT 1";
                                                                    $result = mysqli_query($conn, $query);
                                                                    if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $soLuong = 0;
                                                                        $soLuong = $row["soLuong"];
                                                                        
                                                                        if($soLuong>0)
                                                                        {
                                                                            echo '<div class="product-sw-select-item  " data-cus="3 - 6M" data-height="61 - 67" data-weight="5.5 - 7.5" data-option2="3M">
                                                                            <div class="product-sw-select-item-span">M</div></div>';
                                                                        }
                                                                        else if ($soLuong <= 0)
                                                                        echo '<div class="product-sw-select-item soldOut " data-cus="3 - 6M" data-height="61 - 67" data-weight="5.5 - 7.5" data-option2="3M">
                                                                        <div class="product-sw-select-item-span">M</div></div>';    
                                                                    }
                                                                    
                                                                    } 
                                                                    
                                                                    
                                                                ?>
                                                                
                                                            
                                                            
                                                            <?php
                                                                    $query = "SELECT IFNULL(soLuong, 0) AS soLuong FROM sizesanpham WHERE (maSanPham = '$maSanPham' AND maSize = 'L') LIMIT 1 ";
                                                                    $result = mysqli_query($conn, $query);
                                                                    if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $soLuong = 0;
                                                                        $soLuong = $row["soLuong"];
                                                                        
                                                                        if($soLuong>0)
                                                                        {
                                                                            
                                                                            echo '<div class="product-sw-select-item  " data-cus="6 - 9M" data-height="67 - 72" data-weight="7.5 - 9.5" data-option2="6M">
                                                                            <div class="product-sw-select-item-span">L</div></div>';
                                                                        }
                                                                        else if ($soLuong <= 0)
                                                                        echo '<div class="product-sw-select-item soldOut " data-cus="6 - 9M" data-height="67 - 72" data-weight="7.5 - 9.5" data-option2="6M">
                                                                        <div class="product-sw-select-item-span">L</div></div>';
                                                                    }
                                                                    } 
                                                                    
                                                                    
                                                                ?>
                                                                
                                                            
                                                           
                                                            <?php
                                                                    $query = "SELECT IFNULL(soLuong, 0) AS soLuong FROM sizesanpham WHERE (maSanPham = '$maSanPham' AND maSize = 'XL')  LIMIT 1";
                                                                    $result = mysqli_query($conn, $query);
                                                                    if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $soLuong = 0;
                                                                        $soLuong = $row["soLuong"];
                                                                        if($soLuong>0)
                                                                        {
                                                                            echo '<div class="product-sw-select-item  " data-cus="9 - 12M" data-height="70 - 77" data-weight="8.5 - 10.5" data-option2="9M">
                                                                            <div class="product-sw-select-item-span ">XL</div></div>';
                                                                        }
                                                                        else if ($soLuong <= 0)
                                                                        echo '<div class="product-sw-select-item soldOut " data-cus="9 - 12M" data-height="70 - 77" data-weight="8.5 - 10.5" data-option2="9M">
                                                                        <div class="product-sw-select-item-span ">XL</div></div>';
                                                                    }
                                                                }

                                                                ?>

                                                            
                                                                <input type="hidden" name="sizesp" id="sizesp" value="none" />
                                                            
                                                                
                                                                
                                                    </div>
                                                    <?php
                                                    $flag = 1;
                                                                if($size != "none")
                                                                {
                                                                    
                            
                                                                        if($count_cart + $quantity > $sizetonkho)
                                                                        {
                                                                                echo '<span style="color: #DB9087;">Vui lòng chọn số lượng ít hơn!<br></span>';
                                                                                echo "<span>Size: " . $size . "<br>còn lại trong kho: " . $sizetonkho . "</span>";                                                                                
                                                                        }
                                                                    
                                                                    
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    
                                                                    echo '<span style="color: #DB9087;">Vui lòng chọn size!</span>';
                                                                }
                                                                ?>
                                                                <br>
                                                </div>
    
                                                <div class="productActionMain">
                                                    <div class="groupAdd">
                                                        <div class="groupAdd_tt">
                                                            <span>Số lượng: </span>
                                                        </div>
                                                        <div class="itemQuantity ">
                                                            <button class="qtyBtn minusQuan" data-type="minus">-</button>
                                                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantitySelector" style="border: none">
                                                            <button class="qtyBtn plusQuan" data-type="plus">+</button>
                                                            <input type="hidden" name="soluongsp" id="soluongsp" value="none" />
                                                        </div>
                                                    </div> 
                                                    <div class="groupAdd_btn">
                                                        <!-- <button type="button" class="btn_addCart d-none" id="addToCart">Thêm vào giỏ hàng</button>
                                                        <button type="button" class="btn_addCheckout btn_pink d-none" id="addToCheckout"> Mua ngay</button>
                                                        <div class="productWishlist d-flex d-lg-none"> 
                                                            <a href="/pages/wishlist" class="setWishlist" data-handle="bo-lien-coc-mau-xanh-da-troi"><i class="lni lni-heart"></i></a>
                                                        </div> -->
                                                        <?php
                                                        if($count_tinhtrang > 0)
                                                        {
                                                            echo '<button type="submit" class="btn_addCart d-block d-lg-none mb-fixed" id="addToCart" name="addToCart" >Thêm vào giỏ hàng</button>';
                                                        }
                                                        else
                                                        echo '<button type="submit" class="btn_addCart d-block d-lg-none mb-fixed" id="addToCart" name="addToCart" disabled >Hết hàng</button>';
                                                        ?>
                                                        
                                                        
                                                    </div>
                                                    <div class="productAction">		
    
    
                                                        <button type="button" class="hoverOpacity fullwidth  d-none" id="buyNow">Mua ngay</button>
                                                    </div>	
                                                </div>
                                            </div>
    
    
                                        </form>
                                </div>
                                
                            </div>
                            <div class="productDescription" style="padding-bottom: 30px">
                                    <?php
                                        echo '<h2>Mô tả sản phẩm</h2>
                                    <p>Bộ liền dài màu be phối trắng in hình con mèo là sản phẩm tuyệt vời cho trẻ sơ sinh. Sản phẩm được làm từ chất liệu vải cao cấp, mềm mại và thoáng mát, giúp bé cảm thấy dễ chịu suốt cả ngày.</p>';
                                        mysqli_close($conn);
                                    ?>

                                </div>
                        </div>
                    </div>
                    <?php
                        include($_SERVER["DOCUMENT_ROOT"] . "/collections/includes/footer.php");
                    ?>
                    
                </div>
                <script>
                function currentDiv(n) {
                    var i;
                    var x = document.getElementsByClassName("mySlides");
                    var dots = document.getElementsByClassName("demo");
                    if (n > x.length) {n = 1}
                    if (n < 1) {n = x.length}
                    for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                    }
                    for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
                    }
                    x[n-1].style.display = "block";
                    dots[n-1].className += " w3-opacity-off";
                }
                document.addEventListener('DOMContentLoaded', function() {
                // Lấy tất cả các phần tử có class 'product-sw-select-item'
                var productItems = document.querySelectorAll('.product-sw-select-item');
                    
                // Duyệt qua từng phần tử và thêm sự kiện click
                
                productItems.forEach(function(item) {
                    
                    if(!item.classList.contains("soldOut"))
                    {
                        

                        item.addEventListener('click', function() {
                            // Xóa class 'active' khỏi tất cả các phần tử
                            productItems.forEach(function(element) {
                                element.classList.remove('active');
                                
                            });

                            // Thêm class 'active' vào phần tử được click
                            item.classList.add('active');
                            var itemValue = item.children;
                            document.getElementById('sizesp').value = itemValue[0].innerHTML;
                            
                            console.log(itemValue[0].innerHTML);
                        });
                    }
                });
                var quantityInput = document.getElementById('quantity');
                var minusBtn = document.querySelector('.minusQuan');
                var plusBtn = document.querySelector('.plusQuan');
                document.getElementById('soluongsp').value = 1;
                // Xử lý sự kiện khi bấm nút "-"
                minusBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    var currentValue = parseInt(quantityInput.value);
                    
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                        document.getElementById('soluongsp').value = quantityInput.value;
                    }
                });

                // Xử lý sự kiện khi bấm nút "+"
                plusBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    var currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 1;
                    document.getElementById('soluongsp').value = quantityInput.value;
                });

                
            });
            
                </script>
                </body>
                </html>

