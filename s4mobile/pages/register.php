<?php 
 $err =  array();
 $name = $password = $email = $address = $phone = "";
    if(isset($_POST['btnRegistrantion'])){
        $name = $_POST['name'];
        $password =md5 ($_POST['password']);
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $pemission = 0;
        $checks = "SELECT * FROM user WHERE username = '$name'";
        $couts = $objConn->prepare($checks);
        $couts->execute();
        if ($couts->rowCount() > 0) {
         $err['count'] =   "Tài khoản  đã tồn tại";
        } else{

        if(empty($name)&& $name >=8){
            $err['name'] = "Tên đăng nhập phải lớn hơn 8 kí tự";
        }

        if(empty($password) && $password >=8 ){
            $err['password'] = "Mật khẩu phải nhiều hơn 8 kí tự";
        }
        if(empty($email) ){
            $err['email'] = "Bạn không được để trống email";
        }
        if(empty($address) ){
            $err['address'] = "Bạn không được để trống địa chỉ";
        }
        if(empty($phone)){
            $err['phone'] = "Bạn cần nhập số điện thoại và nhập đủ 10 số";
        }
        if (empty($err)) {
            try {
                $stmt = $objConn->prepare("INSERT INTO user(username , email ,password,address,phone,pemission) 
                                       values(:username , :email, :password, :address, :phone, :pemission) ");
                $stmt->bindParam(':username', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':pemission', $pemission);
                $stmt->execute();
              
                header("Location: ?page=login");

                $_SESSION['success'] =  "Đăng kí thành công  mới bạn đăng nhập";

            } catch (Exception $e) {
                echo "Lỗi truy vấn".$e->getMessage();
            }
        }

        }
    }

?>


<div class="col-md-9 bor">
        <section class="box-main1">
            <h3 class="title-main" style="text-align: center;">  Đăng kí thành viên</h3>
            <div class="showitem">
           <p style="color:red;font-size:19px;"><?php  if(isset($err['count'])) echo $err['count']; ?></p> 
           <p style="color:red;font-size:19px;"><?php  if(isset($err['success'])) echo $err['success']; ?></p> 
                <form  method="post"  enctype="multipart/form-data"> 
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <input type="text" value="<?php echo $name; ?>" name="name" class="form-control" id="name">
                        <span style="color: red; font-size:17px;"> <?php  if(isset($err['name'])) echo $err['name']; ?></span>
                        

                    </div>
                    <div class="form-group">
                        <label for="pass">Mật khẩu</label>
                        <input type="password"  value="<?php echo $password; ?>" name="password" class="form-control" id="pass">
                        <span style="color: red; font-size:17px;"> <?php  if(isset($err['password'])) echo $err['password']; ?></span>
                        
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"  value="<?php echo $email; ?>"  name="email" class="form-control" id="email">
                        <span style="color: red; font-size:17px;"> <?php  if(isset($err['email'])) echo $err['email']; ?></span>
                        
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text"  value="<?php echo $address; ?>"  name="address" class="form-control" id="address">
                        <span style="color: red; font-size:17px;"> <?php  if(isset($err['address'])) echo $err['address']; ?></span>
                        
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text"  value="<?php echo $phone; ?>"  name="phone" class="form-control" id="phone">
                        <span style="color: red; font-size:17px;"> <?php  if(isset($err['phone'])) echo $err['phone']; ?></span>
                        
                    </div>

                    <button type="submit" name="btnRegistrantion" class="btn btn-primary">Đăng kí</button>
                </form>

            </div>
        </section>

</div>