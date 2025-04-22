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
                echo $query; 
                mysqli_query($conn, $query);
                $file_name = "";
            }
        }
    }   
?>
<?php
    if($_SERVER['REQUEST_METHOD']=="POST" ) //&& isset($_POST['btnSave'])
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
        if(empty(trim($_POST['soLuong']))){
            $errors['soLuong']='Không được để trống số lượng';
        }
        else{        
            if(is_numeric($_POST['soLuong'])){
                $sl = (int)$_POST['soLuong'];
                if($sl < 0 ){
                    $errors['soLuong'] = 'Sai định dạng';
                }else
                    $soLuong= $_POST['soLuong'];
            } 
            else{
                $errors['soLuong'] = 'Sai định dạng';
            }   
        }
        if(empty($_POST['cboMaSize'])){
            $errors['cboMaSize']="Bạn cần chọn size";
        }
        else{
            $cboMaSize= $_POST['cboMaSize'];
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
            $mess='Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            echo $mess;
            ?>
                <div class="alert">
                    <?php echo $mess; ?>
                </div>
            <?php
        }
        else{            
            require_once '../../connect.php'; 
            $tenSanPham= $_POST['tenSanPham'];
            $maNhaCungCap=$_POST['cboNhaCungCap'];
            $maDanhMuc=$_POST['cboDanhMuc'];       
            $soLuong=$_POST['soLuong'];
            $maSize=$_POST['cboMaSize'];      
            $giaBan=$_POST['giaBan'];   
            $moTaSanPham=$_POST['mota'];           
            $maTK = $_SESSION["maTaiKhoan"];
            $queryTk = "select * from quanly where maTaiKhoan = $maTK limit 1";
            $result1= mysqli_query($conn, $queryTk);
            $maqly = mysqli_fetch_assoc($result1);
            $query="UPDATE sanpham SET tenSanPham='".$tenSanPham."',maNhaCungCap='".$maNhaCungCap."',maQuanLy=' ".$maqly['maQuanLy']."',maDanhMuc='".$maDanhMuc."',soLuong='".$soLuong."',maSize='".$maSize."',giaBan='".$giaBan."',moTaSanPham='".$moTaSanPham."' where maSanPham='".$maSanPham."'"; 
            uploadImage($maSanPham, $conn);
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
<?php
    $arr= json_decode($_POST['arr']);     
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
?>
