<?php
    session_start();
    require_once '../../connect.php'; 
    $maSanPham = $_GET['maSanPham'];
    $tenSanPham="";
    $maNhaCungCap="";
    $maDanhMuc="";       
    $soLuong="";
    $maSize="";      
    $giaBan="";   
    $chitietsp="";
    $moTaSanPham="";
    $sanphamAll = [];
    $query="select sanpham.*,sizesanpham.soLuong, sizesanpham.maSize from sanpham INNER JOIN sizesanpham WHERE sanpham.maSanPham = sizesanpham.maSanPham and sanpham.maSanPham='".$maSanPham."'";  
    $result= mysqli_query($conn, $query);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            //lưu mảng sp = row
            $sanphamAll [] = $row;
            $tenSanPham=$row["tenSanPham"];
            $maNhaCungCap=$row["maNhaCungCap"];
            $maDanhMuc=$row["maDanhMuc"];                
            $giaBan=$row["giaBan"];
            $chitietsp=$row["chitietsp"];
            $moTaSanPham=$row["moTaSanPham"];                
        }
    }
?>  

<?php
    function uploadImage($id, $conn){        
        
        $upload_dir = 'uploads/';
        $allowed_types = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        
        // Define maxsize for files i.e 2MB
        $maxsize = 2 * 1024 * 1024; 
        $filePathChung = '';
        // Checks if user sent an empty form 
        if(!empty(array_filter($_FILES['fileToUpload']['name']))) {
    
            // Loop through each file in files[] array
            foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $value) {
                $dt = $key.strtotime("now");
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
                $file_name = "";
                $filePathChung = $filepath;
            }
        }
        return $filePathChung;
    }   
?>
<?php
 $query= "select * from size order by tenSize" ;                        
 $result= mysqli_query($conn, $query);
 while($row = $result->fetch_assoc()) {
     $items[] = $row;
 }
