<?php
$err =  array();
$username = "";
if (isset($_POST['btnDn'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']) ;
    if (empty($username)) {
        $err['username'] =  " <p style='color: red; font-size:16px;'> Bạn cần nhập tên đăng nhập ! </p> ";
    }
    if (empty($password)) {
        $err['password'] =  " <p  style='color: red; font-size:16px;'> Bạn cần nhập mật khẩu ! </p> ";
    }
    if (empty($err)) {
        $check = "SELECT * FROM user WHERE username = '$username' AND password = '$password' AND pemission=:pemission";
        $user = $objConn->prepare($check);
        $user->execute(array('pemission' => 0));
        $check_admin = "SELECT * FROM user WHERE username = '$username' AND password = '$password' AND pemission=:pemission";
        $admin = $objConn->prepare($check_admin);
        $admin->execute(array('pemission' => 1));
        if ($admin->rowCount() > 0) {
            $_SESSION['admin'] = $username;
            // echo "<pre>";
            // print_r($_SESSION['admin']);
            // echo "</pre>";
            // exit;
            if(!empty($_SESSION['cart'])){
                header("Location:?page=cart");
            }
            else{
                header("Location:?page");
            }
        } elseif ($user->rowCount() > 0) {
            $_SESSION['user'] = $username;
            if(!empty($_SESSION['cart'])){
                header("Location:?page=cart");
            }
            else{
                header("Location:?page");
            }
        } else {
            $err['login'] = "<pre  style='color: red; font-size:16px;'> Tài khoản hoặc mật khẩu sai </pre> ";
        }
    }
}

?>

<div class="col-md-9 bor">

    <section class="box-main1">
        <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Đăng nhập thành viên </a> </h3>

        <div class="showitem">
            <?php if (isset($err['login'])) echo $err['login']; if(!empty($_SESSION['cart'])){echo '<pre style=\'color: red; font-size:16px;\'>Đăng nhập để đặt hàng</pre>';}?>
            <form method="post">
                <div class="form-group">
                    <label for="username"> Tên đăng nhập</label>
                    <input value="<?php echo $username; ?>" type="text" name="username" class="form-control" id="username">
                    <?php if (isset($err['username'])) echo $err['username'];?>
                </div>
                <div class="form-group">
                    <label for="pass">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" id="pass">
                    <?php if (isset($err['password'])) echo $err['password']; ?>
                </div>

                <button type="submit" name="btnDn" class="btn btn-primary">Đăng nhập</button>
            </form>

        </div>
    </section>

</div>