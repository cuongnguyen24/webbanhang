<?php
    require_once '../../connect.php';
    $maNhaCungCap=$_GET['maNhaCungCap'];
    $tenNhaCungCap="";
    $diaChi="";
    $email="";
    $soDienThoai="";       
    $query="select * from nhacungcap where maNhaCungCap='".$maNhaCungCap."'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $tenNhaCungCap=$row["tenNhaCungCap"];
                $diaChi=$row["diaChi"];
                $email=$row["email"];
                $soDienThoai=$row["soDienThoai"];
            }
        }
    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['btnSave']))
    {
        $errors=[];
        if(empty(trim($_POST['tenNhaCungCap']))){
            $errors['tenNhaCungCap']='Tên nhà cung cấp không được để trống';
        }
        else{
            $tenNhaCungCap= $_POST['tenNhaCungCap'];
        } 
        if(empty(trim($_POST['diaChi']))){
            $errors['diaChi']='Địa chỉ không được để trống';
        }
        else{        
            $soDienThoai =$_POST['diaChi'] ;
        }
        if(empty(trim($_POST['email']))){
            $errors['email']='Email không được để trống';
        }
        else{  
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không đúng định dạng";
            } 
            else if(!preg_match ("/([a-z0-9_]+|[a-z0-9_]+\.[a-z0-9_]+)@(([a-z0-9]|[a-z0-9]+\.[a-z0-9]+)+\.([a-z]{2,4}))/i", $email))
            {
                $errors['email'] = "Email không đúng định dạng";
            }
            else { 
                $sql_checkemail = "SELECT * FROM nhacungcap WHERE email='$email' limit 1";
                $result1 = mysqli_query($conn, $sql_checkemail);                
                $row1=mysqli_fetch_assoc($result1);          
                if (mysqli_num_rows($result1) != 0 &&  $row1['maNhaCungCap'] != $maNhaCungCap) {
                    $errors['email'] = 'Email đã tồn tại';
                } else {
                    $email = $_POST['email'];
                }    
            }       
        }
        if(empty(trim($_POST['soDienThoai']))){
            $errors['soDienThoai']='Số điện thoại không được để trống';
        }
        else{  
            $soDienThoai = $_POST['soDienThoai'];
            if (!preg_match("/^[0-9]*$/", $soDienThoai)) {
                $errors['soDienThoai'] = 'Số điện thoại không đúng định dạng';
            } 
            else if (strlen(trim($_POST['soDienThoai'])) == 10) { // kiểm tra trùng dt
                $sql1 = "SELECT * FROM nhacungcap WHERE soDienThoai='$soDienThoai'";
                $result = mysqli_query($conn, $sql1);
                // lay dl cau $re
                $row=mysqli_fetch_assoc($result);
               
                if (mysqli_num_rows($result) != 0 && $row['maNhaCungCap'] != $maNhaCungCap) {
                    $errors['soDienThoai'] = 'Số điện thoại đã tồn tại';
                } else {
                    $soDienThoai= $_POST['soDienThoai'];
                }
            } else {
                $errors['soDienThoai'] = 'Số điện thoại không tồn tại';
            }                
            
        }
        if(!empty($errors)){
            $mess='Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            ?>
                <div class="alert">
                    <?php echo $mess; ?>
                </div>
        <?php
        }
        else{
            $tenNhaCungCap= $_POST['tenNhaCungCap'];
            $diaChi=$_POST['diaChi'];
            $email=$_POST['email'];       
            $soDienThoai=$_POST['soDienThoai'];        
            $query="UPDATE nhacungcap SET tenNhaCungCap='".$tenNhaCungCap."',diaChi='".$diaChi."',email='".$email."',soDienThoai='".$soDienThoai."' WHERE maNhaCungCap='".$maNhaCungCap."'"; 
            $result= mysqli_query($conn, $query);
            if($result>0)
              echo '<script>
                alert("Cập nhật thành công");
                window.location.href="index.php";
                 </script>';
            else 
                echo 'Lỗi sửa dữ liệu';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhà cung cấp</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>
    <div class="container">
    <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/" alt="">
                    <h2>NOUS<span> ADMIN</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="sidebar">
                <a href="../index.php" class="">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                
                <a href="../staff/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Nhân viên</h3>
                </a>

                <a href="../order/" class="">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h3>Đơn hàng</h3>
                </a>

                <a href="../Nhacungcap/" class="active">
                    <i class="fa-solid fa-clipboard"></i>
                    <h3>Nhà cung cấp</h3>
                </a>

                <a href="../DanhMuc/" class="">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    
                </a>

                <a href="../products/" class="">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                
                <a href="../promotion/" class="">
                    <i class="fa-solid fa-ticket"></i>
                    <h3>Khuyến mãi</h3>
                </a>
                <a href="/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <main>
            <div class="main">
                <div id="back">
                    <i class= "fa-solid fa-angle-left"></i>
                    <a href="index.php" class="btn">Danh sách nhà cung cấp</a>
                </div>
                <div class="wrapper">
                <h3 style="text-align: center" class="title">Sửa nhà cung cấp</h3>
                <form method="POST" id ="form">
                    <div class="form-group">
                        <label for="">Mã nhà cung cấp</label>
                        <input type="text" class="form-control" name="txtid" value=<?php  echo $maNhaCungCap?> disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Tên nhà cung cấp</label>
                        <input type="text" class="form-control" name="tenNhaCungCap"
                            placeholder="Hãy nhập tên nhà cung cấp" value="<?php echo $tenNhaCungCap ?>">
                        <?php 
                        echo (!empty($errors['tenNhaCungCap']))?'<span class="error">'.$errors['tenNhaCungCap'].'</span>':false;
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi" placeholder="Hãy nhập địa chỉ..."
                            value="<?php echo $diaChi ?>">
                        <?php 
                            if(!empty($errors)){                        
                                if(!empty($errors['diaChi'])){
                                    echo '<div class="error">'.
                                            $errors['diaChi'].'
                                    </div>';
                                }
                            }  
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Hãy nhập email..."
                            value="<?php echo $email ?>">
                        <?php 
                            if(!empty($errors)){                        
                                if(!empty($errors['email'])){
                                    echo '<div class="error">'.
                                            $errors['email'].'
                                    </div>';
                                }
                            }  
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control" name="soDienThoai"
                            placeholder="Hãy nhập số điện thoại..." value="<?php echo $soDienThoai ?>">
                        <?php 
                            if(!empty($errors)){                        
                                if(!empty($errors['soDienThoai'])){
                                    echo '<div class="error">'.
                                            $errors['soDienThoai'].'
                                    </div>';
                                }
                            }  
                        ?>
                    </div>
                    <div id="button_add">
                        <button type="submit" class="btn btn-primary" name="btnSave" id="btnSubmit">Ghi dữ liệu</button>
                    </div>
                </form>
                </div>
            </div>
        </main>
</body>
</html>
