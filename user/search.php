<?php
session_start();
// $username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once($_SERVER['DOCUMENT_ROOT'] . '/webbanhang/admin/connect.php');

$searchTerm = $_GET['q'];
$sql = "SELECT * FROM sanpham WHERE tenSanPham LIKE '%$searchTerm%'
";
$result = mysqli_query($conn, $sql);
$sanphams = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sanphams[] = $row;
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php

    include($_SERVER['DOCUMENT_ROOT'] . '/webbanhang/collections/includes/login.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/webbanhang/layout/header.php');

    ?>
    <div class="main-layout">
        <div class="collection template-collection">
            <div class="breadcrum-shop ">
                <div class="breadcrum-wrap container container-xl">
                    <ol class="breadcrum">
                        <li class="breadcrum-item">
                            <a href="">Tìm kiếm</a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="container">
                <div class="collection-wrap collection-wrap-product">
                    <!-- ------------------PRODUCT LIST------------------------------- -->
                    <div class="collection-wrap-product-list">
                        <?php if (!empty($sanphams)) : ?>
                            <?php foreach ($sanphams as $sanpham) : ?>
                                <!-- PRODUCT -->
                                <div class="pro-loop">
                                    <div class="pro-loop-wrap">
                                        <div class="pro-loop-image">
                                            <a href="<?php echo $sanpham['chitietsp']; ?>" class="pro-loop-image-item">
                                                <?php
                                                $q1 = "SELECT duongDanAnh from anhsanpham where maSanPham ='" . $sanpham['maSanPham'] . "'";
                                                $source = mysqli_query($conn, $q1);
                                                $row1 = mysqli_fetch_assoc($source);

                                                ?>
                                                <picture>
                                                    <source srcset="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" data-srcset="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" media="(max-width: 767px)" alt="img <?php echo $sanpham['tenSanPham']; ?>">
                                                    <img class=" lazyloaded" src="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" data-src="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" alt="<?php echo $sanpham['tenSanPham']; ?>" style="max-width: 237.5px;">
                                                </picture>
                                                <picture>
                                                    <source srcset="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" data-srcset="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" media="(max-width: 767px)" alt="img <?php echo $sanpham['tenSanPham']; ?>">
                                                    <img class=" lazyloaded" src="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" data-src="<?php echo '/webbanhang/admin/dashboard/products/' . $row1["duongDanAnh"]; ?>" alt="<?php echo $sanpham['tenSanPham']; ?>" style="max-width: 237.5px;">
                                                </picture>
                                            </a>

                                            <div class="pro-loop-cart-icon">
                                                <button type="button" class="setQuickview" data-handle="bo-lien-coc-mau-xanh-da-troi">
                                                    <img src="https://file.hstatic.net/200000692427/file/asset_2_901a91642639466aa75b2019a34ccebd.svg" alt="add to cart">
                                                    <span>Thêm vào giỏ hàng</span>
                                                </button>
                                            </div>
                                        </div>
                                        <h3 class="pro-loop-name">
                                            <a href="/products/bo-lien-coc-mau-xanh-da-troi" title="<?php echo $sanpham['tenSanPham']; ?>"><?php echo $sanpham['tenSanPham']; ?></a>
                                        </h3>
                                        <div class="pro-loop-price">
                                            <span><?php echo number_format($sanpham['giaBan'], 0, ',', '.'); ?>đ</span>
                                        </div>


                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Không có sản phẩm nào.</p>
                        <?php endif; ?>

                    </div>
                    <!-------------------------------------------------- END PRODUCT ----------------------------------->
                </div>
                <!-- -----------------------------------END PRODUCT LIST -------------------------------------------------------- -->
            </div>
        </div>
    </div>
    </div>
    </div>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/webbanhang/layout/footer.php');
    ?>
</body>

</html>