<?php
$totalProducts = isset($_SESSION['totalProducts']) ? $_SESSION['totalProducts'] : 0;
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : null;
?>
<header class="header">
    <div class="container">
        <div class="header--mid">
            <div class="header--mid__logo">
                <a href="/webbanhang/index.php">
                    <img src="/webbanhang/assets/img/logo.webp" alt="logo">
                </a>
            </div>
            
            <div class="header--mid__search">
                <form action="../user/search.php" method="GET">
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
                        echo '<a href="/webbanhang/admin/accountadmin.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                    } else if ($role == 3) {
                        echo '
                                    <a href="/webbanhang/user/accountcustomer.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                    } else if ($role == 2) {
                        echo '<a href="/webbanhang/user/accountstaff.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                    }
                }
                ?>

                <button class="header__btn" data-action="wishlist" onclick="goToWishList()">
                    <strong>Yêu thích</strong>
                    <i class="fa-solid fa-heart" style="font-weight: 400;"></i>
                    <span class="wishlist-count count ">0</span>
                </button>

                <script>
                    function goToWishList() {
                        window.location.href = "../wishlist.php";
                    }
                </script>

                <button class="header__btn" data-action="cart" <?php if ($role == 3) echo 'onclick="goToCart()"'; ?>>
                    <strong>Giỏ hàng</strong>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count count"><?php echo $totalProducts; ?></span>
                </button>

                <script>
                    function goToCart() {
                        window.location.href = "/webbanhang/user/cart.php";
                    }
                </script>
            </div>
        </div>
        <div class="header--bot">
            <ul class="header__menu">
                <li>
                    <a href="/webbanhang/index.php">Giới thiệu Nous</a>
                </li>
                <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/webbanhang/admin/connect.php');
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
                <li class="hasChild thoi-trang-cho-be-2-6y">
                    <a href="">Lớn cùng NOUS
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>

                </li>

            </ul>
        </div>
    </div>
    <script src="./user/login.js"></script>
</header>