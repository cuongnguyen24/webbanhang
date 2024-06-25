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
        $sql = "SELECT COUNT(*) FROM sanpham";
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

<main>
    <div class="recent-order">
        <div class="title">
            <h2>DANH SÁCH SẢN PHẨM</h2>
        </div>
        <div class="container-xl">
            <div class="g-2 align-items-center" style=" margin-bottom: 20px;">
                <div class="col-4" style="margin-top:10px; width: 18%;">
                    <a href="add.php" class="btn btn-outline-primary active w-100" data-bs-toggle="modal"
                        data-bs-target="#modal-report">
                        Thêm mới sản phẩm
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
                                    <th>MÃ SẢN PHẨM</th>
                                    <th>TÊN SẢN PHẨM</th>
                                    <th>TÊN NHÀ CUNG CẤP</th>
                                    <th>TÊN DANH MỤC</th>
                                    <th>SỐ LƯỢNG - SIZE</th>               
                                    <th>GIÁ BÁN</th>
                                    <th>MÔ TẢ SẢN PHẨM</th>
                                    <th>Ảnh sản phẩm</th>
                                    <th width="10%">THAO TÁC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php    
                                require_once '../../connect.php';
                                $query="select sanpham.*,sizesanpham.soLuong, sizesanpham.maSize from sanpham INNER JOIN sizesanpham WHERE sanpham.maSanPham = sizesanpham.maSanPham";
                                $result = mysqli_query($conn,$query);
                                $num=1;
                                $sourceAll = [];
                                while($row= mysqli_fetch_assoc($result))
                                {
                                    $sourceAll[] = $row;
                                }
                                function getTenNCC($id){
                                    $conn = mysqli_connect("localhost","root","","webbanhang");
                                    $qncc = "SELECT tenNhaCungCap from nhacungcap where maNhacungcap ='".$id."'";
                                    $source = mysqli_query($conn,$qncc);
                                    $row1= mysqli_fetch_assoc($source);
                                    return $row1['tenNhaCungCap'];
                                }
                                function getTenDM($id){
                                    $conn = mysqli_connect("localhost","root","","webbanhang");
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
                                function getSize($sizes){
                                    $html = '';
                                    foreach ($sizes as $size){
                                        $html .= $size['soLuong'] . ' ' . $size['maSize'] . '<br>';
                                        }    
                                        return $html;
                                }           
                                foreach (gopData($sourceAll) as $row)
                                {
                                    $i=1;
                                    echo '<tr>
                                        <td>'.($i++).'</td>
                                        <td>'.$row["maSanPham"].'</td>
                                        <td>'.$row["tenSanPham"].'</td>
                                        <td>'.getTenNCC($row["maNhaCungCap"]).'</td>
                                        <td>'.getTenDM($row["maDanhMuc"]).'</td>
                                        <td>'.getSize ($row['sizes']).'</td>
                                        <td>'.$row["giaBan"].'</td>
                                        <td>'.$row["moTaSanPham"].'</td>';
                                        $q1="SELECT duongDanAnh from anhsanpham where maSanPham ='".$row["maSanPham"]."'";                       
                                        $source = mysqli_query($conn,$q1);
                                        if($row1= mysqli_fetch_assoc($source)){                  
                                            echo '<td> <img src ='.$row1["duongDanAnh"].' width="320" height="180"/></td>';
                                        }else{
                                            echo "<td></td>";
                                        }
                                        echo '<td style="text-align: center">
                                                <a href="sua.php?maSanPham='.$row["maSanPham"].'" class="btn">Sửa</a>
                                                <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không\');" href="xoa.php?maSanPham='.$row["maSanPham"].'" class="btn">Xóa</a>
                                            </td>
                                        </tr>';
                                }
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
</body>
</html>