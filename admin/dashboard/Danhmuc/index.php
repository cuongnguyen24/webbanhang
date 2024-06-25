<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../nhacungcap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a href="../index.html" class="">
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                <a href="../customer/" class="">
                    <i class="fa-regular fa-user"></i>
                    <h3>Khách hàng</h3>
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

                <a href="../message/" class="active">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    <span class="message-count">26</span>
                </a>

                <a href="../products/" class="">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="../report/" class="">
                    <i class="fa-solid fa-exclamation"></i>
                    <h3>Báo cáo</h3>
                </a>
                <a href="../settings/" class="">
                    <i class="fa-solid fa-gear"></i>
                    <h3>Cài đặt</h3>
                </a>
                <a href="#">
                    <i class="fa-solid fa-plus"></i>
                    <h3>Thêm sản phẩm</h3>
                </a>
                <a href="/websiteechcom/admin/accountadmin.php" target="_self">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <h3>Quay lại</h3>
                </a>
            </div>
        </aside>
        <?php 
        require_once '../../connect.php';       
        // Lấy tổng số bản ghi
        $sql = "SELECT COUNT(*) FROM danhmuc";
        $result = $conn->query($sql);
        $total_records = $result->fetch_row()[0];

        // Xác định số bản ghi trên mỗi trang
        $records_per_page = 10;

        // Tính số trang
        $total_pages = ceil($total_records / $records_per_page);

       
        // Xác định trang hiện tại
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //echo $current_page;
        // Tính vị trí bắt đầu lấy bản ghi
        $start = ($current_page - 1) * $records_per_page;
        $keySearchName= '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
          if(isset($_POST['record'])){
            $records_per_page =(int) $_POST['record'];   
            $total_pages = ceil($total_records / $records_per_page);
          }
          if(isset($_POST['txtSearch1'])){            
            $keySearchName = $_POST['txtSearch1'];            
          }  
        }       
    ?>
        <!-- ---------------------END OF ASIDE---------------- -->
        <main>
            <div class="recent-order">
                <div class="title">
                    <h2>DANH SÁCH DANH MỤC</h2>
                </div>
                <div class="container-xl">
                    <div class="g-2 align-items-center" style=" margin-bottom: 20px;">
                        <div class="col-4" style="margin-top:10px; width: 18%;">
                            <a href="add.php" class="btn btn-outline-primary active w-100" data-bs-toggle="modal"
                                data-bs-target="#modal-report">
                                Thêm mới danh mục
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body border-bottom py-3">
                                <div class="d-flex">
                                    <form method="POST">
                                        <div class="text-muted">
                                            Show
                                            <div class="mx-2 d-inline-block">
                                                <input type="text" id="per_page" name="record"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo $records_per_page?>"
                                                    aria-label="Invoices count">
                                            </div>
                                            entries
                                        </div>
                                    </form>
                                    <div class="ms-auto text-muted">
                                        Search:
                                        <div class="ms-2 d-inline-block">
                                            <input type="text" class="form-control form-control-sm" id="search"
                                                aria-label="Search invoice">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th class="w-1">No.
                                                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-sm icon-thick" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 15l6 -6l6 6" />
                                                </svg>
                                            </th>
                                            <th width="10%">MÃ DANH MỤC</th>
                                            <th >TÊN DANH MỤC</th>        
                                            <th>DANH MỤC CHA</th>
                                            <th>ĐƯỜNG DẪN</th>
                                            <th>VỊ TRÍ</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <body>
                                    <?php
                                        $query="select * from danhmuc order by viTri asc";
                                        $result = mysqli_query($conn,$query);
                                        $categories = array();
                                        while ($row = mysqli_fetch_assoc($result)){
                                            $categories[] = $row;
                                        }
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
                                        function showCategories( $categories, $parent_id = -1, $char = '', $i = 0)
                                        {
                                           
                                            foreach ($categories as $key => $item)
                                            {
                                                $i++;
                                                // Nếu là chuyên mục con thì hiển thị
                                                if ($item['danhMucCha'] == $parent_id)
                                                {
                                                    
                                                    echo '<tr>   
                                                        <td>'.($i).'</td>                  
                                                        <td>'.$item["maDanhMuc"].'</td>
                                                        <td>'.$char." ".$item["tenDanhMuc"].'</td>                      
                                                        <td>'.getTenDanhMuc($item["danhMucCha"]).'</td>
                                                        <th>'.$item["url"].'</th>
                                                        <td>'.$item["viTri"].'</td>
                                                        <td>
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
                                                    showCategories($categories, $item['maDanhMuc'], $char.'-----', $i);
                                                }  
                                            }  
                                        }
                                        showCategories($categories); 
                                        if(mysqli_num_rows($result) == 0)
                                        {
                                            echo '<h3 style="text-align:center;margin-top: -21px;">Không có dữ liệu</h3>';
                                        }
                                    ?>
                                </body>
                                </table>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- -------------------END OF MAIN --------------------- -->

        <div class="right">
            <div class="top">
                <button id="menu_btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="theme-toggler">
                    <i class="fa-regular fa-sun active"></i>
                    <i class="fa-solid fa-moon"></i>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Bình đẹp trai</b></p>
                        <small class="text-muted"> Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="/assets/img/baby_homeAbout.webp" alt="">
                    </div>
                </div>
            </div>

            <!-- END OF TOP -->
            <div class="recent_updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile_photo">
                            <img src="" alt="">
                        </div>
                        <div class="message">
                            <p><b>Thùy Linh</b> received his order of Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile_photo">
                            <img src="" alt="">
                        </div>
                        <div class="message">
                            <p><b>Cường</b> received his order of Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile_photo">
                            <img src="" alt="">
                        </div>
                        <div class="message">
                            <p><b>Quang kun</b> received his order of Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes Ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------END OF RECENT UPDATES ------------------ -->
            <div class="sales_analytics">
                <h2>Sales Analytics</h2>
                <div class="item online">
                    <div class="icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ONLINE ORDERS</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="success"> +39%</h5>
                        <h3>3849</h3>
                    </div>
                </div>


                <div class="item customers">
                    <div class="icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ONLINE ORDERS</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="danger"> +20%</h5>
                        <h3>3849</h3>
                    </div>
                </div>


                <div class="item boom">
                    <div class="icon">
                        <i class="fa-solid fa-bomb"></i>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>BOM ORDERS</h3>
                            <small class="text-muted">Last 24 Hours</small>
                        </div>
                        <h5 class="danger"> -20%</h5>
                        <h3>3849</h3>
                    </div>
                </div>

                <div class="item add_product">
                    <div>
                        <i class="fa-solid fa-square-plus"></i>
                        <h3>Add Product</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../index.js"></script>
</body>

</html>