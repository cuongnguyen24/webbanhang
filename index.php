
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang chủ</title>
    <link rel="stylesheet" href="./assets/style.css" />
    <link rel="stylesheet" href="./assets/reset.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
    
</head>

<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
    <?php
    include './user/login.php';
    ?>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header--mid">
                <div class="header--mid__logo">
                    <a href="./index.php">
                        <img src="./assets/img/logo.webp" alt="logo">
                    </a>
                </div>

                <div class="header--mid__search">
                    <form action="./user/search.php" method="GET">
                        <input type="hidden" name="type" value="product">
                        <input required name="q" type="text" placeholder="sản phẩm cần tìm...">
                        <button type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <div class="header--mid__nav js-LogIn">
                    <?php

                    if (!isset($_SESSION["loged"])) {
                        echo '<button class="header__btn js-LogIn" data-action="account"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></button>';
                    } else {
                        $role = $_SESSION["role"];
                        if ($role == 1) {
                            echo '<a href="./admin/accountadmin.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                        } else if ($role == 3) {
                            echo '
                                    <a href="./user/accountcustomer.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                        } else if ($role == 2) {
                            echo '<a href="./staff/accountstaff.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                        }
                    }
                    ?>
                    <button class="header__btn js-LogIn" data-action="wishlist" onclick="goToWishList()">
                        <strong>Yêu thích</strong>
                        <i class="fa-solid fa-heart" style="font-weight: 400;"></i>
                        <?php
                        $totalWishlist = isset($_SESSION['totalWishlist']) ? $_SESSION['totalWishlist'] : 0;
                        ?>
                        <span class="wishlist-count count"><?php echo $totalWishlist; ?></span>
                    </button>

                    <script>
                        function goToWishList() {
                            <?php if (!isset($_SESSION["loged"])) { ?>
                                // nếu chưa đăng nhập thì show login
                                showLogIn();
                            <?php } else { ?>
                                // Đăng nhập rồi thì vào cart
                                window.location.href = "./user/wishlist.php";
                            <?php } ?>
                        }
                        
                    </script>

                    <button class="header__btn" data-action="cart" onclick="goToCart()">
                        <strong>Giỏ hàng</strong>
                        <i class="fa-solid fa-cart-shopping"></i>
                        <!-- đưa php vào đây để khi session start ở login thì load session total cart -->
                        <?php
                        $totalProducts = isset($_SESSION['totalProducts']) ? $_SESSION['totalProducts'] : 0;
                        ?>
                        <span class="cart-count count"><?php echo $totalProducts; ?></span>
                    </button>



                    <script>
                        function goToCart() {
                            <?php if (!isset($_SESSION["loged"])) { ?>
                                // nếu chưa đăng nhập thì show login
                                showLogIn();
                            <?php } else { ?>
                                // Đăng nhập rồi thì vào cart
                                window.location.href = "./user/cart.php";
                            <?php } ?>
                        }
                    </script>
                </div>
            </div>
            <div class="header--bot">
                <ul class="header__menu">
                    <li>
                        <a href="/about_us.php">Giới thiệu Nous</a>
                    </li>
                    
                    <?php
			require_once './admin/connect.php';
			$query = "SELECT * FROM danhmuc WHERE danhMucCha = -1";
			$result = mysqli_query($conn, $query);
			$path = "";

			if (mysqli_num_rows($result) > 0) {
			    while ($rows = mysqli_fetch_assoc($result)) {
				$url = str_replace("/webbanhang", "", $rows["url"]);
				echo '<li class="hasChild thoi--so-sinh"><a href="' . $path . $url . '">' . $rows["tenDanhMuc"] . ' <i class="fa-solid fa-chevron-down"></i></a>';

				$queryChild = "SELECT * FROM danhmuc WHERE danhMucCha='" . $rows["maDanhMuc"] . "' ORDER BY vitri ASC";
				$resultChild = mysqli_query($conn, $queryChild);
				if (mysqli_num_rows($resultChild) > 0) {
				    echo '<ul class="FadeIn header__menu1 sub__menu1">';
				    while ($rowChild = mysqli_fetch_assoc($resultChild)) {
					$urlChild = str_replace("/webbanhang", "", $rowChild["url"]);
					echo '<li class="hasChild"><a href="' . $path . $urlChild . '">' . $rowChild["tenDanhMuc"] . '</a>';

					$queryChild1 = "SELECT * FROM danhmuc WHERE danhMucCha='" . $rowChild["maDanhMuc"] . "' ORDER BY vitri ASC";
					$resultChild1 = mysqli_query($conn, $queryChild1);
					if (mysqli_num_rows($resultChild1) > 0) {
					    echo '<ul class="header__menu2">';
					    while ($rowChild1 = mysqli_fetch_assoc($resultChild1)) {
						$urlChild1 = str_replace("/webbanhang", "", $rowChild1["url"]);
						echo '<li><a href="' . $path . $urlChild1 . '">' . $rowChild1["tenDanhMuc"] . '</a></li>';
						// thêm mới
					    }
					    echo '</ul>';
					}

					echo '</li>';
				    }
				    echo "</ul>";
				}

				echo '</li>';
			    }
			}
			?>

                    <li class="hasChild bo-suu-tap">
                        <a href="">Bộ sưu tập
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>

                    </li>
                    <li class="hasChild he-thong-dai-ly">
                        <a href="">Hệ thống đại lý
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>

                    </li>
                    <li class="hasChild lon-cung-nous">
                        <a href="">Lớn cùng nous
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        <script src="./user/login.js"></script>
    </header>
    <!-- Header -->



    <!-- Slider -->
    <section>
        <div class="main__layout">

            <div class="slider">
                <div class="list">
                    <div class="item">
                        <img src="./assets/img/cover___banner_web_website_1440x450_29768825b3d84005a3c489e63103dc3d.webp" alt="">
                    </div>
                    <div class="item">
                        <img src="./assets/img/post_nous_party_2024_1440x450_1440x450_c3be743034c443cba6c0baf0e1dcfe76.webp" alt="">
                    </div>
                    <div class="item">
                        <img src="./assets/img/slide_web_1440x450_47af496db0b7480dbd976d531787bb49.webp" alt="">
                    </div>
                    <div class="item">
                        <img src="./assets/img/slideshow_f1_4.webp" alt="">
                    </div>

                </div>
                <div class="buttons">
                    <button id="prev">
                        < <button id="next">>
                    </button>
                </div>
                <ul class="dots">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
    </section>

    <!-- dlpm-section -->

    <div class="dlpm_section">
        <div class="dlpm_heading">Mã khuyến mãi</div>

    </div>

    <!-- Discount -->
    <section>
        <div class="home_about">
            <div class="container">
                <div class="home_about_center">
                    <div class="home_about_top">
                        <div class="home_about_left">
                            <img src="https://file.hstatic.net/200000692427/file/790x532-01_e150008ac75d4b56b24fa4a43fc55533.png" width="555" height="432" alt="home image about">
                        </div>
                        <div class="home_about_right">
                            <h4 class="title">Con trẻ tuyệt nhất
                                </br>
                                khi thoải mái là chính mình</h4>
                            <div class="home_about_content">
                                <br>
                                <span><i class="fa-solid fa-quote-left"></i></span>
                                <br>
                                <p class="home_about_text">Mỗi thiết kế của Nous đều tuân thủ triết lý "COMFYNISTA - Thoải mái chính là thời trang", trong đó sự thoải mái của các bé được ưu tiên trong mỗi chi tiết nhỏ nhưng vẫn chứa đựng sự tinh tế và khác biệt. Vì vậy, Nous luôn được hàng triệu bà mẹ Việt Nam tin chọn nâng niu hành trình lớn khôn của bé.</p>
                                <span><i class="fa-solid fa-quote-left" style="    text-align: right;"></i></span>
                            </div>
                            <div class="home_about_btn">
                                <a href="/about_us.php">
                                    <span>
                                        <img src="https://file.hstatic.net/200000692427/file/asset_5_5647134661f84b9c87d29b9131099183.png">
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="home_about_bot">

                    <?php
                    
                    $query_discount = "SELECT * FROM khuyenmai WHERE trangThai = 1 limit 4 ";
                    $result_discount = mysqli_query($conn,$query_discount);
                    if(mysqli_num_rows($result_discount))
                    {
                        while($row = mysqli_fetch_assoc($result_discount))
                        {
                            $maKhuyenMai = $row['maKhuyenMai'];
                            $tenKhuyenMai = $row['tenKhuyenMai'];
                            $phanTram = $row['phanTram'];
                            
                     
                    ?>
                        
                        <div class="home_about_item" counpon="NOUS20M">
                            <p class="home_about_item_coupon">Mã:
                            
                                <span id="id_discount" value="<?php echo $maKhuyenMai?>" readonly><?php echo $maKhuyenMai?></span>
                            </p>
                            <p class="home_about_item_discount">
                                <span>Giảm</span>
                                <span class="home_about_item_number"><?php echo $phanTram?>%</span>
                            </p>

                            <div class="home_about_item_more">
                                <p class="home_about_item_note">Giảm giá <?php echo $phanTram?>% cho 1 nhóm sản phẩm</p>
                                <p class="home_about_item_copy">
                                    <span>Điều kiện áp dụng</span>
                                    <button class="btn_copy">Sao chép mã</button>
                                </p>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Home product slider -->
    <section class="home_product_slider">
        <div class="container">
            <div class="home_product_slider_wrap">
                <div class="home-product-slider-wrap-header">
                    <div class="section-title-all">
                        <div class="section-title-left">
                            <h2 class="nous-title">Sản phẩm bán chạy</h2>
                        </div>
                        <div class="section-title-right">
                            <ul class="cate nav collection-navtabs-title pills-tab" data-lim it="8">
                                <li class="nav-item">
                                    <a class="nav-link active" data-handle="/collections/hang-moi" data-toggle="tab" href="#collection-tabs-1" data-count="55">
                                        Hàng mới
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-handle="/collections/km-t4-2024" data-toggle="tab" href="#collection-tabs-2" data-count="69">
                                        Hot sales
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-handle="/collections/phu-kien-cho-tre-so-sinh" data-toggle="tab" href="#collection-tabs-3" data-count="277">

                                        Phụ kiện
                                    </a>
                                </li>
                            </ul>
                            <a href="/collections/ao-khoac/" class="viewmore ">Xem thêm </a>
                        </div>
                    </div>
                </div>
                <div class="home_product_slider_wrap_body">
                    <div class="tab_content">
                        
                    </div>

                    <div class="home_product_slider_wrap_body">
                        <div class="tab_content">
                            <div class="wrapper">
                                <ul class="container">
                                    <?php
                                        $sql =
                                            "WITH soLuongBan AS (
                                            SELECT sanpham.maSanPham, sanpham.tenSanPham, sanpham.duongDanAnhChung, sanpham.chitietsp, sanpham.giaBan, SUM(chitietdonhang.soLuong) AS soLuongSPDaBan
                                            FROM donhang
                                            INNER JOIN chitietdonhang ON donhang.maDonHang = chitietdonhang.maDonHang
                                            INNER JOIN sanpham ON chitietdonhang.maSanPham = sanpham.maSanPham
                                            WHERE donhang.tinhTrang NOT IN (1, 5, 6, 7)
                                            GROUP BY sanpham.maSanPham, sanpham.tenSanPham
                                            ORDER BY soLuongSPDaBan DESC
                                            LIMIT 4
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
                                            soLuongBan.duongDanAnhChung,
                                            soLuongBan.chitietsp,
                                            soLuongBan.giaBan,
                                            tongSoLuong.tongSoLuong - soLuongBan.soLuongSPDaBan AS soLuongTonKho
                                        FROM soLuongBan
                                        INNER JOIN tongSoLuong ON soLuongBan.maSanPham = tongSoLuong.maSanPham
                                        ORDER BY soLuongBan.soLuongSPDaBan DESC
                                        ";
                                        $result_topSP = mysqli_query($conn, $sql);

                                        if ($result_topSP) {
                                            while ($row = mysqli_fetch_assoc($result_topSP)) {
                                                $maSpBanChay = $row['maSanPham'];
                                                $tenSpBanChay = $row['tenSanPham'];
                                                $soLuongSpBanChay = $row['soLuongSPDaBan'];
                                                $soLuongTonKho = $row['soLuongTonKho'];
                                                $tenSp = $row['tenSanPham'];
                                                $duongDanAnhChung = $row['duongDanAnhChung'];
                                                $giaBan = $row['giaBan'];
                                                $chitietsp = $row['chitietsp'];

                                        ?>
                                        <li class="pro">
                                        <div class="pro_container">
                                            <a href="<?php echo $chitietsp?>">
                                                <img class="img" src="/admin/dashboard/products/<?php echo $duongDanAnhChung?>" alt="">
                                            </a>
                                            <h3>
                                                <a href="#"><?php echo $tenSp?></a>
                                            </h3>
                                            <span><?php echo $giaBan?>₫</span>
                                        </div>
                                        </li>
                                        <?php
                                        
                                            }
                                        }
                                        ?>

                                    <li class="pro">
                                        <div class="pro_container">
                                            <a href="">
                                                <img class="img" src="./assets/img/products/bo_ba_lo_ke_xanh_dinh_gau_mau_vang_20c2e1804e0443118e1ddc9caa7a25f1_large.webp" alt=""></a>
                                            <h3>
                                                <a href="#">Bộ ba lỗ tai gấu be phối quần kẻ</a>
                                            </h3>
                                            <span>185,000₫</span>
                                        </div>
                                    </li>

                                    <li class="pro">
                                        <div class="pro_container">
                                            <a href="">
                                                <img class="img" src="./assets/img/products/bo_ba_lo_tai_gau_be_phoi_quan_ke_9b8b62b149b6438d8d63140e74f35281_large.webp" alt=""></a>
                                            <a href=""></a>
                                            <h3>
                                                <a href="#">Set 2 bodysuit xanh phối be</a>
                                            </h3>
                                            <span>185,000₫</span>
                                        </div>
                                    </li>

                                    <li class="pro">
                                        <div class="pro_container">
                                            <a href="">
                                                <img class="img" src="./assets/img/products/set_2_bodysuit_xanh_phoi_be_5a62bebd316c4d2b84ef058e6c084598_large.webp" alt="">
                                            </a>
                                            <h3>
                                                <a href="#">Bộ ba lỗ kẻ xanh đính gấu màu vàng</a>
                                            </h3>
                                            <span>185,000₫</span>
                                        </div>
                                    </li>

                                    <li class="pro">
                                        <div class="pro_container">
                                            <a href="">
                                                <img class="img" src="./assets/img/products/bo_coc_tay_ke_xanh_la_dinh_gau_vang_d603869b28db4e379e225c0605acb7b5_large.webp" alt="">
                                            </a>
                                            <h3>
                                                <a href="#">Bộ ba lỗ tai gấu be phối quần kẻ</a>
                                            </h3>
                                            <span>185,000₫</span>
                                        </div>
                                    </li>

                                    <li class="pro">
                                        <div class="pro_container">
                                            <a href="">
                                                <img class="img" src="./assets/img/products/bo_coc_tay_ke_xanh_la_dinh_gau_vang_d603869b28db4e379e225c0605acb7b5_large.webp" alt="">
                                            </a>
                                            <h3>
                                                <a href="#">Bộ ba lỗ tai gấu be phối quần kẻ</a>
                                            </h3>
                                            <span>185,000₫</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>












    <script src="./index.js"></script>
    <script>
        
const ipnElement = document.querySelectorAll('#id_discount')
const btnElement = document.querySelectorAll('.btn_copy')

// step 2
btnElement.addEventListener('click', function() {
  btnElement.innerText = 'Copied!' // step 3
  ipnElement.select()              // step 4
  document.execCommand('copy')     // step 5
}) 


    </script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
    </div>


    <?php
    include './layout/footer.php';
    ?>
    
</body>

</html>