?>
<?php
    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['btnSave']))
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
        $check = false;
        foreach ($items as $index => $item) {
            $id =  $item["maSize"];
            // if($check == false && empty($_POST[$id])){
            //     $errors['cboMaSize']="Bạn cần chọn size".$_POST[$id];
            // } else{
            //     $check= true;
            //     array_diff($errors, ['cboMaSize']);
            // }          
            if (isset($_POST[$id]) && isset($_POST[$id . '_text'])) {
                $value = $_POST[$id . '_text'];
                echo $id . $value;
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
            var_dump($errors);
            $mess='Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            ?>
                <div class="alert">
                    <?php echo $mess; ?>
                </div>
            <?php
        }
        else{            
            $tenSanPham= $_POST['tenSanPham'];
            $maNhaCungCap=$_POST['cboNhaCungCap'];
            $maDanhMuc=$_POST['cboDanhMuc'];      
            $giaBan=$_POST['giaBan'];  
            $chitietsp=$_POST['chitietsp'];
            //mảng ảnh sp xóa
            $arr= json_decode($_POST['arr']); 
            if($arr > 0){
                foreach($arr as  $item){
                    $sql1="select * from anhsanpham where maAnh = $item";   
                    echo $sql1;    
                    $rs= mysqli_query($conn, $sql1);
                    while($row = mysqli_fetch_assoc($rs)){
                        unlink($row['duongDanAnh']);
                        $query="delete from anhsanpham where maAnh=".$row['maAnh'];                     
                        $result= mysqli_query($conn, $query);
                    }   
                }; 
            }
            $maTK = $_SESSION["maTaiKhoan"];
            $queryTk = "select * from quanly where maTaiKhoan = '$maTK' limit 1";
            $result1= mysqli_query($conn, $queryTk);
            $maqly = mysqli_fetch_assoc($result1);
            $duongdanchung = uploadImage($maSanPham, $conn);
            $query="UPDATE sanpham SET tenSanPham='".$tenSanPham."',maNhaCungCap='".$maNhaCungCap."',maQuanLy='".$maqly['maQuanLy']."',maDanhMuc='".$maDanhMuc."',giaBan='".$giaBan."',chitietsp='".$chitietsp."',moTaSanPham='".$moTaSanPham."' where maSanPham='".$maSanPham."'"; 
            $result= mysqli_query($conn, $query);
            foreach ($items as $index => $item) {
                $id_size =  $item["maSize"];
                $qSPSize="select * from sizesanpham where maSanPham = '$maSanPham' and maSize = '$id_size'";                     
                $rsSPSize= mysqli_query($conn, $qSPSize);
                if (isset($_POST[$id_size]) && isset($_POST[$id_size . '_text'])){
                    $value = $_POST[$id_size . '_text'];
                    if(mysqli_fetch_assoc($rsSPSize) == 0){
                        $querySize = "INSERT INTO sizesanpham VALUES('".$maSanPham."','".$id_size."','".$value."')";
                        mysqli_query($conn, $querySize);
                    }else{
                        $querySize = "UPDATE sizesanpham SET soLuong = $value Where maSanPham = '$maSanPham' and maSize = '$id_size' ";
                        mysqli_query($conn, $querySize);
                    }                       
                }else{
                    $value = 0;
                    $queryDeleteSize = "UPDATE sizesanpham SET soLuong = $value Where maSanPham = '$maSanPham' and maSize = '$id_size'";
                    echo $queryDeleteSize;
                    mysqli_query($conn, $queryDeleteSize);
                }
                
            }
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
    <title>Thêm mới sản phẩm</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../add.css">
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

                <a href="../DanhMuc/" class="">
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
                    <a href="index.php" class="btn">Danh sách sản phẩm</a>
                </div>
                <div class="wrapper">
                <h3 style="text-align: center" class="title">Sửa sản phẩm</h3>
                <form method="POST" id="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="masv">Mã sản phẩm</label>
                    <input type="text" class="form-control" id="txtid" name="txtid" value=<?php  echo $maSanPham ?> disabled>                
                </div>
                <div class="form-group">
                    <label for="tensv">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="tenSanPham"  placeholder="Hãy nhập tên sản phẩm..." value="<?php echo $tenSanPham; ?>">
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
                                $result= mysqli_query($conn, $query);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                        <option <?php if(isset($maNhaCungCap) && $maNhaCungCap == $row['maNhaCungCap']) echo "selected='selected'"; ?>  value="<?php echo $row['maNhaCungCap'];?>"><?php echo $row['tenNhaCungCap'];?></option>
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
                            if(!$conn)
                            {
                                echo 'Kết nối không thành công, lỗi:'.mysqli_connect_error();
                            }
                            else{
                                $query= "select *from danhmuc order by tenDanhMuc" ;                  
                                $result= mysqli_query($conn, $query);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                        <option <?php if(isset($maDanhMuc) && $maDanhMuc == $row['maDanhMuc']) echo "selected='selected'"; ?> value="<?php echo $row['maDanhMuc'];?>"><?php echo $row['tenDanhMuc'];?></option>
                                    <?php 
                                }
                            }
                        ?>
                    </select>
                    <span class="error"><?php if(isset($errors['cboDanhMuc'])) echo $errors['cboDanhMuc'] ;?></span>
                </div>

                <div class="form-group">
                <label for="">Size - Số lượng sản phẩm</label>
                    <?php 
                        $maSizeHienthi = [];
                        foreach ($items as $index => $item) {
                            $id_size = $item["maSize"];
                            $ten_size = $item['tenSize'];                        
                            foreach ($sanphamAll as $id => $sp){
                                if($sp["maSize"] === $id_size){
                                    $maSizeHienthi[] = $sp["maSize"];
                                    $soluong1 = $sp['soLuong'];
                                    echo "<div style='display: flex; margin-top:5px'>";
                                    echo "<input checked type='checkbox' id='$id_size' name='$id_size' onchange='toggleInput(\"$id_size\")'>";
                                    echo "<label for='$id_size'>$ten_size</label>";
                                    echo "<input type='text' style='border: 1px solid #f1eeee;margin-left:10px;border-radius:10px' 'id='{$id_size}_text' name='{$id_size}_text' value=$soluong1>";
                                    echo "</div>";
                                }
                            }                                      
                            if(in_array($id_size, $maSizeHienthi)==false){
                                echo "<div style='display: flex; margin-top:5px'>";
                                echo "<input type='checkbox' id='$id_size' name='$id_size' onchange='toggleInput(\"$id_size\")'>";
                                echo "<label for='$id_size'>$ten_size</label>";
                                echo "<input type='text'style='border: 1px solid #f1eeee;margin-left:10px;border-radius:10px'  id='{$id_size}_text' name='{$id_size}_text' disabled>";
                                echo "</div>";
                            }                    
                            
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
                    <input type="text" class="form-control" name="giaBan"  placeholder="Hãy nhập giá bán sản phẩm..." value="<?php echo $giaBan; ?>">
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
                    <textarea name="mota" id="mota" class="form-control" placeholder="Hãy nhập mô tả sản phẩm..."><?php echo $moTaSanPham; ?></textarea> 
                    <?php 
                            echo (!empty($errors['mota']))?'<span class="error">'.$errors['mota'].'</span>':false;
                    ?>                
                 </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="hidden" name="arr" id="anhXoa" value = "0">
                    </br>
                    <?php //hthi ảnh sp
                            if(!$conn)
                            {
                                echo 'Kết nối không thành công, lỗi:'.mysqli_connect_error();
                            }
                            else{
                                $query= "select * from anhsanpham where  maSanPham ='".$maSanPham."'";                                      
                                $result= mysqli_query($conn, $query);                       
                                echo '<div class="row" style="display: flex">';
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>       
                                        <?php $id = $row["maAnh"]  ?>                       
                                        <div class="mx-auto d-block">
                                            <a onclick="myFunction(<?php echo $id ?>)">
                                                <i class="fa fa-window-close" id=<?php echo "icon".$id ?>></i>
                                            </a>
                                            <img id=<?php echo $id ?> src =<?php echo $row["duongDanAnh"] ?> width="200px" height="180px"/>                                    
                                        </div>                                    
                                    <?php 
                                }
                                echo "</div>";  
                            }
                        ?>
                    <input style="margin-top:10px" name ="fileToUpload[]" type="file" multiple>
                </div> 
                <div id="button_add">
                        <button type="submit" class="btn btn-primary" name="btnSave" id="btnSubmit">Ghi dữ liệu</button>
                </div>
                </form>
                </div>
                </div>
    <script>
        let array = new Array();
        function myFunction(id){                
            let img = document.getElementById(id);     
            img.style.display = "none";
            let icon = document.getElementById("icon" + id);     
            icon.style.display = "none";
            array.push(id);
            // luu id mà ảnh xóa
            let imgXoa = document.getElementById("anhXoa"); 
            imgXoa.value = JSON.stringify(array);       
        }     
    </script>
    <script>
            function toggleInput(checkboxId) {
                var checkbox = document.getElementById(checkboxId);
                var textInput = document.getElementById(checkboxId + '_text');
                textInput.disabled = !checkbox.checked;            
            }
    </script>
</main>
</body>
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
            document.getElementById("chitietsp").value = removeAccents(convertToSlug(input1Value));
        }
    </script>
</html>
