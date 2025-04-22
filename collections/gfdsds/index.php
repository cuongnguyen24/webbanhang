<?php
session_start();
// $username = $_SESSION["username"]; // Lấy tên tài khoản từ session
require_once ($_SERVER['DOCUMENT_ROOT'] .'/admin/connect.php');


// lấy mã danh mục theo link 



// Lấy dữ liệu từ CSDL
// lấy tên danh mục dựa trên url 


$URI = $_SERVER['REQUEST_URI'];
                                    
$query1 = "  SELECT * 
            FROM danhmuc
            WHERE url =  '/webbanhang" . $URI . "'";
$result1 = mysqli_query($conn, $query1);

$madanhmuc;
$tendanhmuc;
if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $madanhmuc = $row['maDanhMuc'];
        $tendanhmuc = $row['tenDanhMuc'];
    }
}


$sql = "SELECT *
        FROM sanpham
        INNER JOIN danhmuc ON sanpham.maDanhMuc = danhmuc.maDanhMuc
        WHERE sanpham.maDanhMuc = '$madanhmuc'
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
  <link rel="stylesheet" href="/assets/style.css" />
  <link rel="stylesheet" href="/assets/reset.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php
        
        include ($_SERVER['DOCUMENT_ROOT'] . '/collections/includes/login.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/layout/header.php');
        
        ?>
    <div class="main-layout">
        <div class="collection template-collection">
            <div class="breadcrum-shop ">
                <div class="breadcrum-wrap container container-xl">
                    <ol class="breadcrum">
                        <li class="breadcrum-item">
                            <a href="">Trang chủ</a>
                        </li>
                        <li class="breadcrum-item active">
                            <span style="padding-right: 12px;">/</span>
                            <span><?php echo $tendanhmuc?></span>
                        </li>
                        
                    </ol>
                </div>
            </div>

            <div class="container">
                <div class="collection-wrap collection-wrap-product">
                    <!-- <div class="collection-filter-product">
                        <div class="row">
                            <div class="col-12 d-flex flex-wrap align-items-center">
                                <div class="layered_filter_parent">
                                    <div class="collection--filter-desktop">
                                    <i class="fa-solid fa-filter"></i>
                                                <span>Bộ lọc</span>
                                    </div>
                                    <div class="collection--filter-content">
                                        <div class="layered_filter_title">
                                            <p class="title_filter">
                                                <span class="icon-filter"><svg viewBox="0 0 20 20"><path fill="none" stroke-width="2" stroke-linejoin="round" stroke-miterlimit="10" d="M12 9v8l-4-4V9L2 3h16z"></path></svg></span>
                                                Bộ lọc
                                            </p>
                                        </div>
                                        <div class="layered_filter_group">
                                            <div class="collection--filter-items" data-param="size">
                                                <div class="collection--filter-items-content filter-size dropdown">
                                                    <button class="btn btn-secondary btn-title dropdown-toggle" type="button" id="filer-size">
                                                        Size
                                                    </button>
                                                    <div class="collection--filter--dropdown dropdown-menu" aria-labelledby="filer-size" style="display: none;">
                                                        <ul class="collection--filter--list">
                                                                                <li class="newborn" data-size="newborn">
                                                                                    <input type="checkbox" id="filter-size-0" data-url="newborn" value="Newborn" name="size-filter" data-size="(variantonhand_p2:product = Newborn)">
                                                                                    <label for="filter-size-0">Newborn</label>   
                                                                                </li>

                                                                                <li class="0m" data-size="0m">
                                                                                    <input type="checkbox" id="filter-size-1" data-url="0m" value="0M" name="size-filter" data-size="(variantonhand_p2:product = 0M)">
                                                                                    <label for="filter-size-1">0M</label>   
                                                                                </li>

                                                                                <li class="12m" data-size="12m">
                                                                                    <input type="checkbox" id="filter-size-2" data-url="12m" value="12M" name="size-filter" data-size="(variantonhand_p2:product = 12M)">
                                                                                    <label for="filter-size-2">12M</label>   
                                                                                </li>

                                                                                <li class="18m" data-size="18m">
                                                                                    <input type="checkbox" id="filter-size-3" data-url="18m" value="18M" name="size-filter" data-size="(variantonhand_p2:product = 18M)">
                                                                                    <label for="filter-size-3">18M</label>   
                                                                                </li>

                                                                                <li class="24m" data-size="24m">
                                                                                    <input type="checkbox" id="filter-size-4" data-url="24m" value="24M" name="size-filter" data-size="(variantonhand_p2:product = 24M)">
                                                                                    <label for="filter-size-4">24M</label>   
                                                                                </li>

                                                                                <li class="3m" data-size="3m">
                                                                                    <input type="checkbox" id="filter-size-5" data-url="3m" value="3M" name="size-filter" data-size="(variantonhand_p2:product = 3M)">
                                                                                    <label for="filter-size-5">3M</label>   
                                                                                </li>

                                                                                <li class="6m" data-size="6m">
                                                                                    <input type="checkbox" id="filter-size-6" data-url="6m" value="6M" name="size-filter" data-size="(variantonhand_p2:product = 6M)">
                                                                                    <label for="filter-size-6">6M</label>   
                                                                                </li>

                                                                                <li class="9m" data-size="9m">
                                                                                    <input type="checkbox" id="filter-size-7" data-url="9m" value="9M" name="size-filter" data-size="(variantonhand_p2:product = 9M)">
                                                                                    <label for="filter-size-7">9M</label>   
                                                                                </li>
                                                            <li class="d-none">,newborn,baby</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="collection--filter-items" data-param="type">
                                                <div class="collection--filter-items-content filter-type dropdown">
                                                    <button class="btn btn-secondary btn-title dropdown-toggle" type="button" id="filter-type">
                                                        Dòng sản phẩm
                                                    </button>
                                                    <div class="collection--filter--dropdown dropdown-menu" aria-labelledby="filter-type" style="display: none;">
                                                        <ul class="collection--filter--list">
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-1" data-url="ao-dai-tay" value="Áo dài tay" name="type-filter" data-type="(product_type:product = Áo dài tay)">
                                                                <label for="filter-type-1">Áo dài tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-2" data-url="bo-bodysuit-coc-tay" value="Bộ bodysuit cộc tay" name="type-filter" data-type="(product_type:product = Bộ bodysuit cộc tay)">
                                                                <label for="filter-type-2">Bộ bodysuit cộc tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-3" data-url="bo-bodysuit-dai-tay" value="Bộ Bodysuit dài tay" name="type-filter" data-type="(product_type:product = Bộ Bodysuit dài tay)">
                                                                <label for="filter-type-3">Bộ Bodysuit dài tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-4" data-url="bo-coc-tay" value="Bộ cộc tay" name="type-filter" data-type="(product_type:product = Bộ cộc tay)">
                                                                <label for="filter-type-4">Bộ cộc tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-5" data-url="bo-dai-tay" value="Bộ dài tay" name="type-filter" data-type="(product_type:product = Bộ dài tay)">
                                                                <label for="filter-type-5">Bộ dài tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-6" data-url="bo-lien-coc" value="Bộ liền cộc" name="type-filter" data-type="(product_type:product = Bộ liền cộc)">
                                                                <label for="filter-type-6">Bộ liền cộc</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-7" data-url="bo-lien-dai" value="Bộ liền dài" name="type-filter" data-type="(product_type:product = Bộ liền dài)">
                                                                <label for="filter-type-7">Bộ liền dài</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-8" data-url="bo-quan-yem" value="Bộ quần yếm" name="type-filter" data-type="(product_type:product = Bộ quần yếm)">
                                                                <label for="filter-type-8">Bộ quần yếm</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-9" data-url="bodysuit-coc-tay" value="Bodysuit cộc tay" name="type-filter" data-type="(product_type:product = Bodysuit cộc tay)">
                                                                <label for="filter-type-9">Bodysuit cộc tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-10" data-url="bodysuit-dai-tay" value="Bodysuit dài tay" name="type-filter" data-type="(product_type:product = Bodysuit dài tay)">
                                                                <label for="filter-type-10">Bodysuit dài tay</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-11" data-url="quan-dai" value="Quần dài" name="type-filter" data-type="(product_type:product = Quần dài)">
                                                                <label for="filter-type-11">Quần dài</label>   
                                                            </li>
                                                            
                                                            <li>
                                                                <input type="checkbox" id="filter-type-12" data-url="set-qua-tang" value="Set quà tặng" name="type-filter" data-type="(product_type:product = Set quà tặng)">
                                                                <label for="filter-type-12">Set quà tặng</label>   
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="collection--filter-items" data-param="vendor">
                                                <div class="collection--filter-items-content filter-brand dropdown">
                                                    <button class="btn btn-secondary btn-title dropdown-toggle" type="button" id="filer-vendor">
                                                        Thương hiệu
                                                    </button>
                                                    <div class="collection--filter--dropdown dropdown-menu" aria-labelledby="filer-vendor" style="display: none;">
                                                        <ul class="collection--filter--list">
                                                                
                                                            <li>
                                                                <input type="checkbox" id="filter-brand-1" data-url="nous-basic" value="Nous Basic" name="brand-filter" data-vendor="(vendor:product = Nous Basic)">
                                                                <label for="filter-brand-1">Nous Basic</label>   
                                                            </li>
                                                                
                                                            <li>
                                                                <input type="checkbox" id="filter-brand-2" data-url="nous-petit" value="Nous Petit" name="brand-filter" data-vendor="(vendor:product = Nous Petit)">
                                                                <label for="filter-brand-2">Nous Petit</label>   
                                                            </li>
                                                                
                                                            <li>
                                                                <input type="checkbox" id="filter-brand-3" data-url="nous-premium" value="Nous Premium" name="brand-filter" data-vendor="(vendor:product = Nous Premium)">
                                                                <label for="filter-brand-3">Nous Premium</label>   
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collection--filter-items" data-param="color">
                                                <div class="collection--filter-items-content filter-color dropdown">
                                                    <button class="btn btn-secondary btn-title dropdown-toggle" type="button" id="filer-color">
                                                        Màu sắc
                                                    </button>
                                                    <div class="collection--filter--dropdown dropdown-menu" aria-labelledby="filer-color" style="display: none;">
                                                        <ul class="collection--filter--list">
                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p97" data-url="be" value="Be" name="color-filter" data-color="(tag:product = mausac: Be)">
                                                                <label for="data-color-p97" class="color-be">
                                                                    Be
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p98" data-url="cam" value="Cam" name="color-filter" data-color="(tag:product = mausac: Cam)">
                                                                <label for="data-color-p98" class="color-cam">
                                                                    Cam
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p99" data-url="do" value="Đỏ" name="color-filter" data-color="(tag:product = mausac: Đỏ)">
                                                                <label for="data-color-p99" class="color-do">
                                                                    Đỏ
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p100" data-url="ghi" value="Ghi" name="color-filter" data-color="(tag:product = mausac: Ghi)">
                                                                <label for="data-color-p100" class="color-ghi">
                                                                    Ghi
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p101" data-url="hong" value="Hồng" name="color-filter" data-color="(tag:product = mausac: Hồng)">
                                                                <label for="data-color-p101" class="color-hong">
                                                                    Hồng
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p102" data-url="nau" value="Nâu" name="color-filter" data-color="(tag:product = mausac: Nâu)">
                                                                <label for="data-color-p102" class="color-nau">
                                                                    Nâu
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p103" data-url="tim" value="Tím" name="color-filter" data-color="(tag:product = mausac: Tím)">
                                                                <label for="data-color-p103" class="color-tim">
                                                                    Tím
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p104" data-url="trang" value="Trắng" name="color-filter" data-color="(tag:product = mausac: Trắng)">
                                                                <label for="data-color-p104" class="color-trang">
                                                                    Trắng
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p105" data-url="vang" value="Vàng" name="color-filter" data-color="(tag:product = mausac: Vàng)">
                                                                <label for="data-color-p105" class="color-vang">
                                                                    Vàng
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p106" data-url="xam" value="Xám" name="color-filter" data-color="(tag:product = mausac: Xám)">
                                                                <label for="data-color-p106" class="color-xam">
                                                                    Xám
                                                                </label>  
                                                            </li>


                                                            <li class="">
                                                                <input type="checkbox" id="data-color-p107" data-url="xanh" value="Xanh" name="color-filter" data-color="(tag:product = mausac: Xanh)">
                                                                <label for="data-color-p107" class="color-xanh">
                                                                    Xanh
                                                                </label>  
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collection--filter-items" data-param="gia">
                                                <div class="collection--filter-items-content filter-price dropdown">
                                                    <button class="btn btn-secondary btn-title dropdown-toggle" type="button" id="filer-price">
                                                        Giá bán
                                                    </button>
                                                    <div class="collection--filter--dropdown dropdown-menu" aria-labelledby="filer-price" style="display: none;">
                                                        <ul class="collection--filter--list">
                                                            <li>
                                                                <input type="checkbox" id="filter-price-1" name="cc" data-url="duoi-200000" data-price="(price_variant:product < 200000)">
                                                                <label for="filter-price-1">
                                                                    <span>Dưới</span> 200,000₫
                                                                </label>   
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="filter-price-2" name="cc" data-url="200000-300000" data-price="(price_variant:product range 200000_300000)">
                                                                <label for="filter-price-2">
                                                                    200,000₫ - 300,000₫
                                                                </label>   
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="filter-price-3" name="cc" data-url="300000-500000" data-price="(price_variant:product range 300000_500000)">
                                                                <label for="filter-price-3">
                                                                    300,000₫ - 500,000₫
                                                                </label>   
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="filter-price-4" name="cc" data-url="500000-1000000" data-price="(price_variant:product range 500000_1000000)">
                                                                <label for="filter-price-4">
                                                                    500,000₫ - 1,000,000₫
                                                                </label>   
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="filter-price-5" name="cc" data-url="tren-1000000" data-price="(price_variant:product > 1000000)">
                                                                <label for="filter-price-5">
                                                                    <span>Trên</span> 1,000,000₫
                                                                </label>   
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="layered_filter_bottom">
                                            <button id="clear-btn-filter" class="btn-filter btn-filter-clear">Hủy</button>
                                            <button id="apply-btn-filter" class="btn-filter btn-filter-apply">Áp dụng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
                                             $q1="SELECT duongDanAnh from anhsanpham where maSanPham ='".$sanpham['maSanPham']."'";
                                             $source = mysqli_query($conn,$q1);
                                             $row1= mysqli_fetch_assoc($source);
                                             
                                        ?>	
                                        <picture>
                                                <source srcset="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" data-srcset="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" media="(max-width: 767px)" alt="img <?php echo $sanpham['tenSanPham']; ?>">
                                                <img class=" lazyloaded" src="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" data-src="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" alt="<?php echo $sanpham['tenSanPham']; ?>" style="max-width: 237.5px;">
                                        </picture>
                                        <picture>
                                                <source srcset="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" data-srcset="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" media="(max-width: 767px)" alt="img <?php echo $sanpham['tenSanPham']; ?>">
                                                <img class=" lazyloaded" src="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" data-src="<?php echo '/admin/dashboard/products/'. $row1["duongDanAnh"]; ?>" alt="<?php echo $sanpham['tenSanPham']; ?>" style="max-width: 237.5px;">
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
        include "../includes/footer.php";
        
    ?>
    
</body>
</html>
