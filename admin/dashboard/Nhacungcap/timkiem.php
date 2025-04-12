<?php
      require_once '../../connect.php';
      $keySearch= $_POST['key'];            
      $records_per_page = $_POST['page'];
      $current_page = $_POST['current_page'];          
      $start = ($current_page - 1) * $records_per_page;
      if($keySearch == "")
      {
          $query="select * from nhacungcap LIMIT $start, $records_per_page ";
      }
      else{
          $query="select * from nhacungcap where tenNhaCungCap like N'%".$keySearch."%' 
          LIMIT $start, $records_per_page";
          //OR maNhaCungCap like N'%".$keySearch."%'
        }
      $html ='';
      $result = mysqli_query($conn,$query);
      $num = 1;
      if(mysqli_num_rows($result)>0)
      {       $i=1; 
              while($row = mysqli_fetch_assoc($result))
              {                        
                  $html.=  ' <tr>
                  <td>
                    '.$i.'
                  </td>
                  <td>
                    '.$row['maNhaCungCap'].'
                  </td>
                  <td>
                    '.$row['tenNhaCungCap'].'
                  </td>
                  <td>
                    '.$row['soDienThoai'].'
                  </td>   
                  <td>
                    '.$row['diaChi'].'
                  </td> 
                  <td>
                    '.$row['email'].'
                  </td>                         
                  <td>
                      <a href="sua.php?maNhaCungCap='.$row["maNhaCungCap"].'">
                          <i class="fa-sharp fa-solid fa-pen" style="color: #ff3d3d;"></i>
                      </a>
                 
                      <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không\');" href="xoa.php?maNhaCungCap='.$row["maNhaCungCap"].'">
                              <i class="fa-solid fa-trash" style="color: #fa1100;"></i>
                      </a>
                  </td>                      
                </tr>';
                $i++;
              }                  
      }
      else
          $html .= '';
  echo $html;
    ?>