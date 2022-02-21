<?php
    // print_r($list_info_user);
    // update user
    if (isset($_POST['btn_sub'])) {
        header("Refresh:0");
        extract($_POST);
        if (!empty($_FILES['f_anh']['name'])) {
            $arr_allow_type = ['image/png', 'image/jpeg'];
            $anh = $_FILES['f_anh'];
            if ($anh['size'] < 524288) {
                if (in_array($anh['type'], $arr_allow_type)) {
                    $file_save = '/images/users' . '/' . $anh['name'];
                    $file_full_path = APP_PATH_fr . $file_save;
                    $url_image = BASE_URL_fr . $file_save;
                    move_uploaded_file($anh['tmp_name'], $file_full_path);
                } else {
                    echo "Bạn cần chọn đúng định dạng file ảnh kiểu: jpeg hoặc png";
                }
            } else {
                echo "Dung lượng ảnh đại diện không được quá 500kb";
            }
        }
        $params = [
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
        ];
        $sql = "UPDATE user SET email=:email,address=:address,phone=:phone";
        if (isset($url_image)) {
            $params['image'] = $url_image;
            $sql .= ",image=:image";
        }
        $sql .= " WHERE username='$username'";
        pdo_execute($sql, $params);
    }

    // print_r($_FILES);
    // thay đổi pass
    if (isset($_POST['btn_sub_pass'])) {
        $err=[];
        $password_old = $_POST['password_old'];
        if (md5($password_old) == $list_info_user['password']) {
            $password_new=$_POST['password_new'];
            $confirm_password_new=$_POST['confirm_password_new'];
            if($password_new==$confirm_password_new){
                $password_new=md5($password_new);
                $sql="UPDATE user SET password='$password_new' WHERE username='$username'";
                pdo_execute($sql,'');
                $err['ck_suss']="Cập nhật mật khẩu thành công";
            }
            else{
                $err['ck_err_pass_new']="Mật khẩu mới và Xác nhận mật khẩu phải trùng nhau!";
            }
        } else {
            $err['ck_err_pass_old']="Mật khẩu cũ không chính xác !";
        }
    }
    // echo $password_old;
    // echo $list_info_user['password'];

?>
<h3>Thông tin tài khoản</h3>
<div class="col-md-9 bor" style="margin-top:20px;margin-bottom:20px;">
    <section class="box-main1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group row" style="margin-top:20px;">
                <label for="staticEmail" class="col-sm-2 col-form-label">Ảnh đại diện</label>
                <div class="col-sm-10">
                    <img src="<?php echo $list_info_user['image'] ?>" alt="Chưa có ảnh đại diện" width="200">
                    <input type="file" name="f_anh">
                </div>
            </div>
            <div class="form-group row" style="margin-top:20px;">
                <label for="staticEmail" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword" value="<?php echo $list_info_user['username'] ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword" name="email" value="<?php echo $list_info_user['email'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Địa chỉ</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword" name="address" value="<?php echo $list_info_user['address'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Số điện thoại</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword" name="phone" value="<?php echo $list_info_user['phone'] ?>" required>
                </div>
            </div>
            <button type="submit" name="btn_sub" class="btn btn-outline-info" style="width:150px;margin:8px;">Cập nhật</button>
    </section>
    </form>
</div>
<h3>Cập nhật mật khẩu</h3>
<div class="col-md-9 bor" style="margin-top:20px;">
    <section class="box-main1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group row" style="margin-top:20px;">
                <label for="staticEmail" class="col-sm-2 col-form-label">Nhập mật khẩu</label>
                <div class="col-sm-10">
                    <input type="password" name="password_old" class="form-control" id="inputPassword" style="width:350px;" required>
                    <span style="color: red;"><?php echo @$err['ck_err_pass_old']?></span>
                </div>
            </div>
            <div class="form-group row" style="margin-top:20px;">
                <label for="staticEmail" class="col-sm-2 col-form-label">Mật khẩu mới</label>
                <div class="col-sm-10">
                    <input type="password" name="password_new" class="form-control" id="inputPassword" style="width:350px;" required>
                    <span style="color: red;"><?php echo @$err['ck_err_pass_new']?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" name="">Xác nhận mật khẩu mới</label>
                <div class="col-sm-10">
                    <input type="password" name="confirm_password_new" class="form-control" id="inputPassword" name="email" required style="width:350px;">
                </div>
            </div>
            <button type="submit" name="btn_sub_pass" class="btn btn-outline-info" style="width:150px;margin:8px;">Thay đổi mật khẩu</button>
    </section>
    <p style="color:red;">
        <?php
            echo @$err['ck_suss'];
        ?>
    </p>
    </form>
</div>