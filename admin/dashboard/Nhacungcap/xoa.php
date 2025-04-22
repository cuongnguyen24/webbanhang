<?php
    require_once '../../connect.php';
    $maNhaCungCap=$_GET['maNhaCungCap'];     
    $query1="select * from sanpham where maNhaCungCap='$maNhaCungCap'";
    $result1= mysqli_query($conn, $query1);
    if(mysqli_num_rows($result1)>0)
    {        
        while ($row = mysqli_fetch_assoc($result1)){
            $maSanPham= $row['maSanPham'];
            $q1="select count(*) from chitietdonhang where maSanPham='$maSanPham'";
            $r1=mysqli_query($conn, $q1);
            $q2="select count(*) from giohang where maSanPham='$maSanPham'";
            $r2=mysqli_query($conn, $q2);
            if($r1->fetch_row()[0]>0)
            {
            echo '<script>
                alert("Không xóa sản phẩm tồn tại trong chi tiết đơn hàng");
                window.location.href="index.php";
            </script>';
            }
            else if($r2->fetch_row()[0]>0)
            {
            echo '<script>
                alert("Không xóa sản phẩm tồn tại trong giỏ hàng");
                window.location.href="index.php";
            </script>';
            }else{
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
            }    
        }            
    } 
    // $query1="delete from sanpham where maNhaCungCap='$maNhaCungCap'";  
    // echo $query1;
    // $result1= mysqli_query($conn, $query1); 
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