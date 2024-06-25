<?php 
    require_once '../../connect.php';  
    $key= "MSP";
    $query="SELECT max(CONVERT(SUBSTRING(maSanPham, 4), int)) as nid FROM `sanpham`";
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
    $q1 = "select * from sanpham";
    $result1 = mysqli_query($conn,$q1);
    if(mysqli_num_rows($result1)>0)
    {
        while ($row = mysqli_fetch_assoc($result1)){
            $categories[] = $row;
        }            
    }   
?> 
<?php
    function uploadImage($id, $conn){        
        
        $upload_dir = 'uploads/';
        $allowed_types = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        
        // Define maxsize for files i.e 2MB
        $maxsize = 2 * 1024 * 1024; 
    
        // Checks if user sent an empty form 
        if(!empty(array_filter($_FILES['fileToUpload']['name']))) {
    
            // Loop through each file in files[] array
            foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $value) {
                $dt = strtotime("now");
                $file_tmpname = $_FILES['fileToUpload']['tmp_name'][$key];              
                $file_size = $_FILES['fileToUpload']['size'][$key];
                $file_ext = pathinfo($_FILES['fileToUpload']['name'][$key], PATHINFO_EXTENSION);           
                $file_name = $dt.'.'.strtolower($file_ext);
                // Set upload file path
                $filepath = $upload_dir.$file_name;
    
                // Check file type is allowed or not
                if(in_array(strtolower($file_ext), $allowed_types)) {
    
                    // Verify file size - 2MB max 
                    if ($file_size > $maxsize)         
                        echo "Error: File size is larger than the allowed limit."; 
    
                    // If file with name already exist then append time in
                    // front of name of the file to avoid overwriting of file
                    if(file_exists($filepath)) {
                        $filepath = $upload_dir.time().$file_name;
                        
                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            echo "{$file_name} successfully uploaded <br />";
                        } 
                        else {                     
                            echo "Error uploading {$file_name} <br />"; 
                        }
                    }
                    else {
                    
                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            echo "{$file_name} successfully uploaded <br />";
                        }
                        else {                     
                            echo "Error uploading {$file_name} <br />"; 
                        }
                    }
                }
                else {
                    
                    // If file extension not valid
                    echo "Error uploading {$file_name} "; 
                    echo "({$file_ext} file type is not allowed)<br / >";
                } 
                $query = "INSERT INTO anhsanpham VALUES('".$id."','".$filepath."', '".Null."')";     
                mysqli_query($conn, $query);
            }
        }
    }   
?>
<?php
 $query= "select *from size order by tenSize" ;                        
 $result= mysqli_query($conn, $query);
 while($row = $result->fetch_assoc()) {
     $items[] = $row;
 }
