<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $maSanPham=$_GET['maSanPham'];          
    require_once '../../connect.php';
    //tim cac hinh anh cua san pham va xoa
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
    $query="delete from sanpham where maSanPham='$maSanPham'";      
    echo $query;      
    $result= mysqli_query($conn, $query);
    if($result>0)
        echo '<script>
            alert("Xóa thành công");
            window.location.href="index.php";
        </script>';
    else 
        echo 'Lỗi xóa dữ liệu';
?>  
</body>
</html>