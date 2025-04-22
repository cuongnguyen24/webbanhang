<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà cung câp</title>
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

                <a href="../Nhacungcap/" class="active">
                    <i class="fa-solid fa-clipboard"></i>
                    <h3>Nhà cung cấp</h3>
                </a>

                <a href="../DanhMuc/" class="">
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
        <!-- ---------------------END OF ASIDE---------------- -->
        <?php 
        require_once '../../connect.php';       
        // Lấy tổng số bản ghi
        $sql = "SELECT COUNT(*) FROM nhacungcap";
        $result = $conn->query($sql);
        $total_records = $result->fetch_row()[0];

        // Xác định số bản ghi trên mỗi trang
        // $records_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
        $records_per_page= 10;
        // Tính số trang = tổng số bản ghi / số bản ghi của mỗi trang
        $total_pages = ceil($total_records / $records_per_page);

        // Xác định trang hiện tại-page
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        // Tính vị trí bắt đầu lấy bản ghi
        $start = ($current_page - 1) * $records_per_page;
        $keySearchName= '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
            //
          if(isset($_POST['record'])){
            $records_per_page =(int) $_POST['record'];   
            $total_pages = ceil($total_records / $records_per_page);
          }
         
          if(isset($_POST['txtSearch1'])){            
            $keySearchName = $_POST['txtSearch1'];            
          }
          
        }   
           
    ?>
        <main>
        <div class="recent-order">
            <div class="main__layout">
            <div id="title_form">
                <label >QUẢN LÝ NHÀ CUNG CẤP</label>
                </div> 
                <div class="add">
                    <label for="">Danh sách nhà cung cấp</label>
                    <a id="add_button" href="add.php">
                        <i class="fa-solid fa-plus"></i>
                        THÊM NHÀ CUNG CẤP
                    </a>
                </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body border-bottom py-3">
                                <div class="d-flex">
                                    <form class="form-search" method="POST">
                                        <div class="text-muted">
                                            Show
                                            <div class="mx-2 d-inline-block">
                                                <input type="text" id="per_page" name="record"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo $records_per_page ?>" aria-label="Invoices count" disabled>
                                            </div>
                                            entries
                                        </div>
                                    </form>
                                    <div class="search">
                                        Search:
                                        <form  action="" id="search_form">
                                            <input type="text" name="txtSearch" id="search" placeholder="Tìm tên nhà cung cấp">
                                            <button name="btnSearch" id="btnSearch" ></button>
                                            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <!-- <th class="w-1"><input class="form-check-input m-0 align-middle"
                                                    type="checkbox" aria-label="Select all invoices"></th>
                                            <th class="w-1">No</th> -->
                                            <th>STT</th>
                                            <th>MÃ NHÀ CUNG CẤP</th>
                                            <th>TÊN NHÀ CUNG CẤP</th>
                                            <th>SỐ ĐIỆN THOẠI</th>
                                            <th>ĐỊA CHỈ</th>
                                            <th>EMAIL</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_table">
                                        <?php 
                                        //ghan tu vt bd den trang so ban ghi moi trang, od trc lm
                                         $query="select * from nhacungcap LIMIT $start, $records_per_page";      
                                         $result = mysqli_query($conn,$query);                                 
                                         if(mysqli_num_rows($result) > 0)
                                         {           
                                           $i = $start+1;
                                             while($row = mysqli_fetch_assoc($result))
                                             {             
                                                 echo ' <tr>
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
                            <div class="show-pagination align-items-center">
                                <p class="m-0">Showing <span><?php echo $start+1 ;?></span> to
                                    <span><?php echo $records_per_page ?></span>
                                    of <span><?php echo $total_records ?></span> entries
                                </p>
                                <ul class="pagination m-0 ms-auto">
                                    <?php   
                                    //htai                                 
                                    if($current_page > 1){
                                        ?> <li id="pre" class="page-item page-item-h" disabled>
                                        <a class="page-link" href="?page=<?php echo $current_page - 1  ?>&per_page=<?php echo  $records_per_page ?>" tabindex="-1"
                                            aria-disabled="true">
                                            <i class="fa-solid fa-angle-left" style="color: #000000;"></i> prev
                                        </a>
                                    </li>';
                                    <?php                                    
                                    }
                                   
                                    for($a = 0 ; $a < $total_pages; $a++){
                                        ?>
        
                                        <li class="page-item page-<?php echo $a + 1 ?>">
                                            <a class="page-link" href="?page=<?php echo $a + 1 ?>&per_page=<?php echo  $records_per_page ?>"><?php echo $a + 1 ?></a>
                                        </li>
                                    <?php
                                    }
                                        if($current_page < $total_pages){
                                         ?>
                                    <li id="next" class="page-item-h page-item">
                                        <a class="page-link" href="?page=<?php echo  $current_page + 1 ?>&per_page=<?php echo  $records_per_page ?>">
                                            next <i class="fa-solid fa-angle-right" style="color: #000000;"></i>
                                        </a>
                                    </li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                                <input type="hidden" id="total_page" value=<?php echo $total_pages ?>>
                                <input type="hidden" id="current_page" value=<?php echo $current_page ?>>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        <!-- -------------------END OF MAIN --------------------- -->
    <script>
    //lấy gtr của id
    const current_page = +document.getElementById("current_page").value;
    console.log(current_page);
    //lấy gtr ten class
    const pagei = document.getElementsByClassName(`page-${current_page}`)
    // bấm vào page->hien xanh
    pagei[0].classList.add("active")
    // ẩn hiện nút prev , next
    if (+document.getElementById('total_page').value <= 1) {
        const page1 = Array.from(document.getElementsByClassName("page-item-h"));
        page1.map(data => data.classList.add("disabled"))
    }
    //timkiem ptrang
    const inputField = document.getElementById("search");
    // addeven-> lắng nghe sự kiện khi nhập dl
    inputField.addEventListener('input', function() {
        //in ra dl
        console.log('Giá trị mới:', +document.getElementById("per_page").value);
        // tạo form data
        var form_data = new FormData();
        // this.value-> gtri ô input
        form_data.append('key', this.value);
        form_data.append('page', +document.getElementById("per_page").value);
        form_data.append('current_page', current_page);
        var ajax_request = new XMLHttpRequest();
        // gửi thông tin , mở file tk
        ajax_request.open('POST', 'timkiem.php');
        // gửi form data
        ajax_request.send(form_data);
        // lấy dl
        ajax_request.onreadystatechange = function() {
            
            if(ajax_request.responseText === ''){
                // document.getElementById('notfound').innerHTML = '<h3 style="text-align:center;margin-top: -21px;">Không có dữ liệu</h3>'
                document.getElementById('body_table').innerHTML = ''
            }else{
                document.getElementById('body_table').innerHTML = ajax_request.responseText;
                // document.getElementById('notfound').innerHTML =''
            }
        }

    });
    </script>
    <!-- <script src="../index.js"></script> -->
</body>

</html>
