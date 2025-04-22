<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Bắt lỗi chưa đăng nhập vào trang admin (Lỗi) -->
    <?php
        if(!isset( $_SESSION["loged"]))
        {
            echo '  <script>
                        window.location.href = "../index.php";
                        alert("Bạn chưa đăng nhập!");
                    </script>';
                    exit();
        }

        else
        {
            if(isset($_SESSION["role"])&&($_SESSION["role"] == 1||$_SESSION["role"] == 2))
            {
                echo '  <script>
                    
                        alert("Thêm thành công!");
                    </script>';
                    exit();
            }
            else
            {
                echo '  <script>
                        
                        window.location.href = "../index.php";
                        alert("Bạn không có quyền truy cập vào trang này");
                    </script>';
                    exit();
            }
        }
        // <!-- Bắt lỗi chưa đăng nhập vào trang admin (Lỗi) -->

        
        include './header.php';
        require_once './connect.php';
        include './login.php';

    ?>
    

    
    <div class="main__layout">
        <!-- <img src="../assets/img/cover___banner_web_website_1440x450_29768825b3d84005a3c489e63103dc3d.webp" alt="" width="100%"> -->
    </div>


    <?php
        include '../layout/footer.php';
    ?>
    

</body>
</html>