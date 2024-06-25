<?php
    require_once '../../connect.php';
    $maNhaCungCap=$_GET['maNhaCungCap'];          
   
    $query="delete from nhacungcap where maNhaCungCap='$maNhaCungCap'";            
    $result= mysqli_query($conn, $query);
    if($result>0)
        echo '<script>
            alert("Xóa thành công");
            window.location.href="index.php";
        </script>';
    else 
        echo 'Lỗi xóa dữ liệu';
?> 