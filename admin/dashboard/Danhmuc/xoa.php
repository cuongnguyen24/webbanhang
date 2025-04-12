<?php
    $maDanhMuc=$_GET['maDanhMuc'];          
    require_once '../../connect.php';
    //tìm danh muc con của thằng đang muốn xóa
    $query_Child = "select * from danhmuc where danhMucCha = '$maDanhMuc'";
    $result_Child = mysqli_query($conn, $query_Child);
    if(mysqli_num_rows($result_Child)>0)
    {
        while ($row = mysqli_fetch_assoc($result_Child)){            
            $maDMChild = $row["maDanhMuc"];
            $query_Parant = "select danhMucCha from danhmuc where maDanhMuc = '$maDanhMuc'";
            $result_Parant = mysqli_query($conn, $query_Parant);
            if(mysqli_num_rows($result_Parant)>0)
            {
                $data = mysqli_fetch_assoc($result_Parant)['danhMucCha']; 
                //tăng cấp cho mấy thằng con
                $queryUpdate = "UPDATE danhmuc SET danhMucCha ='".$data."' where maDanhMuc = '$maDMChild'";
                //delete from danhmuc where maDanhMuc='$maDMParant';
                mysqli_query($conn, $queryUpdate);
            }            
        }            
    } 
    $query1 = "select * from sanpham where maDanhMuc = '$maDanhMuc'";
    $result1 = mysqli_query($conn, $query1);

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
    $query="delete from danhmuc where maDanhMuc='$maDanhMuc'";            
    $result= mysqli_query($conn, $query);
    if($result>0)
        echo '<script>
            alert("Xóa thành công");
            window.location.href="index.php";
        </script>';
    else 
        echo 'Lỗi xóa dữ liệu';
?>