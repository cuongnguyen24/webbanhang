<header class="header">
    <div class="container">
        <div class="header--mid">
            <div class="header--mid__logo">
                <a href="../index.php">
                    <img src="../assets/img/logo.webp" alt="logo">
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
                            echo '<a href="../admin/accountadmin.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                            }
                    else if($role == 3){
                            echo '
                                    <a href="../user/accountcustomer.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                            }
                    else if($role == 2){
                            echo '<a href="../user/accountstaff.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                            }
                
                }
            ?>

                <button class="header__btn" data-action="wishlist">
                    <strong>Yêu thích</strong>
                    <i class="fa-solid fa-heart" style="font-weight: 400;"></i>
                    <span class="wishlist-count count ">0</span>
                </button>

                <script>
                    function goToWishList() 
                    {
                        window.location.href = "wishlist.php";
                    }
                </script>

                <button class="header__btn" data-action="cart">
                    <strong>Giỏ hàng</strong>
                    <i class="fa-solid fa-cart-shopping" ></i>
                    <span class="cart-count count">0</span>
                </button>
            </div>
        </div>
        <div class="header--bot">
            <ul class="header__menu">
                <li>
                <a href="../index.php">Giới thiệu Nous</a>
                </li>
                <li class="hasChild thoi-trang-so-sinh">
                    <a href="">Thời trang sơ sinh
                        <i class="fa-solid fa-chevron-down"></i>
                        
                    </a>
                    <ul class="FadeIn header__menu1 sub__menu1 ">
                        <li class="hasChild">
                            <a href="">Sơ sinh 0-3 tháng</a>
                            <ul class="header__menu2">
                                <li><a href="">Bộ liền</a></li>
                                <li><a href="">Bộ dài tay</a></li>
                            </ul>
                        </li>
                        <li class="hasChild">
                            <a href="">Bé 3-24 tháng</a>
                            <ul class="header__menu2">
                                <li><a href="">Áo khoác</a></li>
                                <li><a href="">Bộ liền</a></li>
                                <li><a href="">Bộ cộc tay</a></li>
                                <li><a href="">Bộ dài tay</a></li>
                                <li><a href="">Bộ quần yếm</a></li>
                                <li><a href="">Váy</a></li>
                                <li><a href="">Quần</a></li>
                                <li><a href="">Set quà tặng</a></li>
                            </ul>
                        </li>
                        <li class="hasChild">
                            <a href="">Phụ kiện</a>
                            <ul class="header__menu2">
                                <li><a href="">Set phụ kiện</a></li>
                                <li><a href="">Mũ</a></li>
                                <li><a href="">Bao tay bao chân</a></li>
                                <li><a href="">Yếm</a></li>
                                <li><a href="">Gối</a></li>
                                <li><a href="">Khăn sữa</a></li>
                                <li><a href="">Khăn đa năng</a></li>
                                <li><a href="">Giày</a></li>
                                <li><a href="">Chăn ủ</a></li>
                            </ul>
                        </li>
                        <div class="hasChild">
                            <li > <a href="">Set quà tặng</a></li>
                            <li > <a href="">Nous Premium</a></li>
                            <li > <a href="">Nous Petit à Petit</a></li>
                            <li >
                                <a href="">Bộ sưu tập</a>
                                <ul class="header__menu2">                                    
                                    <li><a href="">Hàng mới</a></li>
                                    <li><a href="">Christmas wonderland 2023</a></li>                                    
                                </ul>
                            </li>
                        </div>
                        
                    </ul>
                </li>
                <li class="hasChild thoi-trang-cho-be-2-6y">
                    <a href="">Thời trang cho bé 2-6y
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    
                </li>
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