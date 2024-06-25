<?php 
    require_once '../../connect.php';
    $key= "MNCC";
    $query = "SELECT max(CONVERT(SUBSTRING(maNhaCungCap, 5), int)) as nid FROM `nhacungcap`";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>=1)
    {
        $data = mysqli_fetch_assoc($result)['nid'];
        $id = $key . ((int)$data + 1);
    }else $id = $key . 1;
    
?>
<?php
    if($_SERVER['REQUEST_METHOD']=="POST")
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
            $diaChi =$_POST['diaChi'] ;
        }
        if(empty(trim($_POST['email']))){
            $errors['email']='Email không được để trống';
        }
        else{        
            $email = $_POST['email'];  
        }
        if(empty(trim($_POST['soDienThoai']))){
            $errors['soDienThoai']='Số điện thoại không được để trống';
        }
        else{        
            $soDienThoai= $_POST['soDienThoai'];
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
            $maNhaCungCap = $id;
            $tenNhaCungCap= $_POST['tenNhaCungCap'];
            $diaChi=$_POST['diaChi'];
            $email=$_POST['email'];       
            $soDienThoai=$_POST['soDienThoai'];         
           
            $query="INSERT INTO nhacungcap VALUES('".$maNhaCungCap."','".$tenNhaCungCap."','".$diaChi."','".$email."','".$soDienThoai."')"; 
            $result= mysqli_query($conn, $query);
            echo $query;
            if($result>0)
                echo 'Thêm mới thành công';
            else 
                echo 'Lỗi thêm mới';
            }
            
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../nhacungcap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a href="./index.html" class="">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                <a href="../customer/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Khách hàng</h3>
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

                <a href="../message/" class="">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    <span class="message-count">26</span>
                </a>

                <a href="../products/" class="">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="../report/" class="">
                    <i class="fa-solid fa-exclamation"></i>
                    <h3>Báo cáo</h3>
                </a>
                <a href="../settings/" class="">
                    <i class="fa-solid fa-gear"></i>
                    <h3>Cài đặt</h3>
                </a>
                <a href="#">
                    <i class="fa-solid fa-plus"></i>
                    <h3>Thêm sản phẩm</h3>
                </a>
                <a href="/websiteechcom/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <main>
            <div class="recent-order">
                <a href="index.php" class="btn">Danh sách sản phẩm</a>
                <hr />
                <h3 style="text-align: center">Thêm nhà cung cấp</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="">Mã nhà cung cấp</label>
                        <input type="text" class="form-control" name="txtid" value=<?php  echo $id?> disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Tên nhà cung cấp</label>
                        <input type="text" class="form-control" name="tenNhaCungCap" placeholder="Hãy nhập tên nhà cung cấp" value="<?php if(isset($tenNhaCungCap)) echo $tenNhaCungCap; ?>">
                        <?php 
                            echo (!empty($errors['tenNhaCungCap']))?'<span class="error">'.$errors['tenNhaCungCap'].'</span>':false;
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi" placeholder="Hãy nhập địa chỉ..." value="<?php if(isset($diaChi)) echo $diaChi; ?>">
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
                        <input type="text" class="form-control" name="email" placeholder="Hãy nhập email..." value="<?php if(isset($email)) echo $email; ?>">
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
                        <input type="text" class="form-control" name="soDienThoai" placeholder="Hãy nhập số điện thoại..." value="<?php if(isset($soDienThoai)) echo $soDienThoai; ?>">
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
                    <button type="submit" class="btn btn-primary">Ghi dữ liệu</button>
                </form> 
            </div>

        </main>
        <div class="right">
            <div class="top">
                <button id="menu_btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="theme-toggler">
                    <i class="fa-regular fa-sun active"></i>
                    <i class="fa-solid fa-moon"></i>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Bình đẹp trai</b></p>
                        <small class="text-muted"> Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="/assets/img/baby_homeAbout.webp" alt="">
                    </div>
                </div>
            </div>

            <!-- END OF TOP -->
            <div class="recent_updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile_photo">
                            <img src="" alt="">
                        </div>
                        <div class="message">
                            <p><b>Thùy Linh</b> received his order of Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile_photo">
                            <img src="" alt="">
                        </div>
                        <div class="message">
                            <p><b>Cường</b> received his order of Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile_photo">
                            <img src="" alt="">
                        </div>
                        <div class="message">
                            <p><b>Quang kun</b> received his order of Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------END OF RECENT UPDATES ------------------ -->
            <div class="sales_analytics">
                <h2>Sales Analytics</h2>
                <div class="item online">
                    <div class="icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ONLINE ORDERS</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="success"> +39%</h5>
                        <h3>3849</h3>
                    </div>
                </div>


                <div class="item customers">
                    <div class="icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ONLINE ORDERS</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="danger"> +20%</h5>
                        <h3>3849</h3>
                    </div>
                </div>


                <div class="item boom">
                    <div class="icon">
                        <i class="fa-solid fa-bomb"></i>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>BOM ORDERS</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="danger"> -20%</h5>
                        <h3>3849</h3>
                    </div>
                </div>

                <div class="item add_product">
                    <div>
                        <i class="fa-solid fa-square-plus"></i>
                        <h3>Add Product</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function convertToSlug(str) {
        // Chuyển các ký tự có dấu thành không dấu và chuyển sang chữ thường
        str = str.toLowerCase().replace(/ă/g, 'a').replace(/â/g, 'a').replace(/đ/g, 'd').replace(/ê/g, 'e').replace(
            /ô/g, 'o').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ /g,
            '-');
        return str;
    }

    function updateInput2() {
        var input1Value = document.getElementById("txtmessage").value;
        document.getElementById("txtDuongDan").value = convertToSlug(input1Value) + '.php';
    }
    </script>
</body>

</html>