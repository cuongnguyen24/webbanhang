<?php
    require_once '../../connect.php';
    $maNhaCungCap=$_GET['maNhaCungCap'];     
   
    $r1="select * from sanpham where maNhaCungCap='$maNhaCungCap'";
    $rs1= mysqli_query($conn, $r1);
    while($row = mysqli_fetch_assoc($rs1)){
        $maSanPham=$row["maSanPham"];
        $sql1="select * from anhsanpham where maSanPham='$maSanPham'";
        $rs= mysqli_query($conn, $sql1);
        while($row = mysqli_fetch_assoc($rs)){
            unlink($row['duongDanAnh']);
            $query="delete from anhsanpham where maAnh=".$row['maAnh'];                     
            $result= mysqli_query($conn, $query);
        }   

        $sql11="select * from sizesanpham where maSanPham='$maSanPham'";
        $rs1= mysqli_query($conn, $sql11);
        while($row = mysqli_fetch_assoc($rs1)){
            $id_size =  $row["maSize"];
            $query="DELETE FROM sizesanpham WHERE  maSanPham = '$maSanPham' and maSize = '$id_size'";                     
            mysqli_query($conn, $query);
    }   
    }   
    $query1="delete from sanpham where maNhaCungCap='$maNhaCungCap'";  
    echo $query1;
    $result1= mysqli_query($conn, $query1); 
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