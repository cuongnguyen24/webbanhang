<?php
  // session_start();

?>
<form action="" method="POST">
    <div class="model_LogIn js-model_LogIn">
      <div class="model-container js-model-container">
        <div class="model_LogIn_Close js-model_LogIn-close">
          <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="row">
          <div class="col_login">
            <div style="padding-bottom: 15px;">
              <img src="./assets/img/logo.webp" alt="logo">
            </div>

            <div class="sub-nav">
              <div class="btn login" style="background-color: rgba(0,0,0,0.03);">Đăng nhập</div>
              <div class="btn register"><a href="/user/account_register.php"> Đăng ký</a></div>
            </div>
          </div>
          <div class="col_form">
            <div class="tab-content">
              <div id="modelLogIn">
                <h5 class="header-content">
                  ĐĂNG NHẬP VỚI MẬT KHẨU
                </h5>
                <div class="login-form-body">
                  <form action="">
                    <div class="form-group">
                      <label for="">Tên tài khoản</label>
                      <label for=""><a href="">Đăng nhập với OTP</a></label>
                      <input type="text" class="form-control" name="user_name_lg">
                    </div>

                    <div class="form-group">
                      <label for="">Mật khẩu</label>
                      <input type="password" class="form-control" name="passlg">
                    </div>

                    <div class="login-btn">
                      <button type="submit" name="dangnhap">Đăng nhập</button>
                    </div>
                    <a href="" class="forget_pass">QUÊN MẬT KHẨU?</a>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </form>
  <script src="./login.js"></script>
  

  <?php
    include  ( $_SERVER['DOCUMENT_ROOT'] . "/collections/includes/connect.php");

    if (isset($_POST["dangnhap"])) {
        $tk = $_POST["user_name_lg"];
        $mk = $_POST["passlg"];

        $sql = "SELECT tk.*, pq.tenPhanQuyen 
                FROM taikhoan tk
                JOIN phanquyen pq ON tk.maPhanQuyen = pq.maPhanQuyen
                WHERE tenTaiKhoan = '$tk' AND matKhau = '$mk'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION["loged"] = true;
            $_SESSION["username"] = $tk;
            $role = $row['maPhanQuyen'];
            $_SESSION["role"] = $role;
            if($role == 1){
            echo '<script>
                        alert("Đăng nhập thành công");
                        window.location.href = "./admin/accountadmin.php";
                    </script>';
            
            }else if($role == 3){
            echo '<script>
                        alert("Đăng nhập thành công");
                        window.location.href = "./user/accountcustomer.php";
                    </script>';
            
            }else if($role == 2){
            echo '<script>
                        alert("Đăng nhập thành công");
                        window.location.href = "./user/accountstaff.php";
                    </script>';
            
            }
            
        } else {
            echo '<script>alert("Đăng nhập không thành công. Tên tài khoản hoặc mật khẩu không đúng.");</script>';
        }
        } else {
        echo "Lỗi trong quá trình thực hiện truy vấn: " . mysqli_error($conn);
        }
    }
    
  ?>
