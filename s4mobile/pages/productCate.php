<?php

    $id = $_GET['id'];
    // phân trang
    $row_count=pdo_query("SELECT COUNT(*) AS 'total' FROM products WHERE id_category = $id");
    $total_records=$row_count[0]['total'];
    $current_page=isset($_GET['page_control'])?$_GET['page_control']:1;
    $limit=6;
    $total_page=ceil($total_records/$limit);
    if($current_page>$total_page){
      $current_page=$total_page;
    }
    else if($current_page<1){
        $current_page=1;
    }
    $start=($current_page-1)*$limit;
    if($total_records==0){
        $products=[];
    }
    else{
        $stmt  = $objConn->prepare("SELECT * FROM products WHERE id_category = $id LIMIT $start,$limit");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $products = $stmt->fetchAll();
    }
?>

<div class="col-md-9 bor">

    <section class="box-main1">
        <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Tất cả sản phẩm danh mục </a> </h3>
        <div class="showitem">
            <?php foreach ($products as $product) {
                $bought = pdo_query_one("SELECT COUNT(id_product) as 'count' FROM orderdetail WHERE id_product={$product['id_product']}");
            ?>
                <div class="col-md-3 item-product bor">
                    <a href="?page=detail&id=<?php echo $product['id_product']; ?>">
                        <img src="<?php echo $product['images']; ?>" class="" width="100%" height="180">
                    </a>
                    <div class="info-item">
                        <a href="?page=detail&id=<?php echo $product['id_product']; ?>"><?php echo $product['name_product']; ?></a>
                        <p><strike class="sale"><?php echo number_format($product['price_old']) . "đ"; ?></strike> <b class="price"><?php echo number_format($product['sale']) . "đ"; ?> </b></p>
                        <form action="" method="post">
                            <input type="hidden" name="id_cart" value="<?php echo $product['id_product']; ?>">
                            <button style="margin-top: 10px; padding: 6px; background-color:#00BBA6 ;color: white;margin-left: 8%;border-radius: 5px; width:80px;height:35px;font-weight:bolder;font-size:12px;" class="btn" name="btn_add_cart">Chọn mua</button>
                        </form>
                    </div>
                    <div class="hidenitem">
                        <p><i class="fa fa-eye"> <?php echo $product['view'] ?></i></p>
                        <p><i class="fa fa-shopping-basket"> <?php echo $bought['count'] ?></i></p>
                        <p><i class="fa fa-star"> <?php if($product['count_point']!=0){echo round($product['point']/$product['count_point'],1);}?></i></p>
                    </div>
                </div>
            <?php } ?>

        </div>
    </section>
    <div class="pagination" style="margin:5px;">
  <?php
    if($current_page>1 && $total_page>1){
      echo '<a href="index.php?page=productCate&'."id=$id".'page_control='.($current_page-1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Prev</button></a>';
    }
    for($i=1;$i<=$total_page;$i++){
      if($i==$current_page){
          echo "<button type=\"button\" class=\"btn btn-outline-dark\" style=\"margin-right:5px;\">$i</button>";
      }
      else{
          echo '<a href="index.php?page=productCate&'."id=$id".'&page_control='.$i.'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">'.$i.'</button></a>';
      }
    }
    if ($current_page < $total_page && $total_page > 1){
      echo '<a href="index.php?page=productCate&'."id=$id".'page_control='.($current_page+1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Next</button></a>';
    }
  ?>
</div>