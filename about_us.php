<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <link rel="stylesheet" href="./assets/style.css" />
    <link rel="stylesheet" href="./assets/reset.css" />
    <link rel="stylesheet" href="./assets/about_us.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>
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
                    <button class="header__btn" data-action="wishlist" onclick="goToWishList()">
                        <strong>Yêu thích</strong>
                        <i class="fa-solid fa-heart" style="font-weight: 400;"></i>
                        <span class="wishlist-count count">0</span>
                    </button>

                    <script>
                        function goToWishList() {
                            window.location.href = "wishlist.php";
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
                        <a href="#">Giới thiệu Nous</a>
                    </li>
                    <?php
                    require_once './admin/connect.php';
                    $query = "select * from danhmuc where danhMucCha=-1";
                    $result = mysqli_query($conn, $query);
                    $path = "";
                    if (mysqli_num_rows($result) > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            echo '<li class="hasChild thoi--so-sinh"><a href="' . $path . $rows["url"] . '">' . $rows["tenDanhMuc"] . ' <i class="fa-solid fa-chevron-down"></i>  </a>';
                            $queryChild = "select * from danhmuc where danhMucCha='" . $rows["maDanhMuc"] . "' order by vitri asc ";
                            $resultChild = mysqli_query($conn, $queryChild);
                            if (mysqli_num_rows($resultChild) > 0) {
                                echo '<ul class="FadeIn header__menu1 sub__menu1">';
                                while ($rowChild = mysqli_fetch_assoc($resultChild)) {
                                    echo    '<li class="hasChild"><a href="' . $path . $rowChild["url"] . '">' . $rowChild["tenDanhMuc"] . ' </a>';
                                    $queryChild1 = "select * from danhmuc where danhMucCha='" . $rowChild["maDanhMuc"] . "' order by vitri asc";
                                    $resultChild1 = mysqli_query($conn, $queryChild1);
                                    if (mysqli_num_rows($resultChild1) > 0) {
                                        echo ' <ul class="header__menu2">';
                                        while ($rowChild1 = mysqli_fetch_assoc($resultChild1)) {
                                            echo '<li><a href="' . $path . $rowChild1["url"] . '">' . $rowChild1["tenDanhMuc"] . '</a></li>';
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
            <div class="banner1" >
                <img style="width:100%;
                                        height:auto;
                                        object-fit:cover;            
                                                    " src="https://file.hstatic.net/200000692427/file/banner_web_t12_1440x450_nous_fb72f369f008423db4a80062c0575c19.jpg" alt="">
            </div>
    </section>
        

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
                    
                </div>
            </div>
        </div>
    </section>
    <div class="banner2">
            <div class="content">
                <div class="item">
                    <div class="title">
                        <h4>Đội ngũ sáng tạo</h4>
                        <span>
                            <img src="https://file.hstatic.net/200000692427/file/about-icon-7_9f7021291b9645b99b96fc2916e46d8b.svg" alt="">
                        </span>
                    </div>
                    <p>
                    Đội ngũ thiết kế - sáng tạo của Nous liên tục làm mới chính mình và sản phẩm để đem lại những điều tuyệt vời nhất cho khách hàng.
                    </p>
                    
                </div>
                <div class="item">
                    <div class="title">
                        <h4>Nhà máy tiêu chuẩn quốc tế</h4>
                        <span>
                            <img src="https://file.hstatic.net/200000692427/file/about-icon-8_e0376739a4bb40bba5cb41cf78756041.svg" alt="">
                        </span>
                    </div>
                    <p>Nous tuân thủ nghiêm ngặt trong từng khâu sản xuất từ lựa chọn chất lượng vải, chất lượng gia công đến chất lượng bao bì.</p>
                </div>
                <div class="item">
                    <div class="title">
                        <h4>Thương hiệu uy tín</h4>
                        <span>
                            <img src="https://file.hstatic.net/200000692427/file/about-icon-9_e180469b79ea42f5812a0f570a7c0929.svg" alt="">
                        </span>
                    </div>
                    <p>Sở hữu độ phủ thương hiệu lớn, Nous được hàng triệu mẹ Việt tin tưởng và lựa chọn; là đối tác quen thuộc của các đơn vị lớn trong và ngoài nước.</p>
                </div>
            </div>
    </div>
    <div class="banner3">
        <div class="container">
            <div class="title">
                <h4>Nous và những con số</h4>
            </div>
            <div class="content">
                <div class="item">
                    <p class="big">8</p>
                    <p>Năm hoạt động</p>
                </div>
                <div class="item">
                    <p>Có mặt tại</p>
                    <p class="big">63</p>
                    <p>tỉnh thành</p>
                </div>
                <div class="item">
                    <p class="big">1000++</p>
                    <p>đại lý</p>
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
