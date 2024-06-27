<?php
      require_once '../../connect.php';
      $html = '';
      function getTenDanhMuc($id){
        $tendanhmuccha = '';
        if($id != -1)
        {
            $q1 = "select tenDanhMuc from danhmuc where maDanhMuc = '".$id."'";
            $result1 = mysqli_query(mysqli_connect("localhost","root","","webbanhang"),$q1);
            if(mysqli_num_rows($result1)>0)
            {
                $tendanhmuccha = mysqli_fetch_assoc($result1)['tenDanhMuc'];                
            }
        }
        return $tendanhmuccha;
    }
    
    function showCategories($categories, $html='', $parent_id = -1, $char = '', $i=1)
    {                                     
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['danhMucCha'] == $parent_id || $item['danhMucCha'] == '' )
            {                                                    
              echo '<tr>   
                    <td>'.($i).'</td>                  
                    <td>'.$item["maDanhMuc"].'</td>
                    <td class="tenDM">'.$char." ".$item["tenDanhMuc"].'</td>                      
                    <td>'.getTenDanhMuc($item["danhMucCha"]).'</td>
                    <td>'.$item["url"].'</td>
                    <td>'.$item["viTri"].'</td>
                    <td style="display:flex;margin:0px 24px";>
                        <a href="sua.php?maDanhMuc='.$item["maDanhMuc"].'">
                                <i class="fa-sharp fa-solid fa-pen" style="color: #ff3d3d;"></i>
                        </a>
                        <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không\');" href="xoa.php?maDanhMuc='.$item["maDanhMuc"].'">
                                <i class="fa-solid fa-trash" style="color: #fa1100;"></i>
                        </a>
                    </td>
                </tr>';       
                                   
                // Xóa chuyên mục đã lặp
                unset($categories[$key]); 
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                $i++;          
                showCategories($categories, $html, $item['maDanhMuc'], $char.'-----', $i);
               
            }  
        }  
    }
      $keySearch= $_POST['key'];           
    
      if($keySearch == "")
      {
          $query="select * from danhmuc order by viTri asc ";
      }
      else{
          $query="select * from danhmuc where tenDanhMuc like N'%".$keySearch."%' ";
        }
      $html ='';
      $result = mysqli_query($conn,$query);
      $num = 1;
    
      if(mysqli_num_rows($result)>0)
      {       
        $i=1; 
        if($keySearch != ''){
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
                '.$row['viTri'].'
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
        }else{
          $categories = array();                
          while($row = mysqli_fetch_assoc($result))
          {
            $categories[] = $row;
          }
          showCategories($categories,  $html);
          echo $html;
       }                   
                     
      }
      else
          $html .= '';
      echo $html;
    ?>