<?php 
             
    require_once '../../connect.php';

    // Lấy tổng số bản ghi
    $sql = "SELECT COUNT(*) FROM nhacungcap";
    $result = $conn->query($sql);
    $total_records = $result->fetch_row()[0];

    // Xác định số bản ghi trên mỗi trang
    $records_per_page = 1;

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
        echo $keySearchName;
        }  
    }   
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/" alt>
                    <h2>NOUS<span> ADMIN</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="sidebar">
                <a href="../index.html" class>
                    <i class="fa-solid fa-list"></i>
                    <h3>Thống kê</h3>
                </a>

                <a href="../customer/" class>
                    <i class="fa-regular fa-user"></i>
                    <h3>Khách hàng</h3>
                </a>

                <a href="../order/" class>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h3>Đơn hàng</h3>
                </a>

                <a href="../analytics/" class>
                    <i class="fa-solid fa-clipboard"></i>
                    <h3>Phân tích</h3>
                </a>

                <a href="../message/" class>
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Tin nhắn</h3>
                    <span class="Message-count">26</span>
                </a>

                <a href="../products/" class="active">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="../report/" class>
                    <i class="fa-solid fa-exclamation"></i>
                    <h3>Báo cáo</h3>
                </a>
                <a href="../settings/" class>
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
        <!-- ---------------------END OF ASIDE---------------- -->
        <main>
            <h1>Dashboard</h1>
            <!-- <div class="date">
                    <input type="date">
                </div> -->

            <div class="insights">
                <!-- <div class="sale">
                    <i class="fa-solid fa-chart-bar"></i>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Sales</h3>
                            <h1>$12,024</h1>
                        </div>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                            
                        </svg>
                        <div class="number">
                            <p>81%</p>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div> -->
                <!-- ----------------END OF SALES--------------- -->

                <!-- <div class="expensive">
                        <i class="fa-solid fa-chart-line"></i>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Expensive</h3>
                                <h1>$12,024</h1>
                            </div>

                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div> -->
                <!-- ----------------END OF EXPENSIVE--------------- -->
                <!-- <div class="income">
                    <i class="fa-solid fa-chart-area"></i>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Income</h3>
                            <h1>$12,024</h1>
                        </div>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                        </svg>
                        <div class="number">
                            <p>81%</p>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div> -->
                <!-- ----------------END OF INCOME--------------- -->

            </div>
            <!-- ------------------END OF INSIGHTS ------------- -->

            <div class="recent-order">
                <h2>Recent Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Number</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Foldable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Foldable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Foldable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Foldable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Foldable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#">Show All</a>

                <div class="title">
                    <h2>DANH SÁCH NHÀ CUNG CẤP</h2>
                </div>
                <div class="container-xl">
                    <div class="g-2 align-items-center" style=" margin-bottom: 20px;">
                        <div class="col-4" style="margin-top:10px; width: 18%;">
                            <a href="add.php" class="btn btn-outline-primary active w-100" data-bs-toggle="modal"
                                data-bs-target="#modal-report">
                                Thêm mới nhà cung cấp
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
                                                    value="<?php echo $records_per_page?>" aria-label="Invoices count">
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
                                            <th class="w-1"><input class="form-check-input m-0 align-middle"
                                                    type="checkbox" aria-label="Select all invoices"></th>
                                            <th class="w-1">No.
                                                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 15l6 -6l6 6" />
                                                </svg>
                                            </th>
                                            <th>Mã nhà cung cấp</th>
                                            <th>Tên nhà cung cấp</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_table">

                                        <?php                                            
                                            $query="select * from nhacungcap LIMIT $start, $records_per_page";      
                                            $result = mysqli_query($conn,$query);
                                            $num=1;
                                            $gt;
                                            if(mysqli_num_rows($result) > 0)
                                            {           
                                            $i = 1;
                                                while($row= mysqli_fetch_assoc($result))
                                                { 
                                                    ?>
                                        <tr>
                                            <th class="w-1"><input class="form-check-input m-0 align-middle"
                                                    type="checkbox" aria-label="Select all invoices"></th>
                                            <td>
                                                <?php  echo $i?>
                                            </td>
                                            <td>
                                                <?php echo $row['maNhaCungCap'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['tenNhaCungCap'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['soDienThoai'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['diaChi'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['email'] ?>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <i class="fa-sharp fa-solid fa-pen" style="color: #ff3d3d;"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a onclick="" href="">
                                                    <i class="fa-solid fa-trash" style="color: #fa1100;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }                                            
                                        ?>

                                    </tbody>
                                </table>
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
                        <img src="/assets/img/baby_homeAbout.webp" alt>
                    </div>
                </div>
            </div>

            <!-- END OF TOP -->
            <div class="recent_updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile_photo">
                            <img src alt>
                        </div>
                        <div class="message">
                            <p><b>Thùy Linh</b> received his order of
                                Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes
                                Ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile_photo">
                            <img src alt>
                        </div>
                        <div class="message">
                            <p><b>Cường</b> received his order of Night
                                lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes
                                Ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile_photo">
                            <img src alt>
                        </div>
                        <div class="message">
                            <p><b>Quang kun</b> received his order of
                                Night lion tech GPS drone.</p>
                            <small class="text-muted">2 Minutes
                                Ago</small>
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
                            <small class="text-muted">Last 24
                                Hours</small>
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
                            <small class="text-muted">Last 24
                                Hours</small>
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
                            <small class="text-muted">Last 24
                                Hours</small>
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