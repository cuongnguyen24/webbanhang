<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../nhacungcap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" href="//theme.hstatic.net/200000692427/1001117622/14/favicon.png?v=4870" type="image/png">
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/" alt="">
                    <h2>NOUS<span> ADMIN</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="sidebar">
                <a href="../index.php" class="">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                
                <a href="../staff/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Nhân viên</h3>
                </a>
                <a href="../order/" class="">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h3>Đơn hàng</h3>
                </a>

                <a href="../Nhacungcap/" class="">
                    <i class="fa-solid fa-clipboard"></i>
                    <h3>Nhà cung cấp</h3>
                </a>

                <a href="../DanhMuc/" class="active">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    
                </a>

                <a href="../products/" class="">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="../promotion/" class="">
                    <i class="fa-solid fa-ticket"></i>
                    <h3>Khuyến mãi</h3>
                </a>
                <a href="/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <?php 
        require_once '../../connect.php';       
    ?>
    <?php 
     $query="select * from danhmuc order by viTri asc";
     $result = mysqli_query($conn,$query);
     $categories = array();
     // luu dl danhmuc vao mang 
     while ($row = mysqli_fetch_assoc($result)){
         $categories[] = $row;
     }
    ?>
        <!-- ---------------------END OF ASIDE---------------- -->
        <main>
            <div class="recent-order">
            <div class="main__layout">
                <div id="title_form">
                <label >QUẢN LÝ DANH MỤC</label>
                </div> 
                <div class="add">
                    <label for="">Danh sách danh mục</label>
                    <a id="add_button" href="add.php">
                        <i class="fa-solid fa-plus"></i>
                        THÊM DANH MỤC
                    </a>
                </div>
                <div class="container-xl">
                    <div class="col">
                        <div class="card">
                            <div class="card-body border-bottom py-3">
                                <div class="d-flex">
                                    <form method="POST">
                                        <!-- <div class="text-muted">
                                            Show
                                            <div class="mx-2 d-inline-block">
                                                <input type="text" id="per_page" name="record"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo count($categories);?>"
                                                    aria-label="Invoices count">
                                            </div>
                                            entries
                                        </div> -->
                                    </form>
                                    <div class="search">
                                        Search:
                                        <!-- <div class="ms-2 d-inline-block">
                                            <input type="text" class="form-control form-control-sm" id="search"
                                                aria-label="Search invoice">
                                        </div> -->
                                        <form  action="" id="search_form">
                                            <input type="text" name="txtSearch" id="search" placeholder=" Tìm tên danh mục">
                                            <button name="btnSearch" id="btnSearch" ><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable" style="text-align: left;">
                                    <thead style="text-align: left">
                                        <tr>
                                            <th >MÃ DANH MỤC</th>
                                            <th >TÊN DANH MỤC</th>        
                                            <th>DANH MỤC CHA</th>
                                            <th>ĐƯỜNG DẪN</th>
                                            <th width="10%">VỊ TRÍ</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_table">
                                    <?php
                                       
                                        function getTenDanhMuc($id){
                                            $tendanhmuccha = '';
                                            if($id != -1)
                                            {
                                                $q1 = "select tenDanhMuc from danhmuc where maDanhMuc = '".$id."'";
                                              //  $result1 = mysqli_query(mysqli_connect("localhost","root","","webbanhang"),$q1);
                                              $result1 = mysqli_query(mysqli_connect("localhost","myuser","linh123@","myproject_db"),$q1);
                                                if(mysqli_num_rows($result1)>0)
                                                {
                                                    $tendanhmuccha = mysqli_fetch_assoc($result1)['tenDanhMuc'];                
                                                }
                                            }
                                            return $tendanhmuccha;
                                        }
                                    
                                        function showCategories( $categories, $parent_id = -1, $char = '')
                                        {                                     
                                            
                                            foreach ($categories as $key => $item)
                                            {
                                                // Nếu là chuyên mục con thì hiển thị
                                                if ($item['danhMucCha'] == $parent_id || $item['danhMucCha'] == '' )
                                                {                                                    
                                                    echo '<tr>                                                                             
                                                        <td>'.$item["maDanhMuc"].'</td>
                                                        <td class="tenDM">'.$char." ".$item["tenDanhMuc"].'</td>                      
                                                        <td>'.getTenDanhMuc($item["danhMucCha"]).'</td>
                                                        <td>'.$item["url"].'</td>
                                                        <td>'.$item["viTri"].'</td>
                                                        <td style="display:flex;margin:0px 9px";>
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
                                                    showCategories($categories, $item['maDanhMuc'], $char.'-----');
                                                   
                                                }  
                                            }  
                                        }
                                        showCategories($categories); 
                                        if(mysqli_num_rows($result) == 0)
                                        {
                                            echo '<h3 style="text-align:center;margin-top: -21px;">Không có dữ liệu</h3>';
                                        }
                                    ?>
                                </tbody>
                                </table> 
                               
                                <?php
                                
                                echo '<div id="notfound">';
                                if(mysqli_num_rows($result) == 0)
                                { 
                                    echo '<h3 style="text-align:center;margin-top: -21px;">Không có dữ liệu</h3>';  
                                }
                                echo '</div>';
                                ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- -------------------END OF MAIN --------------------- -->
</body>
<script>
    const inputField = document.getElementById("search");
    inputField.addEventListener('input', function() {
        console.log('Giá trị mới:', this.value);

        var form_data = new FormData();

        form_data.append('key', this.value);    

        var ajax_request = new XMLHttpRequest();

        ajax_request.open('POST', 'timkiem.php');

        ajax_request.send(form_data);

        ajax_request.onreadystatechange = function() {
            
            if(ajax_request.responseText === ''){
                document.getElementById('notfound').innerHTML = '<h3 style="text-align:center;margin-top: -21px;">Không có dữ liệu</h3>'
                document.getElementById('body_table').innerHTML = ''
            }else{
                document.getElementById('body_table').innerHTML = ajax_request.responseText;
                document.getElementById('notfound').innerHTML =''
            }
        }
    });
</script>
</html>
