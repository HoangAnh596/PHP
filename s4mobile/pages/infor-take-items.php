<?php
if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    header("Location:?page=login");
} else {
    if(isset($_SESSION['user'])){
        $sql="SELECT * FROM user WHERE username='{$_SESSION['user']}'";
        $user_order=pdo_query_one($sql);
    }
    if(isset($_SESSION['admin'])){
        $sql="SELECT * FROM user WHERE username='{$_SESSION['admin']}'";
        $user_order=pdo_query_one($sql);
    }
    // print_r($user_order);
    if (isset($_POST['btn_sub'])) {
        // validate
        $err=[];
        $id_user=$user_order['id_user'];
        $customer_name = $_POST['customer_name'];
        $customer_email=$_POST['customer_email'];
        $address=$_POST['address'];
        $customer_phone=$_POST['customer_phone'];
        if(empty($customer_name)){
            $err['cus_name']='Bạn chưa nhập họ tên';
        }
        if(empty($customer_email)){
            $err['cus_email']='Bạn chưa nhập email';
        }
        if(empty($address)){
            $err['address']='Bạn chưa nhập địa chỉ';
        }
        if(empty($customer_phone)){
            $err['cus_phone']='Bạn chưa nhập số điện thoại';
        }
        if(empty($err)){
            $created_at = date('Y/m/d H:i:s');
            $total_price=$_SESSION['total'];
            $params=[
                'customer_name'=>$customer_name,
                'customer_email'=>$customer_email,
                'address'=>$address,
                'customer_phone'=>$customer_phone,
                'created_at'=>$created_at,
                'id_user'=>$id_user,
                'total_price'=>$total_price
            ];
            $sql_order="INSERT INTO orders(customer_name,customer_email,address,customer_phone,created_at,id_user,total_price) 
            VALUES(:customer_name,:customer_email,:address,:customer_phone,:created_at,:id_user,:total_price)";
            $id_order=pdo_execute($sql_order,$params);
            $list_id_product = [];
            $list_sl_product = [];
            foreach ($_SESSION['cart'] as $key => $values) {
                $list_id_product[$key] = $key;
                $list_sl_product[$key] = $values['sl'];
            }
            foreach($list_id_product as $key) {
                $params=[
                    'id_product'=>$list_id_product[$key],
                    'id_order'=>$id_order,
                    'amount'=>$list_sl_product[$key]
                ];
                pdo_execute("INSERT INTO orderdetail(id_product,id_order,amount) VALUES(:id_product,:id_order,:amount)",$params);
            }
            unset($_SESSION['cart']);
            header("Location:?page=infor-order&id=$id_order");
        }
    }
}
?>
<div class="col-md-9 bor">
    <section class="box-main1">
        <div class="card card-info">
            <div class="card-header" style="color:green;">
                <h4 class="card-title">Địa chỉ người nhận</h4>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Họ tên</span>
                        </div>
                        <input type="text" class="form-control" name="customer_name" style="width:350px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="color: red;"><?php echo @$err['cus_name']?></span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Email</span>
                        </div>
                        <input type="text" class="form-control" name="customer_email" value="<?php echo $user_order['email']?>" style="width:350px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="color: red;"><?php echo @$err['cus_email']?></span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Số điện thoại</span>
                        </div>
                        <input type="text" class="form-control" name="customer_phone" value="<?php echo $user_order['phone']?>" style="width:350px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="color: red;"><?php echo @$err['cus_phone']?></span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Địa chỉ nhận hàng</span>
                        </div>
                        <input type="text" class="form-control" value="<?php echo $user_order['address']?>" name="address" style="width:350px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="color: red;"><?php echo @$err['address']?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><span class="font-weight-bold">Thanh toán: </span><input type="radio" name="pay_menthod" checked> Tiền mặt<br><br></div>
                    </div>
                    <div class="row">
                        <div class="col"><button type="submit" class="btn btn-outline-success" name="btn_sub">Đặt hàng</button></div>
                    </div>
                </div>
            </form>
        </div>
</div>
</section>
</div>