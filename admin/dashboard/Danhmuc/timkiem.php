<?php
      require_once '../../connect.php';
      $keySearch= $_POST['key'];            
      $records_per_page = $_POST['page'];
      $current_page = $_POST['current_page'];          
      $start = ($current_page - 1) * $records_per_page;
      if($keySearch == "")
      {
          $query="select * from danhmuc LIMIT $start, $records_per_page ";
      }
      else{
          $query="select * from danhmuc where tenDanhMuc like N'%".$keySearch."%' LIMIT $start, $records_per_page ";
        }
      $html ='';
      $result = mysqli_query($conn,$query);
      $num = 1;
    
      if(mysqli_num_rows($result)>0)
      {       $i=1; 
              while($row = mysqli_fetch_assoc($result))
              {                        
                  $html.=  ' <tr>
                  <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                    <td>
                    '.$i.'
                  </td>
                  <td>
                    '.$row['maDanhMuc'].'
                  </td>
                  <td>
                    '.$row['tenDanhMuc'].'
                  </td>
                  <td>
                    '.$row['danhMucCha'].'
                  </td>   
                  <td>
                    '.$row['url'].'
                  </td> 
                  <td>
                    '.$row['vitri'].'
                  </td>                         
                  <td>
                          <a href="sua.php?maDanhMuc='.$row["maDanhMuc"].'">
                              <i class="fa-sharp fa-solid fa-pen" style="color: #ff3d3d;"></i>
                          </a>
                  </td>
                  <td>
                      <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không\');" href="xoa.php?maDanhMuc='.$row["maDanhMuc"].'">
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