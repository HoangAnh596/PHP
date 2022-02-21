<?php
    ob_start();
    session_start();
    define("APP_PATH",__DIR__);
    define("BASE_URL",'/s4mobile');
    if(!isset($_SESSION['admin'])){
        exit('Bạn không có quyền truy cập');
    }
    require_once 'templates/pdo.php';
    require_once 'templates/header.php';
    require_once 'templates/aside.php';
    
?>
<div class="page-wrapper">
    <!-- content chính ở đây -->
    <?php
        $page=isset($_GET['page'])?$_GET['page']:"";
        switch($page){
            case '':
                include_once 'templates/content.php';
                break;
            case 'category-product':
                $action=isset($_GET['action'])?$_GET['action']:"";
                switch($action){
                    case '':
                        include_once 'category/showCate.php';
                        break;
                    case 'add':
                        break;
                    case 'delete':
                        break;
                    case 'update':
                        include_once 'category/editCate.php';
                        break;
                }
                break;
                case 'product':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case '':
                            include_once 'category/showpro.php';
                            break;
                        case 'add':
                            include_once 'category/addproduct.php';
                            break;
                        case 'update':
                            include_once 'category/editProduct.php';
                            break;
                    }
                    break;
                case 'user':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case '':
                            include_once 'category/showuser.php';
                            break;
                        case 'add':
                            include_once 'category/addUser.php';
                            break;
                        case 'update':
                            include_once 'category/editUser.php';
                            break;
                    }
                    break;
                case 'comments':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case '':
                            include_once 'category/showcomment.php';
                            break;
                        case 'add':
                            break;
                        case 'delete':
                            break;
                        case 'update':
                            break;
                    }
                    break;
                case 'slide':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case '':
                            include_once 'category/showslide.php';
                            break;
                        case 'add':
                            include_once 'category/add-slide.php';
                            break;
                        case 'delete':
                            include_once 'category/delete-slide.php';
                            break;
                        case 'update':
                            include_once 'category/edit-slide.php';
                            break;
                    }
                    break;
                case 'order':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case '':
                            include_once 'category/showorder.php';
                            break;
                        case 'add':
                            break;
                        case 'delete':
                            include_once 'category/delete-order.php';
                            break;
                        case 'update':
                            break;
                        case 'detail':
                            include_once 'category/detail-orders.php';
                            break;
                        case 'check-delivery':
                            include_once 'category/check-delivery.php';
                            break;
                    }
                    break;
                case 'detail-comments':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case 'delete':
                            include_once 'category/delete-comment.php';
                            break;
                        default:
                            include_once 'category/detail-comment.php';
                            break;
                    }
                    break;
                case 'infor-web':
                    $action=isset($_GET['action'])?$_GET['action']:"";
                    switch($action){
                        case '':
                            include_once 'category/show-infor-web.php';
                            break;
                        case 'update':
                            include_once 'category/edit-inforweb.php';
                            break;
                    }
                    break;
                default:
                    echo "Không có trang nào!";
                    break;
        }
    ?>
</div>
<?php
    require_once 'templates/footer.php';
?>