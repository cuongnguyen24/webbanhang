<?php
    $maDanhMuc=$_GET['maDanhMuc'];          
    require_once '../../connect.php';
    //tìm danh muc con của thằng đang muốn xóa
    $query_Child = "select * from danhmuc where danhMucCha = '$maDanhMuc'";
    $result_Child = mysqli_query($conn, $query_Child);
    if(mysqli_num_rows($result_Child)>0)
    {
        while ($row = mysqli_fetch_assoc($result_Child)){
            //tìm thằng cha của thằng đang muốn xóa
            $maDMParant = $row["maDanhMuc"];
            $query_Parant = "select maDanhMuc from danhmuc where danhMucCha = '$maDMParant'";
            $result_Parant = mysqli_query($conn, $query_Parant);
            if(mysqli_num_rows($result_Parant)>0)
            {
                $data = mysqli_fetch_assoc($result_Parant)['maDanhMuc']; 
                //tăng cấp cho mấy thằng con
                $queryUpdate = "UPDATE danhmuc SET danhMucCha ='".$data."' where maDanhMuc = '$maDMParant'";
                mysqli_query($conn, $queryUpdate);
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