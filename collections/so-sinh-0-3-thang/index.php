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
            WHERE url =  '$URI'";
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

if(isset($_POST['submit']))
{

    $NmaSanpham = $_POST['NmaSanPham'];
    $username = $_SESSION["username"];
    
    if (!isset($_SESSION["username"])) {
        echo '<script>alert("Bạn cần đăng nhập trước")
        window.location.href = "/";</script>
        ';
    exit();
    }

    $sql_get_maKhachHang = "SELECT khachhang.maKhachHang FROM khachhang 
    INNER JOIN taikhoan ON khachhang.maTaiKhoan = taikhoan.maTaiKhoan
    WHERE tenTaiKhoan = '$username'";


    $result_maKhachHang = mysqli_query($conn, $sql_get_maKhachHang);
    if (mysqli_num_rows($result_maKhachHang) > 0) {
        $row_maKhachHang = mysqli_fetch_assoc($result_maKhachHang);
        $maKhachHang = $row_maKhachHang['maKhachHang'];
    }
        
    $query_check = "SELECT * FROM sanphamyeuthich WHERE maKhachHang = '$maKhachHang' AND maSanPham = '$NmaSanpham'";

    $result = mysqli_query($conn,$query_check);

    if(mysqli_num_rows($result)==0)
    {
        $query_insert = "INSERT INTO sanphamyeuthich (maKhachHang, maSanPham) VALUES ('$maKhachHang', '$NmaSanpham')";
        
        $result_insert = mysqli_query($conn,$query_insert);
        echo '<script>alert("Thêm vào sản phẩm yêu thích thành công!")</script>';
    }
    else
    {
        echo '<script>alert("Sản phẩm này hiện đã có trong sản phẩm yêu thích rồi!")</script>';
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

                                    <form class="pro-loop-cart-icon" method="POST">
                                        <button type="submit" class="setQuickview" name="submit">
                                            <i class="fa-regular fa-heart" style="color: #CB1323; font-size: 16px"></i>
                                            <input name="NmaSanPham" for="" style="display: none" value="<?php echo $sanpham['maSanPham']?>"></input>
                                            <span>Thêm vào yêu thích</span> 
                                        </button>
                                        
                                    </form>
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