?>
<?php
    if($_SERVER['REQUEST_METHOD']=="POST")
    {        
        $errors=[];       
        if(empty(trim($_POST['tenSanPham']))){
            $errors['tenSanPham']='Tên sản phẩm không được để trống';
        }
        else{
            $tenSanPham= $_POST['tenSanPham'];
        } 
        if(empty($_POST['cboNhaCungCap'])){
            $errors['cboNhaCungCap']="Bạn cần chọn nhà cung cấp";
        }
        else{
            $cboNhaCungCap= $_POST['cboNhaCungCap'];
        }
        if(empty($_POST['cboDanhMuc'])){
            $errors['cboDanhMuc']="Bạn cần chọn danh mục";
        }
        else{
            $cboDanhMuc= $_POST['cboDanhMuc'];
        }
        foreach ($items as $index => $item) {
            $id =  $item["maSize"];
            // if(empty($_POST[$id])){
            //     $errors['cboMaSize']="Bạn cần chọn size";
            // }
           
                if (isset($_POST[$id]) && isset($_POST[$id . '_text'])) {
                    $value = $_POST[$id . '_text'];
                    if(empty(trim($value))){
                        $errors['soLuong']='Không được để trống số lượng của size'.$item["tenSize"];
                        break;
                    }
                    else{        
                        if(is_numeric($value)){
                            $sl = (int)$value;
                            if($sl < 0 ){
                                $errors['soLuong'] = 'Sai định dạng';
                                break;
                            }                    
                        } 
                        else{
                            $errors['soLuong'] = 'Sai định dạng';
                            break;
                        }   
                    }
                
            }
           
        }       
       
        if(empty(trim($_POST['giaBan']))){
            $errors['giaBan']='Không được để trống giá bán';
        }
        else{        
            if(is_numeric($_POST['giaBan'])){
                $sl = (int)$_POST['giaBan'];
                echo $sl;
                if($sl < 0 ){
                    $errors['giaBan'] = 'Sai định dạng';
                }else
                    $soLuong= $_POST['giaBan'];
            } 
            else{
                $errors['giaBan'] = 'Sai định dạng';
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
            $masv = $id;
            $tenSanPham= $_POST['tenSanPham'];
            $maNhaCungCap=$_POST['cboNhaCungCap'];
            $maDanhMuc=$_POST['cboDanhMuc'];         
            $giaBan=$_POST['giaBan'];   
            $moTaSanPham=$_POST['mota'];
            $conn= mysqli_connect("localhost","root","","webbanhang1");
            if(!$conn)
            {
                echo 'Kết nối không thành công, lỗi:'.mysqli_connect_error();
            }
            else{
                $query="INSERT INTO sanpham VALUES('".$id."','".$tenSanPham."','".$maNhaCungCap."','".$maDanhMuc."','ql01','".$giaBan."','".$moTaSanPham."')";  
                $result= mysqli_query($conn, $query);
                foreach ($items as $index => $item) {
                    $id_size =  $item["maSize"];
                    if (isset($_POST[$id_size]) && isset($_POST[$id_size . '_text'])){
                        $value = $_POST[$id_size . '_text'];
                        $querySize = "INSERT INTO sanphamsize VALUES('".$id."','".$id_size."','".$value."')";
                        mysqli_query($conn, $querySize);
                    }
                    
                }
                if($result>0)
                    echo 'Thêm mới thành công';
                else 
                    echo 'Lỗi thêm mới';
            }
        }
            uploadImage($id, $conn);
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
                <h3 style="text-align: center">Thêm mới sản phẩm</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="masv">Mã sản phẩm</label>
                        <input type="text" class="form-control" name="txtid" value=<?php  echo $id?> disabled>                
                    </div>
                    <div class="form-group">
                        <label for="tensv">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="tenSanPham"  placeholder="Hãy nhập tên sản phẩm..." value="<?php if(isset($tenSanPham)) echo $tenSanPham; ?>">
                    <?php 
                            echo (!empty($errors['tenSanPham']))?'<span class="error">'.$errors['tenSanPham'].'</span>':false;
                    ?>                
                    </div>
        
                    <div class="form-group">
                        <label for="">Nhà cung cấp</label>
                        <select name="cboNhaCungCap">
                            <option value="">Chọn Nhà Cung Cấp</option>
             
                            <?php 
                                if(!$conn)
                                {
                                    echo 'Kết nối không thành công, lỗi:'.mysqli_connect_error();
                                }
                                else{
                                    $query= "select *from nhacungcap order by tenNhaCungCap" ;
                                    echo $query;
                                    $result= mysqli_query($conn, $query);
                                    while($row=mysqli_fetch_assoc($result)){
                                        ?>
                                            <option value="<?php echo $row['maNhaCungCap'];?>"><?php echo $row['tenNhaCungCap'];?></option>
                                        <?php 
                                    }
                                }
                            ?>
                        </select>
                        <span class="error"><?php if(isset($errors['cboNhaCungCap'])) echo $errors['cboNhaCungCap'] ;?></span>
                    </div>

                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select name="cboDanhMuc">
                            <option value="">Chọn danh mục</option>
                            <!-- <option <?php if(isset($cboDanhMuc) && $cboDanhMuc=="") echo "selected='selected'"; ?> value="0">Tiến sĩ</option> -->
                            <?php 
                                require_once '../../connect.php';  
                                $query= "select *from danhmuc order by tenDanhMuc" ;                       
                                $result= mysqli_query($conn, $query);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                        <option value="<?php echo $row['maDanhMuc'];?>"><?php echo $row['tenDanhMuc'];?></option>
                                    <?php 
                                }
                            ?>
                        </select>
                        <span class="error"><?php if(isset($errors['cboDanhMuc'])) echo $errors['cboDanhMuc'] ;?></span>
                    </div>

                    <div class="form-group">
                        <label for="">Size - Số lượng sản phẩm</label>
                        <?php 
                                foreach ($items as $index => $item) {
                                    $id_size = $item["maSize"];
                                    $ten_size = $item['tenSize'];
                                    echo "<div style='display: flex'>";
                                    echo "<input type='checkbox' id='$id_size' name='$id_size' onchange='toggleInput(\"$id_size\")'>";
                                    echo "<label for='$id_size'>$ten_size</label>";
                                    echo "<input type='text' id='{$id_size}_text' name='{$id_size}_text' disabled>";
                                    echo "</div>";
                                }
                            ?>
                        <span class="error">
                            <?php 
                                if(isset($errors['cboMaSize'])) echo $errors['cboMaSize'] ;
                                if(isset($errors['soLuong'])) echo $errors['soLuong'] ;
                            ?>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="">Giá bán</label>
                        <input type="text" class="form-control" name="giaBan"  placeholder="Hãy nhập giá bán sản phẩm..." value="<?php if(isset($giaBan)) echo $giaBan; ?>">
                        <?php 
                                echo (!empty($errors['giaBan']))?'<span class="error">'.$errors['giaBan'].'</span>':false;
                        ?>                
                    </div>
        
                    <div class="form-group">
                        <label for="">Mô tả sản phẩm</label>
                        <textarea name="mota" id="mota" class="form-control" placeholder="Hãy nhập mô tả sản phẩm..." value="<?php if(isset($mota)) echo $mota; ?>" ></textarea> 
                        <?php 
                                echo (!empty($errors['mota']))?'<span class="error">'.$errors['mota'].'</span>':false;
                        ?>                
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <input name ="fileToUpload[]" type="file" multiple>
                    </div>
                            <button type="submit" class="btn btn-primary">Ghi dữ liệu</button>
                    </form> 
                    </div>
        </main>
        <!-- <div class="right">
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
            </div> -->

            <!-- END OF TOP -->
            <!-- <div class="recent_updates">
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
            </div> -->
            <!-- -------------------END OF RECENT UPDATES ------------------ -->
            <!-- <div class="sales_analytics">
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
                </div> -->


                <!-- <div class="item customers">
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
                </div> -->


                <!-- <div class="item boom">
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
    </div> -->
    
</body>
<script>
        function toggleInput(checkboxId) {
            var checkbox = document.getElementById(checkboxId);
            var textInput = document.getElementById(checkboxId + '_text');
            textInput.disabled = !checkbox.checked;
        }
</script>
</html>
