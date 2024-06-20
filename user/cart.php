<?php
session_start();
$username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once '../admin/connect.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="../assets/style.css" />
    <link rel="stylesheet" href="../assets/reset.css" />
    <link rel="stylesheet" href="../assets/cuongstyle.css" />
    <link rel="stylesheet" href="../assets/cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    include '../layout/header.php';
    ?>
    <div class="main__layout__account main__layout__account_cart">
        <div class="main__layout__container main__layout__container__2 ">
            <div class="card card-left card-left-cart" style="width: 65%; height: 100%">
                <!-- Thông tin giỏ hàng -->
                <div class="cart">
                    <div class="cart-item">
                        <img src="https://product.hstatic.net/200000692427/product/bo_dai_chui_dau_mau_vang_99db7220feb241ea8d4ac70c36cc3f82.jpg" alt="img 1">
                        <div class="item-details">
                            <h2>Bộ dài chui đầu màu vàng</h2>
                            <p>Giá: 100,000 VND</p>
                            <div class="controls">

                                <div class="size-controls">
                                    <label for="size1">Kích cỡ:</label>
                                    <select id="size1" name="size1">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="color-controls">
                                    <label for="color1">Màu sắc:</label>
                                    <select id="color1" name="color1">
                                        <option value="Red">Đỏ</option>
                                        <option value="Blue">Xanh</option>
                                        <option value="Green">Xanh lá</option>
                                        <option value="Black">Đen</option>
                                        <option value="White">Trắng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="quantity-controls">
                                <label for="color1">Số lượng:</label>
                                <button class="quantity-btn" onclick="decrementQuantity('quantity1')">-</button>
                                <input type="number" id="quantity1" name="quantity1" value="1" min="1">
                                <button class="quantity-btn" onclick="incrementQuantity('quantity1')">+</button>
                            </div>

                            <button class="remove-btn">Xóa</button>
                        </div>
                    </div>
                    <hr class="hr-card">
                    <div class="cart-item">
                        <img src="https://product.hstatic.net/200000692427/product/bo_dai_chui_dau_mau_vang_99db7220feb241ea8d4ac70c36cc3f82.jpg" alt="img 1">
                        <div class="item-details">
                            <h2>Bộ dài chui đầu màu vàng</h2>
                            <p>Giá: 100,000 VND</p>
                            <div class="controls">

                                <div class="size-controls">
                                    <label for="size1">Kích cỡ:</label>
                                    <select id="size1" name="size1">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="color-controls">
                                    <label for="color1">Màu sắc:</label>
                                    <select id="color1" name="color1">
                                        <option value="Red">Đỏ</option>
                                        <option value="Blue">Xanh</option>
                                        <option value="Green">Xanh lá</option>
                                        <option value="Black">Đen</option>
                                        <option value="White">Trắng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="quantity-controls">
                                <label for="color1">Số lượng:</label>
                                <button class="quantity-btn" onclick="decrementQuantity('quantity1')">-</button>
                                <input type="number" id="quantity1" name="quantity1" value="1" min="1">
                                <button class="quantity-btn" onclick="incrementQuantity('quantity1')">+</button>
                            </div>

                            <button class="remove-btn">Xóa</button>
                        </div>
                    </div>
                    <hr class="hr-card">
                    <div class="cart-item">
                        <img src="https://product.hstatic.net/200000692427/product/bo_dai_chui_dau_mau_vang_99db7220feb241ea8d4ac70c36cc3f82.jpg" alt="img 1">
                        <div class="item-details">
                            <h2>Bộ dài chui đầu màu vàng</h2>
                            <p>Giá: 100,000 VND</p>
                            <div class="controls">

                                <div class="size-controls">
                                    <label for="size1">Kích cỡ:</label>
                                    <select id="size1" name="size1">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="color-controls">
                                    <label for="color1">Màu sắc:</label>
                                    <select id="color1" name="color1">
                                        <option value="Red">Đỏ</option>
                                        <option value="Blue">Xanh</option>
                                        <option value="Green">Xanh lá</option>
                                        <option value="Black">Đen</option>
                                        <option value="White">Trắng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="quantity-controls">
                                <label for="color1">Số lượng:</label>
                                <button class="quantity-btn" onclick="decrementQuantity('quantity1')">-</button>
                                <input type="number" id="quantity1" name="quantity1" value="1" min="1">
                                <button class="quantity-btn" onclick="incrementQuantity('quantity1')">+</button>
                            </div>

                            <button class="remove-btn">Xóa</button>
                        </div>
                    </div>
                    <hr class="hr-card">
                    
                </div>
                
            </div>

            <div class="card card-right" style="width: 35%;">
                <div class="total">
                    <h2>Thông tin giỏ hàng</h2>
                    <h3>Tạm tính (2 sản phẩm)</h3>
                    <h3>Tổng thanh toán: 300,000 VND</h3>
                    <button class="checkout-btn">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include '../layout/footer.php';
    ?>
    <script>
        function incrementQuantity(inputId) {
            const input = document.getElementById(inputId);
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(inputId) {
            const input = document.getElementById(inputId);
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
</body>

</html>