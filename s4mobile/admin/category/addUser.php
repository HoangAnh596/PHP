<?php
$objConn = pdo_get_conn();
$msg = '';
$err = [];

$username = $email = $address = $phone = $admin = $password = "";

if (isset($_POST['addproduct'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $admin = $_POST['admin'];
  $password = md5($_POST['password']);

  if (empty($username) || $username > 6) {
    $err[] = "Tên đăng nhập lớn hơn 6 kí tự";
  }
  if (empty($email)) {
    $err[] = "Bạn cần nhập email ";
  }
  if (empty($address)) {
    $err[] = "Bạn cần nhập địa chỉ";
  }
  if (empty($phone) && $phone >= 10) {
    $err[] = "Bạn cần nhập số điện thoại và hơn 10 kí tự";
  }

  if (empty($password)) {
    $err[] = "Bạn cần nhập password";
  }

  if (empty($err)) {
    if (isset($_FILES['fileToUpload'])) {
      $img = $_FILES['fileToUpload'];
      $Maxsize = 5000000;
      $arr_low_type =  ['image/jpeg', 'image/jpg', 'image/png'];
      if ($img['size'] < $Maxsize) {
        if (in_array($img['type'], $arr_low_type)) {
          $msg = 'File hợp lệ';
          $file_save = '/images/users/' . $img['name'];
          $file_full =  APP_PATH .'/../'. $file_save;

          $url_img =   BASE_URL . $file_save;

          if (move_uploaded_file($img['tmp_name'], $file_full)) {
            //  echo  "Upload file thành công" ;
            // echo  "<img src = '$url_img' width='200px'/>" ;
          } else {
            echo "Lỗi upload ảnh";
          }
        }
      } else {
        echo " ảnh chỉ 2  mb thôi";
      }
    }

    try {
      $stmt = $objConn->prepare("INSERT INTO `user`( `username`, `email`, `address`, `phone`, `pemission`, `password` ,`image`)
                 VALUES (:username , :email ,:address ,:phone ,:pemission,:password, :image )");

      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":address", $address);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":pemission", $admin);
      $stmt->bindParam(":password", $password);
      $stmt->bindParam(":image", $url_img);
      $stmt->execute();

      header("Location: ?page=user");
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
    $msg = implode('<br>', $err);
  }
}
?>


<h1>Thêm tài khoản</h1>
<div style="margin-left:30px;">

  <form action="" method="post" enctype="multipart/form-data">
    <p style="color:red; font-size:16px;"> <?php echo $msg; ?></p>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Tên đăng nhập</label>
        <input type="text" class="form-control" value="<?php echo $username; ?>" name="username" placeholder="Tên đăng nhập">
      </div>
      <div class="form-group col-md-6">
        <label for="">Email</label>
        <input type="email" class="form-control" value="<?php echo $email; ?>" name="email" placeholder="Email">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Ảnh nhân viên</label>
        <input type="file" name="fileToUpload" class="form-control" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Địa chỉ</label>
        <input type="text" class="form-control" value="<?php echo $address; ?>" name="address" placeholder="Địa chỉ">
      </div>
      <div class="form-group col-md-6">
        <label for="">Số điện thoại</label>
        <input type="number" class="form-control" value="<?php echo $phone; ?>" name="phone" placeholder="Số điện thoại">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Quyền truy cập</label>
        <select name="admin" class="form-control">
          <option selected value="0">Khách hàng</option>
          <option value="1">Admin</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="">Mật khẩu</label>
        <input type="password" class="form-control" value="<?php echo $password; ?>" name="password" placeholder="Mật khẩu">
      </div>
    </div>

    <button name="addproduct" type="submit" class="btn btn-primary">Thêm tài khoản</button>
  </form>
</div>