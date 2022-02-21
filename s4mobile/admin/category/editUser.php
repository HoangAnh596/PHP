<?php
$objConn = pdo_get_conn();
$id = $_GET['id'];


if (isset($_GET['id'])) {

  $stmt = $objConn->prepare("SELECT * FROM user WHERE id_user =$id");
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $user = $stmt->fetch();
}

if (isset($_POST['addproduct'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];

  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $admin = $_POST['admin'];
  $password = md5($_POST['password']);

  if (isset($_FILES['fileToUpload'])) {
    $img = $_FILES['fileToUpload'];
    $Maxsize = 20000000;
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
    $sql = " UPDATE user SET  username=:username , email=:email ,  address=:address , phone=:phone,  pemission=:pemission  ";

    if(!empty($url_img)){
      $sql.=" ,image=:image";
    }
    // echo "<pre>";
    // print_r( $_POST);

    if(!isset($password)){
      $sql.="  ,password=:password  "; 
    }
    $sql.=" WHERE id_user=$id";

    echo $sql;

    $stmt = $objConn->prepare($sql);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":pemission", $admin);
  
    if(!empty($url_img)){
      $stmt->bindParam(":image", $url_img);
    }
    if( !isset($password)){
      $stmt->bindParam(":password", $password);
    }
    $stmt->execute();

    header("Location: ?page=user");
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>

<h1>Sửa tài khoản</h1>
<div style="margin-left:30px;">

  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Tên đăng nhập</label>
        <input type="text" class="form-control" value="<?php echo $user['username']; ?>" name="username" placeholder="Tên đăng nhập">
      </div>
      <div class="form-group col-md-6">
        <label for="">Email</label>
        <input type="email" class="form-control" value="<?php echo $user['email']; ?>" name="email" placeholder="Email">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Ảnh nhân viên</label>
        <input type="file" name="fileToUpload" class="form-control">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Địa chỉ</label>
        <input type="text" class="form-control" value="<?php echo $user['address']; ?>" name="address" placeholder="Địa chỉ">
      </div>
      <div class="form-group col-md-6">
        <label for="">Số điện thoại</label>
        <input type="number" class="form-control" value="<?php echo $user['phone']; ?>" name="phone" placeholder="Số điện thoại">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Quyền truy cập</label>
        <select name="admin" class="form-control">

          <option <?php if($user['pemission'] == 0) { echo "selected"; } ?>  value="0">Khách hàng</option>
          <option  <?php if($user['pemission'] == 1) { echo "selected"; } ?> value="1">Admin</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="">Mật khẩu</label>
        <input type="text" class="form-control"  name="password" placeholder="Mật khẩu">
      </div>
    </div>

    <button name="addproduct" type="submit" class="btn btn-primary">Thay đổi</button>
  </form>
</div>