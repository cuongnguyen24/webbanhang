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
                <a href="../index.php" class="">
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

                <a href="../DanhMuc/" class="">
                    <i class="fa-regular fa-envelope"></i>
                    <h3>Danh mục</h3>
                    
                </a>

                <a href="../products/" class="active">
                    <i class="fa-solid fa-shop"></i>
                    <h3>Sản phẩm</h3>
                </a>
                <a href="/webbanhang/admin/accountadmin.php" target="_self">
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
        <div class="main__layout">
            <div id="title_form">
                <label >QUẢN LÝ SẢN PHẨM</label>
            </div> 
                <div class="add">
                    <label for="">Danh sách sản phẩm</label>
                    <a id="add_button" href="add.php">
                        <i class="fa-solid fa-plus"></i>
                        THÊM SẢN PHẨM
                    </a>
                </div>
        <div class="container-xl">
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
                                    <th>Link Chi tiết sản phẩm</th>
                                    <th>MÔ TẢ SẢN PHẨM</th>
                                    <th>Ảnh sản phẩm</th>
                                    <th width="10%">THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody id="body_table">
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
                                $i = 1;        
                                foreach (gopData($sourceAll) as $row)
                                {
                                   
                                    echo '<tr>
                                        <td>'.($i).'</td>
                                        <td>'.$row["maSanPham"].'</td>
                                        <td>'.$row["tenSanPham"].'</td>
                                        <td>'.getTenNCC($row["maNhaCungCap"]).'</td>
                                        <td>'.getTenDM($row["maDanhMuc"]).'</td>
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
                    <div class="show-pagination align-items-center">
                                <p class="m-0">Showing <span>1</span> to
                                    <span><?php echo $records_per_page ?></span>
                                    of <span><?php echo $total_records ?></span> entries
                                </p>
                                <ul class="pagination m-0 ms-auto">
                                    <?php                                    
                                    if($current_page > 1){
                                        ?> <li id="pre" class="page-item page-item-h" disabled>
                                        <a class="page-link" href="?page=<?php echo $current_page - 1  ?>" tabindex="-1"
                                            aria-disabled="true">
                                            <i class="fa-solid fa-angle-left" style="color: #000000;"></i> prev
                                        </a>
                                    </li>';
                                    <?php                                    
                                    }
                                   
                                    for($a = 0 ; $a < $total_pages; $a++){
                                        ?>
                                    <li class="page-item page-<?php echo $a + 1 ?>">
                                        <a class="page-link" href="?page=<?php echo $a + 1 ?>"><?php echo $a + 1 ?></a>
                                    </li>
                                    <?php
                                    }
                                        if($current_page < $total_pages){
                                         ?>
                                    <li id="next" class="page-item-h page-item">
                                        <a class="page-link" href="?page=<?php echo  $current_page + 1 ?>">
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
        </div>
        </div>
    </div>
</main>
<script>
    const current_page = +document.getElementById("current_page").value;
    console.log(current_page);
    const pagei = document.getElementsByClassName(`page-${current_page}`)
    pagei[0].classList.add("active")
    if (+document.getElementById('total_page').value <= 1) {
        const page1 = Array.from(document.getElementsByClassName("page-item-h"));
        page1.map(data => data.classList.add("disabled"))
    }
    const inputField = document.getElementById("search");
    inputField.addEventListener('input', function() {
        console.log('Giá trị mới:', +document.getElementById("per_page").value);

        var form_data = new FormData();

        form_data.append('key', this.value);
        form_data.append('page', +document.getElementById("per_page").value);
        form_data.append('current_page', current_page);
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
</body>
</html>