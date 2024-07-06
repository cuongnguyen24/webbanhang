<?php
require_once '../admin/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style.css" />
    <link rel="stylesheet" href="../assets/reset.css" />
    <link rel="stylesheet" href="../assets/Cuongstyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include '../layout/header.php'; ?>

    <div class="home_product_slider_wrap_body">
        <div class="tab_content">
            <?php
            // Đoạn mã PHP xử lý tìm kiếm
            if (isset($_GET['q'])) {
                $searchTerm = $_GET['q'];


                $query = "SELECT * FROM sanpham WHERE tenSanPham LIKE '%$searchTerm%'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    // Hiển thị kết quả tìm kiếm
                    echo '<div class="wrapper">';
                    echo '<ul class="container">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<li class="pro">';
                        echo '<div class="pro_container">';
                        echo '<a href="#">';
                        echo '<img class="img" src="' . $row["duongDanAnhChung"] . '" alt="">';
                        echo '</a>';
                        echo '<h3>';
                        echo '<a href="#">' . $row["tenSanPham"] . '</a>';
                        echo '</h3>';
                        echo '<span>' . number_format($row["giaBan"], 0, ',', '.') . '₫</span>';
                        echo '</div>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                } else {
                    echo '<p>Không tìm thấy sản phẩm nào.</p>';
                }
            }

            ?>
        </div>
    </div>
    <?php include '../layout/footer.php'; ?>
</body>

</html>