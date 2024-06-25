<?php 
    require_once '../../connect.php';  
    $key= "MDM";
    $query="SELECT max(CONVERT(SUBSTRING(maDanhMuc, 4), int)) as nid FROM `danhmuc`";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0)
    {
        $data = mysqli_fetch_assoc($result)['nid'];          
        $id = $key . ($data + 1);
    }
    else{
        $id = $key."1";
    }
    $categories = array();      
    $q1 = "select * from danhmuc";
    $result1 = mysqli_query($conn,$q1);
    if(mysqli_num_rows($result1)>0)
    {
        while ($row = mysqli_fetch_assoc($result1)){
            $categories[] = $row;
        }            
    }   
?> 
<hr/>;
<?php
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $errors=[];
        if(empty(trim($_POST['txtDanhMuc']))){
            $errors['txtDanhMuc']='Tên danh mục không được để trống';
        }
        else{
            $txtDanhMuc= $_POST['txtDanhMuc'];
        } 
        if(empty(trim($_POST['txtDuongDan']))){
            $errors['txtDuongDan']='Không được để trống đường dẫn';
        }
        else{        
            $txtDuongDan= $_POST['txtDuongDan'];        
        }
        if(!empty($_POST['txtDmCha'])){
            $txtDmCha= $_POST['txtDmCha'];
        }       
        else{
            $txtDmCha = -1;
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
            $maDanhMuc = $id;
            $tenDanhMuc= $_POST['txtDanhMuc'];
            $url=$_POST['txtDuongDan'];
            $danhMucCha=$_POST['txtDmCha'] != 0 ? $_POST['txtDmCha'] : -1;      
            $vitri=$_POST['txtVitri'];      
            $query="INSERT INTO danhmuc VALUES('".$maDanhMuc."', '".$tenDanhMuc."','".$url."','".$danhMucCha."','".$vitri."')"; 
            var_dump($query);
            $result= mysqli_query($conn, $query);
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
                <a href="index.php" class="btn">Danh sách danh mục</a>
                <hr />
                <h3 style="text-align: center">Thêm nhà danh mục</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="inputEmail4">Mã danh mục</label>
                        <input disabled type="text" class="form-control" name="txtMa" value=<?php  echo $id?>>
                    </div>  
                            
                    <div class="form-group">
                        <label for="inputAddress">Tên danh mục</label>
                        <input type="text" class="form-control" id="txtDanhMuc" name="txtDanhMuc" placeholder="Tên danh mục" oninput="updateInput2()" value="<?php if(isset($txtDanhMuc)) echo $txtDanhMuc; ?>">
                        <?php 
                            echo (!empty($errors['txtDanhMuc']))?'<span class="error">'.$errors['txtDanhMuc'].'</span>':false;
                        ?> 
                    </div>

                    <div class="form-group">
                        <label for="inputAddress2"> Đường dẫn </label>
                        <input type="text" class="form-control" id="txtDuongDan" name="txtDuongDan" placeholder="Đường dẫn" value="<?php if(isset($txtDuongDan)) echo $txtDuongDan; ?>">
                        <?php 
                            echo (!empty($errors['txtDuongDan']))?'<span class="error">'.$errors['txtDuongDan'].'</span>':false;
                        ?> 
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                        <label for="inputState">Danh mục cha</label>
                        <select id="inputState" class="form-control" name="txtDmCha">
                            <option value="-1">Danh mục cha</option>
                            <?php 
                                    foreach ($categories as $key => $item)
                                    {
                                    echo '<option name="txtDmCha" value= '.$item['maDanhMuc'].'>'.$item['tenDanhMuc'].'</option>';
                                    }
                            ?>             
                        </select>
                        </div>        
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2"> Ví trí </label>
                        <input type="text" class="form-control" id="txtVitri" name="txtVitri" placeholder="vị trí danh mục..." value="<?php if(isset($vitri)) echo $vitri; ?>">
                        <?php 
                            echo (!empty($errors['txtVitri']))?'<span class="error">'.$errors['txtVitri'].'</span>':false;
                        ?> 
                    </div>
                    <button type="submit" class="btn btn-primary">Ghi dữ liệu</button>
                </form> 
                <script>
                function convertToSlug(str) {
                    // Chuyển các ký tự có dấu thành không dấu và chuyển sang chữ thường
                    str = str.toLowerCase().replace(/ă/g, 'a').replace(/â/g, 'a').replace(/đ/g, 'd').replace(/ê/g, 'e').replace(/ô/g, 'o').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ /g, '-');
                    return str;
                }
                function updateInput2() {
                    var input1Value = document.getElementById("txtDanhMuc").value;x
                    document.getElementById("txtDuongDan").value =convertToSlug(input1Value) +'.php';
                }
            </script>
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
            str = str.toLowerCase().replace(/ă/g, 'a').replace(/â/g, 'a').replace(/đ/g, 'd').replace(/ê/g, 'e').replace(/ô/g, 'o').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ /g, '-');
            return str;
        }
        function removeAccents(str) {
                return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            }
        function updateInput2() {
            var input1Value = document.getElementById("txtDanhMuc").value;
            document.getElementById("txtDuongDan").value = removeAccents(convertToSlug(input1Value));
        }
    </script>
</body>

</html>
