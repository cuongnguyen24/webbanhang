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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <?php
    include '../layout/header.php';
    ?>
    <div class="main__layout__account">
        <div class="main__layout__container main__layout__container__2">
            <div class="card card-left" style="width: 70%; height: 100%">
                <!-- Thông tin giỏ hàng -->
                <div class="cart">
                    <div class="cart-item">
                        <img src="item1.jpg" alt="Sản phẩm 1">
                        <div class="item-details">
                            <h2>Sản phẩm 1</h2>
                            <p>Giá: 100,000 VND</p>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="decrementQuantity('quantity1')">-</button>
                                <input type="number" id="quantity1" name="quantity1" value="1" min="1">
                                <button class="quantity-btn" onclick="incrementQuantity('quantity1')">+</button>
                            </div>
                            <button class="remove-btn">Xóa</button>
                        </div>
                    </div>
                    <div class="cart-item">
                        <img src="item2.jpg" alt="Sản phẩm 2">
                        <div class="item-details">
                            <h2>Sản phẩm 2</h2>
                            <p>Giá: 200,000 VND</p>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="decrementQuantity('quantity2')">-</button>
                                <input type="number" id="quantity2" name="quantity2" value="1" min="1">
                                <button class="quantity-btn" onclick="incrementQuantity('quantity2')">+</button>
                            </div>
                            <button class="remove-btn">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-right" style="width: 30%;">
                <div class="total">
                    <h3>Tổng thanh toán (2 sản phẩm):</h3>
                    <h3>Tổng cộng: 300,000 VND</h3>
                    <button class="checkout-btn">Thanh Toán</button>
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