<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="./assets/style.css" />
  <link rel="stylesheet" href="./assets/reset.css" />
  <link rel="stylesheet" href="./assets/cuongstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <?php
  include './layout/header.php';
  ?>
  <div class="main__layout">
    <div class="main__layout__container">
      <div class="`wrapper">
        <div class="breadcrumb">
          <div><a href="index.php">Trang chủ</a></div>
          <div class="breadcrumb__span">
            <div>/</div>
            <span>Yêu thích</span>
          </div>
        </div>
      </div>
    </div>
    <div class="main__container">
      <!-- khung -->
      <div class="wishlist">
        <!-- các sản phẩm yêu thích đc xếp theo chiều ngang -->
        <div class="wishlist__content">
          <div class="wishlist__content__row">
            <!-- content có 2 phần là ảnh và content nên dùng row -->
            <div class="wishlist__content__1">
              <div class="wishlist__content__1__pic">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">
                  <img src="https://product.hstatic.net/200000692427/product/bo_coc_ba_lo_trang_in_hoa_tiet_xanh_phoi_quan_navy_301087e3181f4db38a1835b6d80358bc_grande.jpg" alt="ảnh sản phẩm">
                </a>
              </div>
              <div class="wishlist__content__1__content">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">Bộ cộc ba lỗ áo trắng in họa tiết xanh phối quần navy</a>
                <div class="price">195,000₫</div>
                <div class="button__action">
                  <div class="button__action_icon">
                    <!-- Vào giỏ hàng -->
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Vào trang sản phẩm -->
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Xóa sản phẩm khỏi form yêu thích -->
                    <a href="#"><i class="fa-solid fa-delete-left"></i></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="wishlist__content__row">
            <!-- content có 2 phần là ảnh và content nên dùng row -->
            <div class="wishlist__content__1">
              <div class="wishlist__content__1__pic">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">
                  <img src="https://product.hstatic.net/200000692427/product/bo_coc_ba_lo_trang_in_hoa_tiet_xanh_phoi_quan_navy_301087e3181f4db38a1835b6d80358bc_grande.jpg" alt="ảnh sản phẩm">
                </a>
              </div>
              <div class="wishlist__content__1__content">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">Bộ cộc ba lỗ áo trắng in họa tiết xanh phối quần navy</a>
                <div class="price">195,000₫</div>
                <div class="button__action">
                  <div class="button__action_icon">
                    <!-- Vào giỏ hàng -->
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Vào trang sản phẩm -->
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Xóa sản phẩm khỏi form yêu thích -->
                    <a href="#"><i class="fa-solid fa-delete-left"></i></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="wishlist__content">
          <div class="wishlist__content__row">
            <!-- content có 2 phần là ảnh và content nên dùng row -->
            <div class="wishlist__content__1">
              <div class="wishlist__content__1__pic">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">
                  <img src="https://product.hstatic.net/200000692427/product/bo_coc_ba_lo_trang_in_hoa_tiet_xanh_phoi_quan_navy_301087e3181f4db38a1835b6d80358bc_grande.jpg" alt="ảnh sản phẩm">
                </a>
              </div>
              <div class="wishlist__content__1__content">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">Bộ cộc ba lỗ áo trắng in họa tiết xanh phối quần navy</a>
                <div class="price">195,000₫</div>
                <div class="button__action">
                  <div class="button__action_icon">
                    <!-- Vào giỏ hàng -->
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Vào trang sản phẩm -->
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Xóa sản phẩm khỏi form yêu thích -->
                    <a href="#"><i class="fa-solid fa-delete-left"></i></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="wishlist__content__row">
            <!-- content có 2 phần là ảnh và content nên dùng row -->
            <div class="wishlist__content__1">
              <div class="wishlist__content__1__pic">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">
                  <img src="https://product.hstatic.net/200000692427/product/bo_coc_ba_lo_trang_in_hoa_tiet_xanh_phoi_quan_navy_301087e3181f4db38a1835b6d80358bc_grande.jpg" alt="ảnh sản phẩm">
                </a>
              </div>
              <div class="wishlist__content__1__content">
                <!-- đưa link sản phẩm vào đây -->
                <a href="#">Bộ cộc ba lỗ áo trắng in họa tiết xanh phối quần navy</a>
                <div class="price">195,000₫</div>
                <div class="button__action">
                  <div class="button__action_icon">
                    <!-- Vào giỏ hàng -->
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Vào trang sản phẩm -->
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                  </div>
                  <div class="button__action_icon">
                    <!-- Xóa sản phẩm khỏi form yêu thích -->
                    <a href="#"><i class="fa-solid fa-delete-left"></i></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>

      </div>

    </div>
  </div>
  <?php
  include './layout/footer.php';
  ?>
</body>

</html>