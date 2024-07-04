'<?php
                session_start();
                require_once ($_SERVER["DOCUMENT_ROOT"] . "/webbanhang/admin/connect.php");
    
                
                
    
                // Xử lý gửi kết quả qua cart.php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $maSanPham = $_POST["maSanPham"];
                    $tenSanPham = $_POST["tenSanPham"];
                    $giaBan = $_POST["giaBan"];
                    $duongDanAnh = $_POST["duongDanAnh"];
                    $size = $_POST["size"];
                    $quantity = $_POST["quantity"];
    
                    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
                    $sql_check = "SELECT * FROM giohang WHERE maKhachHang = \'$maKhachHang\' AND maSanPham = \'$maSanPham\' AND maSize = \'$size\'";
                    $result_check = mysqli_query($conn, $sql_check);
    
                    if (mysqli_num_rows($result_check) > 0) {
                        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                        $sql_update = "UPDATE giohang SET soLuong = soLuong + $quantity WHERE maKhachHang = \'$maKhachHang\' AND maSanPham = \'$maSanPham\' AND maSize = \'$size\'";
                        mysqli_query($conn, $sql_update);
                    } else {
                        // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
                        $sql_insert = "INSERT INTO giohang (maKhachHang, maSanPham, maSize, soLuong)
                        VALUES (\'$maKhachHang\', \'$maSanPham\', \'$size\', $quantity)";
                        mysqli_query($conn, $sql_insert);
                    }

                    

                    // Chuyển hướng về trang giỏ hàng
                    header("Location: ./cart.php");
                    exit();
                }

                require_once ($_SERVER["DOCUMENT_ROOT"] . "/webbanhang/admin/connect.php");
                $URI = $_SERVER['REQUEST_URI'];
                
                $query1 = "  SELECT * 
                            FROM sanpham
                            WHERE chitietsp = '$URI' ";
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
                ?>
    
                <!DOCTYPE html>
                <html lang="en">
                <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>Khách hàng</title>
                <link rel="stylesheet" href="/webbanhang/assets/style.css" />
                <link rel="stylesheet" href="/webbanhang/assets/reset.css" />
                <link rel="stylesheet" href="../assets/cuongstyle.css" />
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link rel="stylesheet" href="/webbanhang/assets/w3.css">
                </head>
                <body>
                <?php
                include ($_SERVER["DOCUMENT_ROOT"] . "/webbanhang/collections/includes/login.php");
                include($_SERVER["DOCUMENT_ROOT"] . "/webbanhang/layout/header.php");
                ?>
                <div class="main-layout">
                    <div class="collection template-collection">
                        <div class="breadcrum-shop ">
                            <div class="breadcrum-wrap container container-xl">
                                <ol class="breadcrum">
                                    <li class="breadcrum-item">
                                        <a href="">Trang chủ</a>
                                    </li>
                                    <li class="breadcrum-item">
                                        <span style="padding-right: 12px;">/</span>
                                        <?php
                                        require_once ($_SERVER["DOCUMENT_ROOT"] . "/webbanhang/admin/connect.php");
                                        $query = "SELECT * FROM danhmuc WHERE maDanhMuc = '$maDanhMuc'";
                                        $result = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<a href="/webbanhang/collections/'.$row["url"].'"><span>'.$row["tenDanhMuc"].'</span></a>';
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
                                                    require_once ($_SERVER["DOCUMENT_ROOT"] . "/webbanhang/admin/connect.php");
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
                                                    echo ' <img class="mySlides" src="/webbanhang/admin/dashboard/products/'.$image[0].'" style="width:100%;">';
                                                    for ($i = 1; $i < $len ; $i++){
                                                        
                                                        
                                                        echo ' <img class="mySlides" src="/webbanhang/admin/dashboard/products/'.$image[$i].'" style="width:100%;display:none">';
                                                        
                                                        ;
                                                    }
                                                    
                                                    echo '<div class=" w3-section in-row" style="width: 556px;">';
                                                    foreach($image as $duongDanAnh) {
                                                        
                                                        
                                                        
                                                        echo '
                                                        <div class="w3-col ">
                                                        <img class="demo w3-opacity w3-hover-opacity-off" src="/webbanhang/admin/dashboard/products/'.$duongDanAnh.'" style="width:121px;cursor:pointer" onclick="currentDiv('.$id++.')">
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
                                            <div class="productWrapDetail">
                                                <div class="productWrapDetailTitle">
                                                    <h1 class="productTitle"><?php echo $tenSanPham?></h1>
                                                    <div class="productWishlist"> 
                                                        <a href="/pages/wishlist" class="setWishlist" data-handle="bo-lien-coc-mau-xanh-da-troi"><i class="fa-regular fa-heart"></i></a>
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
                                                                <span class="productPriceMain"><?php echo $giaBan?></span>
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
                                                            
                                                            <a class="sizeGuide" href="javascript:void(0);" data-fancybox="sizechart" data-src="#sizechart">Hướng dẫn chọn size</a>
                                                            
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
                                                                    $query = "SELECT IFNULL(soLuong, 0) AS soLuong FROM sizesanpham WHERE (maSanPham = '$maSanPham' AND maSize = 'L') ";
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
                                                                
                                                            
                                                            <div class="product-sw-select-item  " data-cus="9 - 12M" data-height="70 - 77" data-weight="8.5 - 10.5" data-option2="9M">
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
                                                                
                                                            <div class="select-size-info" style="display: none; left: 0px;"><p>Thông số</p><h6 class="measure-cus">Độ tuổi: <b>0 - 3M</b></h6><div class="measure-wrapper"><span class="measure-height">Chiều cao: <b>55 - 61 cm</b></span><span class="empty-border"></span><span class="measure-weight">Cân nặng: <b>3.5 - 5.5 kg</b></span></div></div></div>
                                                    </div>
                                                </div>
    
                                                <div class="productActionMain">
                                                    <div class="groupAdd">
                                                        <div class="groupAdd_tt">
                                                            <span>Số lượng: </span>
                                                        </div>
                                                        <div class="itemQuantity ">
                                                            <button class="qtyBtn minusQuan" data-type="minus">-</button>
                                                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantitySelector">
                                                            <button class="qtyBtn plusQuan" data-type="plus">+</button>
                                                        </div>
                                                    </div> 
                                                    <div class="groupAdd_btn">
                                                        <button type="button" class="btn_addCart d-none" id="addToCart">Thêm vào giỏ hàng</button>
                                                        <button type="button" class="btn_addCheckout btn_pink d-none" id="addToCheckout"> Mua ngay</button>
                                                        <div class="productWishlist d-flex d-lg-none"> 
                                                            <a href="/pages/wishlist" class="setWishlist" data-handle="bo-lien-coc-mau-xanh-da-troi"><i class="lni lni-heart"></i></a>
                                                        </div>
                                                        <button type="button" class="btn_addCart d-block d-lg-none mb-fixed" id="addToCart">Thêm vào giỏ hàng</button>
                                                    </div>
                                                    <div class="productAction">		
    
    
                                                        <button type="button" class="hoverOpacity fullwidth  d-none" id="buyNow">Mua ngay</button>
                                                    </div>	
                                                </div>
                                            </div>
    
    
                                        </div>
                                </div>
                                
                            </div>
                            <div class="productDescription">
                                    <?php
                                        echo '<h2>Mô tả sản phẩm</h2>
                                    <p>Bộ liền dài màu be phối trắng in hình con mèo là sản phẩm tuyệt vời cho trẻ sơ sinh. Sản phẩm được làm từ chất liệu vải cao cấp, mềm mại và thoáng mát, giúp bé cảm thấy dễ chịu suốt cả ngày.</p>';
                                        mysqli_close($conn);
                                    ?>
                                </div>
                        </div>
                    </div>
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
                    item.addEventListener('click', function() {
                        // Xóa class 'active' khỏi tất cả các phần tử
                        productItems.forEach(function(element) {
                            element.classList.remove('active');
                        });

                        // Thêm class 'active' vào phần tử được click
                        item.classList.add('active');
                    });
                });
                var quantityInput = document.getElementById('quantity');
                var minusBtn = document.querySelector('.minusQuan');
                var plusBtn = document.querySelector('.plusQuan');

                // Xử lý sự kiện khi bấm nút "-"
                minusBtn.addEventListener('click', function() {
                    var currentValue = parseInt(quantityInput.value);

                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });

                // Xử lý sự kiện khi bấm nút "+"
                plusBtn.addEventListener('click', function() {
                    var currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 1;
                });
            });
            
                </script>
                </body>
                </html>
    '