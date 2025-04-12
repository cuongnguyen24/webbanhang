<?php
      require_once '../../connect.php';
      function getTenNCC($id){
        $conn = mysqli_connect("192.168.1.208","myuser","12ssss21","myproject_db");
        $qncc = "SELECT tenNhaCungCap from nhacungcap where maNhacungcap ='".$id."'";
        $source = mysqli_query($conn,$qncc);
        $row1= mysqli_fetch_assoc($source);
        return $row1['tenNhaCungCap'];
    }
    function getTenDM($id){
        $conn = mysqli_connect("192.168.1.208","myuser","12ssss21","myproject_db");
        $qncc = "SELECT tenDanhMuc from danhmuc where maDanhMuc ='".$id."'";
        $source = mysqli_query($conn,$qncc);
        $row1= mysqli_fetch_assoc($source);
        return $row1['tenDanhMuc'];
    }
    function gopData($data){     
        $groupedData = [];       
        foreach ($data as $row) {                
            $key = $row['maSanPham'] . $row['tenSanPham'] . $row['maNhaCungCap'] . $row['maDanhMuc'] . $row['maQuanLy'] . $row['giaBan'] . $row['moTaSanPham'];
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = $row;
                $groupedData[$key]['sizes'] = [];
            }
            $groupedData[$key]['sizes'][] = [
                'soLuong' => $row['soLuong'],
                'maSize' => $row['maSize']
            ];
        }   
        return $groupedData;      
    }   
    function getTenQL($id,$conn){                                    
        $queryTk = "select * from quanly where maQuanLy = '$id' limit 1";
        $result1= mysqli_query($conn, $queryTk);
        $maqly = mysqli_fetch_assoc($result1);
        return $maqly['hoTen'];
    }   
    function getSize($sizes){
        $html = '';
        foreach ($sizes as $size){
            $html .= $size['soLuong'] . ' ' . $size['maSize'] . '<br>';
            }    
            return $html;
    }   
      $keySearch= $_POST['key'];            
      $records_per_page = $_POST['page'];
      $current_page = $_POST['current_page'];          
      $start = ($current_page - 1) * $records_per_page;
      if($keySearch == "")
      {
          $query="select sanpham.*,sizesanpham.soLuong, sizesanpham.maSize from sanpham INNER JOIN sizesanpham WHERE sanpham.maSanPham = sizesanpham.maSanPham  order by CONVERT(SUBSTRING(sanpham.maSanPham, 4), int)";
      }
      else{
          $query="select sanpham.*,sizesanpham.soLuong, sizesanpham.maSize from sanpham INNER JOIN sizesanpham WHERE sanpham.maSanPham = sizesanpham.maSanPham and tenSanPham like N'%".$keySearch."%'  ";
        }
      $html ='';
      $result = mysqli_query($conn,$query);
      $num = 1;
    
      if(mysqli_num_rows($result)>0)
      {       $i = 1;     
        $sourceAll = [];
        while($row= mysqli_fetch_assoc($result))
        {
            $sourceAll[] = $row;
        }   
        foreach (array_slice(gopData($sourceAll), $start, $records_per_page )as $row)
        {
           
            echo '<tr>
                <td>'.($i).'</td>
                <td>'.$row["maSanPham"].'</td>
                <td>'.$row["tenSanPham"].'</td>
                <td>'.getTenNCC($row["maNhaCungCap"]).'</td>
                <td>'.getTenDM($row["maDanhMuc"]).'</td>
                <td>'.getTenQL($row["maQuanLy"],$conn).'</td>
                <td>'.getSize ($row['sizes']).'</td>
                <td>'.$row["giaBan"].'</td>
                <td>'.$row["chitietsp"].'</td>
                <td>'.$row["moTaSanPham"].'</td>';
                $q1="SELECT duongDanAnh from anhsanpham where maSanPham ='".$row["maSanPham"]."'";                       
                $source = mysqli_query($conn,$q1);
                if($row1= mysqli_fetch_assoc($source)){                  
                    echo '<td> <img src ='.$row1["duongDanAnh"].' width="320" height="180"/></td>';
                }else{
                    echo "<td></td>";
                }
                echo '<td style="text-align: center">
                        <a href="sua.php?maSanPham='.$row["maSanPham"].'">
                                <i class="fa-sharp fa-solid fa-pen" style="color: #ff3d3d;"></i>
                        </a>
                        <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không\');" href="xoa.php?maSanPham='.$row["maSanPham"].'">
                                <i class="fa-solid fa-trash" style="color: #fa1100;"></i>
                        </a>
                </tr>';
                $i++;
        }                
      }
      else
          $html .= '';
  echo $html;
    ?>
