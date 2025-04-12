<?php
    require_once '../../connect.php'; 
    $categories = array();      
    $q1 = "select * from danhmuc";
    $result1 = mysqli_query($conn,$q1);
    if(mysqli_num_rows($result1)>0)
    {
        while ($row = mysqli_fetch_assoc($result1)){
            $categories[] = $row;
        }            
    } 
    $maDanhMuc=$_GET['maDanhMuc'];
    echo $maDanhMuc;
    $tenDanhMuc="";
    $url="";
    $danhMucCha="";
    $loaiDanhMuc="";
    require_once '../../connect.php'; 
    $query="select * from danhmuc where maDanhMuc='".$maDanhMuc."'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $tenDanhMuc=$row["tenDanhMuc"];
            $url=$row["url"];
            $danhMucCha=$row["danhMucCha"];
            $vitri=$row["viTri"];
        }
    }
?>  
<?php
    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['btnSave']))
    {
        $errors=[];
        if(empty(trim($_POST['txtDanhMuc']))){
            $errors['txtDanhMuc']='Tên danh mục không được để trống';
        }
        else{
            $txtDanhMuc= $_POST['txtDanhMuc'];
        } 
        if(empty(trim($_POST['txtDuongDan']))){
            $errors['txtDuongDan']='Không được để trống đường dẫn';
        }
        else{        
            $txtDuongDan= $_POST['txtDuongDan'];        
        }
        if(!empty($_POST['txtDmCha'])){
            $txtDmCha= $_POST['txtDmCha'];
        }
        if(!empty($errors)){
            $mess='Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            ?>
                <div class="alert">
                    <?php echo $mess; ?>
                </div>
            <?php
        }
        else{
            $tenDanhMuc= $_POST['txtDanhMuc'];
            $url=$_POST['txtDuongDan'];
            $danhMucCha= ($_POST['txtDmCha'] != 0 && $_POST['txtDmCha'] != $maDanhMuc) ? $_POST['txtDmCha'] : -1 ;       
            $vitri=$_POST['vitri'];         
            $query="UPDATE danhmuc SET tenDanhMuc='".$tenDanhMuc."',url='".$url."',danhMucCha='".$danhMucCha."',vitri='".$vitri."' where maDanhMuc='".$maDanhMuc."'"; 
            $result= mysqli_query($conn, $query);
            if($result>0)
                echo '<script>
                alert("Cập nhật thành công");
                window.location.href="index.php";
                    </script>';
            else 
                echo 'Lỗi sửa dữ liệu';
            }
        }     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../add.css">
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
        <main>
            <div class="main">
            <div id="back">
                    <i class= "fa-solid fa-angle-left"></i>
                    <a href="index.php" class="btn">Danh sách danh mục</a>
                </div>
                <hr />
                <div class="wrapper">
                <h3 style="text-align: center" class="title">Sửa danh mục</h3>
                <form method="POST" id="form">
                    <div class="form-group">
                        <label for="inputEmail4">Mã danh mục</label>
                        <input disabled type="text" class="form-control" name="txtMa" value=<?php  echo $maDanhMuc?>>
                    </div>  
                        
                    <div class="form-group">
                        <label for="inputAddress">Tên danh mục</label>
                        <input type="text" class="form-control" id="txtDanhMuc" name="txtDanhMuc" placeholder="Tên danh mục" oninput="updateInput2()" value="<?php echo $tenDanhMuc ?>">
                        <?php 
                            echo (!empty($errors['txtDanhMuc']))?'<span class="error">'.$errors['txtDanhMuc'].'</span>':false;
                        ?> 
                    </div>
                
                    <div class="form-group">
                        <label for="inputAddress2"> Đường dẫn </label>
                        <input type="text" class="form-control" id="txtDuongDan" name="txtDuongDan" placeholder="Đường dẫn" value="<?php echo $url ?>">
                        <?php 
                            echo (!empty($errors['txtDuongDan']))?'<span class="error">'.$errors['txtDuongDan'].'</span>':false;
                        ?> 
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                        <label for="inputState">Danh mục cha</label>
                        <select id="inputState" class="form-control" name="txtDmCha" value="<?php echo $danhMucCha; ?>">
                            <option  name="txtDmCha" value="-1">Danh mục cha</option>
                            <?php 
                                foreach ($categories as $key => $item)
                                {
                                    if($item['maDanhMuc']== $danhMucCha){
                                        echo '<option name="txtDmCha"  selected value= '.$item['maDanhMuc'].'>'.$item['tenDanhMuc'].'</option>';
                                    }
                                    else{
                                        echo '<option name="txtDmCha" value= '.$item['maDanhMuc'].'>'.$item['tenDanhMuc'].'</option>';
                                    }
                                    
                                }     
                            ?> 
                        </select>
                        </div>        
                    </div>

                    <div class="form-group">
                        <label for="inputAddress2"> Vị trí </label>
                        <input type="text" class="form-control" id="vitri" name="vitri" placeholder=" Vị trí danh mục..." value="<?php echo $vitri ?>">
                    </div>
                    <div id="button_add">
                        <button type="submit" class="btn btn-primary" name="btnSave" id="btnSubmit">Ghi dữ liệu</button>
                    </div>
                </form>
                </div>
                <script>
                function convertToSlug(str) {
                    // Chuyển các ký tự có dấu thành không dấu và chuyển sang chữ thường
                    str = str.toLowerCase().replace(/ă/g, 'a').replace(/â/g, 'a').replace(/đ/g, 'd').replace(/ê/g, 'e').replace(/ô/g, 'o').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ơ/g, 'o').replace(/ư/g, 'u').replace(/ /g, '-');
                    return str;
                }
                function removeAccents(str) {
                        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                    }
                function updateInput2() {
                    var input1Value = document.getElementById("txtDanhMuc").value;
                    document.getElementById("txtDuongDan").value = removeAccents(convertToSlug(input1Value));
                }
                </script>
            </div>

        </main>
