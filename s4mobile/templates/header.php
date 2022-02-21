<?php
    // xử lý session giỏ hàng
    if (isset($_POST['btn_add_cart'])) {
        $id_cart = $_POST['id_cart'];
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!isset($_SESSION['cart'][$id_cart])) {
            $_SESSION['cart'][$id_cart]['sl'] = 1;
        } else {
            $_SESSION['cart'][$id_cart]['sl']++;
        }
        if(isset($_POST['quantity'])){
            $quantity=$_POST['quantity'];
            $_SESSION['cart'][$id_cart]['sl']=$quantity;
        }
    }
    // lấy thông tin webste 
    $sql_info = "SELECT * FROM information";
    $list_infor_website = pdo_query_one($sql_info);
    // lấy thông tin tài khoản
    if (isset($_SESSION['admin'])) {
        $username = $_SESSION['admin'];
        $sql = "SELECT * FROM user WHERE username='$username'";
        $list_info_user = pdo_query_one($sql);
    }
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM user WHERE username='$username'";
        $list_info_user = pdo_query_one($sql);
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>S4Mobile</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">

    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!---->
    <link rel="stylesheet" type="text/css" href="public/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="public/css/slick-theme.css" />
    <!--slide-->
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/style/jquery.nice-number.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
    <script src="public/style/jquery.nice-number.js" ></script>
    <style>
        label{
            font-size: 15px;
        }
        .input-group-prepend span {
            font-size: 20px;
        }

        #menu_profile {
            font-size: 15px;
        }

        /*
        #menu_profile li{
            position: relative;
        }
        #menu_profile:hover{
            text-shadow: 0px 0px 0.5px #00BBA6;
        }
        #menu_profile_sub{
            position: absolute;
        }
        #menu_profile_sub li{
            border-bottom: 1px solid #00BBA6;
            display: none;
        }
        #menu_profile:hover>#menu_profile_sub li{
            display: inline-block;
        } */
        .form-group-rate .btn{
            border-radius: 0px;
            background-color: #EFEFEF;
        }
        .form-group-rate .btn i{
            color: black;
        }
        .form-group-rate .btn:hover{
            background-color:#EFEFEF;
        }
        .form-group-rate .btn:focus{
            background-color: yellow;
            outline: none;
        }
        .form-group-rate button{
            width: 50px;
        }
        .dropbtn {
            background-color: #00BBA6;
            color: white;
            font-size: 16px;
            border: none;
            padding: 5px;
            font-size: 16px;
            font-size: 16px;
            border-radius: 5px;
            height: 30px;
            margin-top: 2px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            /* background-color: #3e8e41; */
            text-shadow: 0px 0px 1px white;
        }
        .nice-number{
            margin-top: 5px;
            margin-left: 80px;
        }
        .nice-number button{
            width: 35px;
            height: 35px;
        }
        .nice-number input{
            margin: 0px 5px;
            padding: 0px 15px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!---->
        <!--HEADER-->
        <div id="header">
            <div id="header-top">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-6" id="header-text">

                        </div>
                        <div class="col-md-6">
                            <nav id="header-nav-top">
                                <ul class="list-inline pull-right" id="headermenu">
                                    <?php
                                    if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
                                        if (isset($_SESSION['admin'])) {
                                            $link_admin = "<a href=\"admin\">Quản trị website</a>";
                                        }
                                    ?>
                                        <li id="menu_profile">
                                            <?php if (isset($_SESSION['admin'])) {
                                                echo "<img src=\"{$list_info_user['image']}\" class=\"img-circle\" alt=\"\"\" width=35>";
                                                echo "Xin chào " . $_SESSION['admin'];
                                            } else {
                                                echo "<img src=\"{$list_info_user['image']}\" width=35 class=\"img-circle\" alt=\"\">";
                                                echo "Xin chào " . $_SESSION['user'];
                                            } ?>
                                            <!-- <ul id="menu_profile_sub">
                                                <li><a href="">Thông tin tài khoản</a></li>
                                                <li><a href="">Quản trị đơn hàng</a></li>
                                            </ul> -->
                                        </li>
                                        <li>
                                            <div class="dropdown">
                                                <button onclick="myFunction()" class="dropbtn">Chức năng</button>
                                                <div id="myDropdown" class="dropdown-content">
                                                    <a href="?page=info-user">Thông tin tài khoản</a>
                                                    <a href="?page=my-order">Đơn hàng của tôi</a>
                                                    <?php echo @$link_admin; ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="?page=logout"><i class="fa fa-unlock"></i> Đăng xuất</a>
                                        </li>
                                    <?php    } else { ?>
                                        <li>
                                            <a href="?page=login"><i class="fa fa-unlock"></i> Đăng nhập</a>
                                        </li>
                                        <li>
                                            <a href="?page=register"><i class="fa fa-user"></i> Đăng kí</a>
                                        </li>
                                    <?php  } ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row" id="header-main" style="height: 100px;">
                    <div class="col-md-4">
                        <a href="?page">
                            <img src="<?php echo $list_infor_website['logo'] ?>" style="    margin-top: -10px;" height="55" width="60">
                            <span style="color: red; font-size:20px;color:#DA1719;font-weight:lighter;font-family: 'Fira Sans', sans-serif;"><?php echo $list_infor_website['name_website'] ?></span>
                        </a>
                    </div>
                    <div class="col-md-5">
                        <form method="post" action="?page=search" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="name_products" placeholder="Nhập tên cần tìm..." class="form-control">
                                <button type="submit" name="btnSearch" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3" id="header-right">
                        <div class="pull-right">
                            <div class="pull-left">
                                <i class="glyphicon glyphicon-phone-alt"></i>
                            </div>
                            <div class="pull-right">
                                <p id="hotline">HOTLINE</p>
                                <p><?php echo $list_infor_website['phone'] ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--END HEADER-->
        <script>
            /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>