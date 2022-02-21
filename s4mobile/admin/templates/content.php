<?php
    $total_cate=pdo_query_one("SELECT COUNT(*) AS 'total' FROM category");
    $total_pro=pdo_query_one("SELECT COUNT(*) AS 'total' FROM products");
    $total_users=pdo_query_one("SELECT COUNT(*) AS 'total' FROM user");
    $total_orders=pdo_query_one("SELECT COUNT(*) AS 'total' FROM orders");
    $total_view=pdo_query_one("SELECT SUM(view) AS 'view' FROM products");
?>
<div class="container-fluid">
    <div class="row">
        <h3>Xin chào Admin</h3>
    </div>
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="fa fa-table m-b-5 font-16"></i></h1>
                    <h5 class="text-white"><span style="font-size: 20px;"><?php echo $total_cate['total']?></span> Danh mục sản phẩm</h5>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="fa fa-cart-plus m-b-5 font-16"></i></h1>
                    <h5 class="text-white"><span style="font-size: 20px;"><?php echo $total_pro['total']?></span> Sản phẩm</h5>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-warning text-center">
                    <h1 class="font-light text-white"><i class="fa fa-user m-b-5 font-16"></i></h1>
                    <h5 class="text-white"><span style="font-size: 20px;"><?php echo $total_users['total']?></span> Khách hàng</h5>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="fa fa-tag m-b-5 font-16"></i></h1>
                    <h5 class="text-white"><span style="font-size: 20px;"><?php echo $total_orders['total']?></span> Đơn hàng</h5>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white"><i class="fa fa-globe m-b-5 font-16"></i></h1>
                    <h5 class="text-white"><span style="font-size: 20px;"><?php echo $total_view['view']?></span> Lượt xem sản phẩm</h5>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
    </div>
</div>