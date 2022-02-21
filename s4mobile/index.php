<?php
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    ob_start();
    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    define("APP_PATH_fr", __DIR__);
    define("BASE_URL_fr", '/s4mobile');
    require_once 'admin/templates/pdo.php';
    $objConn = pdo_get_conn();
    require_once 'templates/header.php';
    require_once 'templates/nav.php';
    require_once 'templates/aside.php';
    switch ($page) {
        case '':
            require_once 'templates/content.php';
            break;
        case 'login':
            require_once 'pages/login.php';
            break;
        case 'register':
            require_once 'pages/register.php';
            break;
        case 'logout':
            require_once 'pages/logout.php';
            break;
        case 'lien-he':
            require_once 'pages/contact.php';
            break;
        case 'detail':
            require_once 'pages/detail_product.php';
            break;
        case 'productCate':
            require_once 'pages/productCate.php';
            break;
        case 'search':
            require_once 'pages/search.php';
            break;
        case 'cart':
            require_once 'pages/add-cart.php';
        break;
        case 'info-take-items':
            require_once 'pages/infor-take-items.php';
        break;
        case 'infor-order':
            require_once 'pages/infor-order.php';
        break;
        case 'info-user':
            require_once 'pages/info-user.php';
        break;
        case 'my-order':
            require_once 'pages/my-order.php';
        break;
        default :
            echo 'Trang bạn tìm không tồn tại!';
        break;
    }
    require_once 'templates/footer.php';
    require_once 'public/js/slideshow.php';
?>
