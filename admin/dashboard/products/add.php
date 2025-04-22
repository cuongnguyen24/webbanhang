<?php 
    session_start();
    require_once '../../connect.php';  
    $key= "MSP";
    //$query="SELECT max(CONVERT(SUBSTRING(maSanPham, 4), int)) as nid FROM `sanpham`";
    $query="SELECT max(SUBSTRING(maSanPham, 4)+0) as nid FROM `sanpham`";
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
        $first_img = '';
        // Define maxsize for files i.e 2MB
        $maxsize = 2 * 1024 * 1024; 
        // Checks if user sent an empty form 
        if(!empty(array_filter($_FILES['fileToUpload']['name']))) {
    
            // Loop through each file in files[] array
            foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $value) {
                //lay tgian htai
                $dt = strtotime("now");
                //ten file htai
                $file_tmpname = $_FILES['fileToUpload']['tmp_name'][$key];   
                //kthuoc file           
                $file_size = $_FILES['fileToUpload']['size'][$key];
                // lấy đuôi file
                $file_ext = pathinfo($_FILES['fileToUpload']['name'][$key], PATHINFO_EXTENSION);     
                // tạo file name= tgian+ đuôi file      
                $file_name = $dt.'.'.strtolower($file_ext);
                // Set upload file path
                $filepath = $upload_dir.$file_name;
                $duongdanchung = $filepath;
                // ktra đuôi file
                if(in_array(strtolower($file_ext), $allowed_types)) {
    
                    // check file size - 2MB max 
                    if ($file_size > $maxsize)         
                        echo "Error: File size is larger than the allowed limit."; 
    
                    // If file with name already exist then append time in
                    // front of name of the file to avoid overwriting of file
                    // ktra ten file da ton tai hay chua
                    if(file_exists($filepath)) {
                        //ton tai-> đặt lại tên
                        $filepath = $upload_dir.time().$file_name;
                        //upload
                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            echo "{$file_name} successfully uploaded <br />";
                        } 
                        else {                     
                            echo "Error uploading {$file_name} <br />"; 
                        }
                    }
                    // file chua ton tai -> ap len
                    else {
                    
                        if( move_uploaded_file($file_tmpname, $filepath)) {
                            echo "{$file_name} successfully uploaded <br />";
                        }
                        else {                     
                            echo "Error uploading {$file_name} <br />"; 
                        }
                    }
                    // $first_img= $filepath
                }
                
                //loi
                else {
                    
                    // If file extension not valid
                    echo "Error uploading {$file_name} "; 
                    echo "({$file_ext} file type is not allowed)<br / >";
                } 
                if($_FILES['fileToUpload']['tmp_name'][0])
                {
                    $first_img = $duongdanchung;
                }
                $query = "INSERT INTO anhsanpham VALUES('".$id."','".$filepath."', '".Null."')";     
                mysqli_query($conn, $query);
                
            }
            
        }
        return $first_img;
    }   
