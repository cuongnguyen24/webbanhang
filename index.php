
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Khách hàng</title>
  <link rel="stylesheet" href="./assets/style.css" />
  <link rel="stylesheet" href="./assets/reset.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        include './user/login.php' ;
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
                <form action="/search">
                    <input type="hidden" name="type" value="product">
                    <input required name="q" type="text" placeholder="sản phẩm cần tìm...">
                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div class="header--mid__search--smart"></div>
                </form>
            </div>

            <div class="header--mid__nav js-LogIn">
            <?php
                
                if (!isset($_SESSION["loged"]) ) 
                {
                    echo '<button class="header__btn js-LogIn" data-action="account"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></button>';
                    
                } else 
                {
                    $role = $_SESSION["role"];
                    if($role == 1){
                            echo '<a href="./admin/accountadmin.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                            }
                    else if($role == 3){
                            echo '
                                    <a href="./user/accountcustomer.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                            }
                    else if($role == 2){
                            echo '<a href="./user/accountstaff.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                            }
                
                }
            ?>
                <button class="header__btn" data-action="wishlist" onclick="goToWishList()">
                    <strong>Yêu thích</strong>
                    <i class="fa-solid fa-heart" style="font-weight: 400;"></i>
                    <span class="wishlist-count count">0</span>
                </button>

                <script>
                    function goToWishList() 
                    {
                        window.location.href = "wishlist.php";
                    }
                </script>

                <button class="header__btn" data-action="cart">
                    <strong>Giỏ hàng</strong>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count count">0</span>
                </button>
            </div>
        </div>
        <div class="header--bot">
            <ul class="header__menu">
                <li>
                <a href="#">Giới thiệu Nous</a>
                </li>
                <?php 
                    require_once './admin/connect.php';  
                    $query="select * from danhmuc where danhMucCha=-1";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)>0)
                    {                       
                        while($rows= mysqli_fetch_assoc($result)){  
                            echo '<li class="hasChild thoi--so-sinh"><a href="'.$rows["url"].'">'.$rows["tenDanhMuc"].' <i class="fa-solid fa-chevron-down"></i>  </a>';                           
                            $queryChild="select * from danhmuc where danhMucCha='".$rows["maDanhMuc"]."' order by vitri asc ";
                            $resultChild= mysqli_query($conn,$queryChild);                                                 
                            if(mysqli_num_rows($resultChild)>0) 
                            {
                                echo '<ul class="FadeIn header__menu1 sub__menu1">'; 
                                while($rowChild= mysqli_fetch_assoc($resultChild)){
                                    echo    '<li class="hasChild"><a href="'.$rowChild["url"].'">'.$rowChild["tenDanhMuc"].' </a>';
                                    $queryChild1="select * from danhmuc where danhMucCha='".$rowChild["maDanhMuc"]."' order by vitri asc";
                                    $resultChild1= mysqli_query($conn,$queryChild1); 
                                    if(mysqli_num_rows($resultChild1)>0) {                                           
                                        echo ' <ul class="header__menu2">';
                                            while($rowChild1= mysqli_fetch_assoc($resultChild1)){
                                                echo '<li><a href="'.$rowChild1["url"].'">'.$rowChild1["tenDanhMuc"].'</a></li>';
                                                
                                            }
                                        echo '</ul>';                                           
                                    }  
                                    echo   '</li>';                                     
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
            <button id="prev"><</button>
            <button id="next">></button>
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
                            <a href="/pages/about-us">
                                <span>
                                <img src="https://file.hstatic.net/200000692427/file/asset_5_5647134661f84b9c87d29b9131099183.png">
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="home_about_bot">
                    <div class="home_about_item" counpon="NOUS20M">
                        <p class="home_about_item_coupon">Mã: 
                            <span>NOUS20M</span>
                        </p>
                        <p class="home_about_item_discount">
                            <span>Giảm</span>
                            <span class="home_about_item_number">20k</span>
                        </p>

                        <div class="home_about_item_more">
                            <p class="home_about_item_note">Giảm giá 20,000 ₫ cho 1 nhóm sản phẩm</p>
                            <p class="home_about_item_copy">
                                <span>Điều kiện áp dụng</span>
                                <span class="btn_copy">Sao chép mã</span>
						</p>
                        </div>
                    </div>

                    <div class="home_about_item" counpon="NOUS20M">
                        <p class="home_about_item_coupon">Mã: 
                            <span>NOUS20M</span>
                        </p>
                        <p class="home_about_item_discount">
                            <span>Giảm</span>
                            <span class="home_about_item_number">20k</span>
                        </p>

                        <div class="home_about_item_more">
                            <p class="home_about_item_note">Giảm giá 20,000 ₫ cho 1 nhóm sản phẩm</p>
                            <p class="home_about_item_copy">
                                <span>Điều kiện áp dụng</span>
                                <span class="btn_copy">Sao chép mã</span>
						</p>
                        </div>
                    </div>

                    <div class="home_about_item" counpon="NOUS20M">
                        <p class="home_about_item_coupon">Mã: 
                            <span>NOUS20M</span>
                        </p>
                        <p class="home_about_item_discount">
                            <span>Giảm</span>
                            <span class="home_about_item_number">20k</span>
                        </p>

                        <div class="home_about_item_more">
                            <p class="home_about_item_note">Giảm giá 20,000 ₫ cho 1 nhóm sản phẩm</p>
                            <p class="home_about_item_copy">
                                <span>Điều kiện áp dụng</span>
                                <span class="btn_copy">Sao chép mã</span>
						</p>
                        </div>
                    </div>

                    <div class="home_about_item" counpon="NOUS20M">
                        <p class="home_about_item_coupon">Mã: 
                            <span>NOUS20M</span>
                        </p>
                        <p class="home_about_item_discount">
                            <span>Giảm</span>
                            <span class="home_about_item_number">20k</span>
                        </p>

                        <div class="home_about_item_more">
                            <p class="home_about_item_note">Giảm giá 20,000 ₫ cho 1 nhóm sản phẩm</p>
                            <p class="home_about_item_copy">
                                <span>Điều kiện áp dụng</span>
                                <span class="btn_copy">Sao chép mã</span>
						</p>
                        </div>
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
                        <h2 class="nous-title">Sản phẩm nổi bật</h2>					
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
						<a href="/collections/hang-moi" class="viewmore ">Xem thêm </a>
					</div>	
				</div>
			</div>
            <div class="home_product_slider_wrap_body">
                <div class="tab_content">
                    <!-- Chưa làm được -->
                </div>
            </div>
            </div>
        </div>
    </section>












    <script src="./index.js"></script>
    </div>
    

    <?php
        include './layout/footer.php';
    ?>
    
</body>
</html>