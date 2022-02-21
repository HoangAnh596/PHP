<?php
    // phân trang
    $row_count = pdo_query("SELECT COUNT(*) AS 'total' FROM orders WHERE id_user={$list_info_user['id_user']}");
    $total_records = $row_count[0]['total'];
    $current_page = isset($_GET['page_control']) ? $_GET['page_control'] : 1;
    $limit = 1;
    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page) {
      $current_page = $total_page;
    } else if ($current_page < 1) {
      $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if($total_records==0){
        echo "<h3 style='color:red;'>Bạn chưa có đơn hàng nào!</h3>";
        exit();
    }
    else{
        $sql = "SELECT id_user FROM user WHERE username='$username'";
        $id_us = pdo_query_one($sql);
        // $sql_order="SELECT ord.id_order,ord.created_at,pro.name_product, ordd.amount,pro.sale,pro.images FROM orders as ord INNER JOIN orderdetail as ordd ON ord.id_order=ordd.id_order 
        //             INNER JOIN products as pro ON pro.id_product=ordd.id_product WHERE ord.id_user={$id_us['id_user']}";
        $sql_order = "SELECT id_order,customer_name,address,customer_phone,created_at,total_price,ck_delivery FROM orders WHERE id_user='{$id_us['id_user']}' LIMIT $start,$limit";
        $list_order = pdo_query($sql_order);
    }
// print_r($list_order);
?>
<?php foreach ($list_order as $values) {
    $total_or = $values['total_price'] ?>
    <div class="col-md-9 bor" style="margin-top:10px;">
        <section class="box-main1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5" style="font-size: 17px;">Id đơn hàng: <?php echo $values['id_order'] ?></div>
                    <div class="col-md-7" style="font-size: 17px;">Ngày đặt hàng: <?php echo $values['created_at'] ?></div>
                    <div class="col-md-7" style="font-size: 17px; color:red">Trạng thái: 
                    <?php 
                        if($values['ck_delivery']==0){
                            echo "Hàng chưa được giao"; 
                        }
                        else{
                            echo "Giao hàng thành công";
                        }
                    ?></div>
                </div>
                <div class="row" style="margin:5px 2px; padding:5px;">
                    <h4>Thông tin người nhận</h4>
                    <div class="col-md" style="margin-left:15px;">
                        <div class="row">
                            Họ tên: <?php echo $values['customer_name'] ?>
                        </div>
                        <div class="row">
                            Địa chỉ: <?php echo $values['address'] ?>
                        </div>
                        <div class="row">
                            Số điện thoại: <?php echo $values['customer_phone'] ?>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:15px; border-bottom:1px solid gray;padding-bottom:5px;">
                    <h4>Sản phẩm</h4>
                </div>
                <?php
                $sql_orderdetail = "SELECT pr.name_product,pr.images,pr.sale,ordd.amount FROM orderdetail AS ordd 
                                  INNER JOIN products as pr ON ordd.id_product=pr.id_product WHERE ordd.id_order={$values['id_order']}";
                $list_orderdetail = pdo_query($sql_orderdetail);
                foreach ($list_orderdetail as $values) {
                ?>
                    <div class="row" style="margin:15px 0px;">
                        <div class="col-md">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?php echo $values['images'] ?>" alt="" width="150">
                                </div>
                                <div class="col-md-8">
                                    <div class="row" style="font-size: 15px;">
                                        Tên sản phẩm: <?php echo $values['name_product'] ?>
                                    </div>
                                    <div class="row" style="font-size: 15px;">
                                        Giá tiền: <?php echo $values['sale'] ?>
                                    </div>
                                    <div class="row" style="font-size: 15px;">
                                        Số lượng: <?php echo $values['amount'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row" style="margin:5px;">
                <p style="color: red;font-size: 18px;">Tổng tiền đơn hàng: <?php echo number_format($total_or).' đ'; ?></p>
            </div>
        </section>
    </div>
    <div class="pagination" style="margin:5px;">
  <?php
    if($current_page>1 && $total_page>1){
      echo '<a href="index.php?page=my-order&page_control='.($current_page-1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Trước</button></a>';
    }
    for($i=1;$i<=$total_page;$i++){
      if($i==$current_page){
          echo "<button type=\"button\" class=\"btn btn-outline-dark\" style=\"margin-right:5px;\">$i</button>";
      }
      else{
          echo '<a href="index.php?page=my-order&page_control='.$i.'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">'.$i.'</button></a>';
      }
    }
    if ($current_page < $total_page && $total_page > 1){
      echo '<a href="index.php?page=my-order&page_control='.($current_page+1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Tiếp</button></a>';
    }
  ?>
</div>
<?php } ?>