?>
<?php
 $query= "select *from size order by tenSize" ;                        
 $result= mysqli_query($conn, $query);
 // chay cau query
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
            $id_size =  $item["maSize"];
            // if(empty($_POST[$id])){
            //     $errors['cboMaSize']="Bạn cần chọn size";
            // }
           
                if (isset($_POST[$id_size]) && isset($_POST[$id_size . '_text'])) {
                    $value = $_POST[$id_size . '_text'];
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
            echo $id;
            $tenSanPham= $_POST['tenSanPham'];
            $maNhaCungCap=$_POST['cboNhaCungCap'];
            $maDanhMuc=$_POST['cboDanhMuc'];         
            $giaBan=$_POST['giaBan'];   
            $chitietsp=$_POST['chitietsp'];
            $moTaSanPham=$_POST['mota'];
            $maTK = $_SESSION["maTaiKhoan"];
            $queryTk = "select * from quanly where maTaiKhoan = '$maTK' limit 1";
            $result1= mysqli_query($conn, $queryTk);
            $maqly = mysqli_fetch_assoc($result1);
            $query="INSERT INTO sanpham VALUES('".$id."','".$tenSanPham."','".$maNhaCungCap."','".$maDanhMuc."','".$maqly['maQuanLy']."','".$giaBan."','".$moTaSanPham."','".$chitietsp."','')";  
            $result= mysqli_query($conn, $query);
            foreach ($items as $index => $item) {
                // lay ma size
                $id_size =  $item["maSize"];
                // ktra gưi thong tin cua size && số lượng
                if (isset($_POST[$id_size]) && isset($_POST[$id_size . '_text'])){
                    // số lượng
                    $value = $_POST[$id_size . '_text'];   
                }
                else
                {
                    $value = 0;
                }
                $querySize = "INSERT INTO sizesanpham VALUES('".$id."','".$id_size."','".$value."')";
                    mysqli_query($conn, $querySize);
                
            }
            $duongdanchung = uploadImage($id, $conn);
            // lay anh dau tien hiện thị
            $query1="UPDATE sanpham SET duongDanAnhChung='".$duongdanchung." 'where maSanPham='".$id."'"; 
            mysqli_query($conn, $query1);
            if($result>0)
            {
                echo 'Thêm mới thành công';
                // echo '<script>
                //     alert("Thêm thành công");
                //     window.location.href = "./index.php";
                // </script>';
                $foldername = $chitietsp;
                $dir = $_SERVER['DOCUMENT_ROOT']  . $foldername ;

                $file_to_write = 'index.php';
                $content_to_write = file($_SERVER["DOCUMENT_ROOT"] . '\admin\dashboard\products\create-product.txt');
                echo '<br>' .$dir .$file_to_write;
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }

                $file = fopen($dir . '/' . $file_to_write,"w");

                foreach ($content_to_write as $line) {
                    fwrite($file, $line);
                }
                fclose($file);

                include $dir . '/' . $file_to_write;
                echo '<script>
                alert("Thêm thành công!");
                window.location.href = "./index.php";
            </script>';
            }
            else 
               echo '<script>
                    alert("Thêm thất bại!");
                    window.location.href = "./index.php";
                </script>';

        

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới sản phẩm</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .input_sl{
                margin-left: 20px;
            }
        </style>
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

                <a href="../Nhacungcap/" class="">
                    <i class="fa-solid fa-clipboard"></i>
                    <h3>Nhà cung cấp</h3>
                </a>

                <a href="../Danhmuc/" class="">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    
                </a>

                <a href="../products/" class="active">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>

                <a href="../promotion/" class="">
                    <i class="fa-solid fa-ticket"></i>
                    <h3>Khuyến mãi</h3>
                </a>

                <a href="/webbanhang/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <main>
            <div class="main">
                <div id="back">
                    <i class= "fa-solid fa-angle-left"></i>
                    <a href="index.php" class="btn">Danh sách sản phẩm</a>
                </div>
                <div class="wrapper">
                <h3 style="text-align: center" class="title">Thêm mới sản phẩm</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="masv">Mã sản phẩm</label>
                        <input type="text" class="form-control" name="txtid" value=<?php  echo $id?> disabled>                
                    </div>
                    <div class="form-group">
                        <label for="tensv">Tên sản phẩm</label>
                        <input type="text" class="form-control" id= "txtSanPham" name="tenSanPham"  placeholder="Hãy nhập tên sản phẩm..." oninput="updateInput2()" value="<?php if(isset($tenSanPham)) echo $tenSanPham; ?>">
                    <?php 
                            echo (!empty($errors['tenSanPham']))?'<span class="error">'.$errors['tenSanPham'].'</span>':false;
                    ?>                
                    </div>
        
                    <div class="form-group">
                        <label for="">Nhà cung cấp</label>
                        <select name="cboNhaCungCap" class="form-control">
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
                        <select name="cboDanhMuc" class="form-control">
                            <option value="">Chọn danh mục</option>
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
                                    echo "<div style='display: flex; margin-top:5px'>";
                                    //size
                                    echo "<input type='checkbox' id='$id_size' name='$id_size' onchange='toggleInput(\"$id_size\")'>";
                                    echo "<label for='$id_size'>$ten_size</label>";
                                    echo "<div class='input_sl'>";
                                    //soluong
                                    echo "<input type='text' style='border: 1px solid #f1eeee;'' id='{$id_size}_text' name='{$id_size}_text' disabled>";
                                    echo "</div>";
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
                        <label for="inputAddress2"> Link chi tiết sản phẩm </label>
                        <input type="text" class="form-control" id="chitietsp" name="chitietsp" placeholder="Link chi tiết sản phẩm" value="<?php if(isset($chitietsp)) echo $chitietsp; ?>">
                        
                    </div>

                    <!-- <div class="form-group">
                        <label for="inputAddress2"> Đường dẫn ảnh chung </label>
                        <input type="text" class="form-control" id="duongdanchung" name="duongdanchung" placeholder="Đường dẫn ảnh chung" value="<?php if(isset($duongdanchung)) echo $duongdanchung; ?>">
                        
                    </div> -->
        
                    <div class="form-group">
                        <label for="">Mô tả sản phẩm</label>
                        <textarea name="mota" id="mota" class="form-control" placeholder="Hãy nhập mô tả sản phẩm..." value="<?php if(isset($mota)) echo $mota; ?>" ></textarea> 
                        <?php 
                                echo (!empty($errors['mota']))?'<span class="error">'.$errors['mota'].'</span>':false;
                        ?>                
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <input name ="fileToUpload[]" type="file"  id="imgSP" onchange="displayImage(this)"  multiple>

                        <!-- <div class="right-procduct-tool-img" id="imageContainer"></div> -->
                    </div>
                    <div id="button_add">
                        <button type="submit" class="btn btn-primary" id="btnSubmit">Ghi dữ liệu</button>
                    </div>
                    </form> 
                    </div>
                </main>
</body>
<script>
    //khi kích vào size thì hthi ô sl
        function toggleInput(checkboxId) {
            var checkbox = document.getElementById(checkboxId);
            var textInput = document.getElementById(checkboxId + '_text');
            textInput.disabled = !checkbox.checked;
        }
        
</script>
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
            var input1Value = document.getElementById("txtSanPham").value;
            document.getElementById("chitietsp").value = '/webbanhang/products/' + removeAccents(convertToSlug(input1Value))+'/';
        }
    </script>
    <script>
// function displayImage(input) {
//     var imageContainer = document.getElementById("imageContainer");
//     imageContainer.innerHTML = "";
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();

//         reader.onload = function(e) {
//             var image = document.createElement("img");
//             image.src = e.target.result;
//             image.setAttribute("width", "70px");
//             imageContainer.appendChild(image);
//         };
//         reader.readAsDataURL(input.files[0]);
//     }
// }
</script>
</html>
