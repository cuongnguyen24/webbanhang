
<header class="header">
    <div class="container" style="height: 71px;">
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

            <div class="header--mid__nav">
            <button class="header__btn js-LogIn" data-action="account">
                        <?php
                        if (isset($_SESSION["loged"])) {
                            echo '<a href="accountadmin.php" class="header__btn"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></a>';
                        } elseif (!isset($_SESSION["loged"])) {
                            echo '<button class="header__btn js-LogIn" data-action="account"><strong>Tài khoản</strong><i class="fa-solid fa-user-pen"></i></button>';
                        }
                        ?>
                    </button>
                    
                <button class="header__btn" data-action="manage" name="manage">
                        <?php
                            if (isset($_SESSION["role"])&&($_SESSION["role"])==1) {
                                echo '<a href="./dashboard">
                                <strong>Quản lý</strong>
                                <i class="fa-solid fa-wrench"></i>
                                </a>';
                            } 
                            elseif (!isset($_SESSION["loged"])) {
                                echo '<a href="./dashboard">
                                <strong>Quản lý</strong>
                                <i class="fa-solid fa-wrench"></i>
                                </a>';
                            }
                        ?>
                </button>

                <button class="header__btn" data-action="cart">
                    <strong>Giỏ hàng</strong>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count count">0</span>
                </button>
            </div>
        </div>
        
    </div>
    <script src="../user/login.js"></script>
</header>

