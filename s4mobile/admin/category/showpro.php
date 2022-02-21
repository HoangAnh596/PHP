<h3>Trang hiển thị sản phẩm</h3>

<a href="?page=product&action=add" class="btn btn-primary">Thêm sản phẩm</a>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">ảnh sản phẩm</th>
      <th scope="col">Giá sale</th>
      <th scope="col">Giá cũ</th>
      <th scope="col">Số lượng</th>
      <th scope="col">Danh mục</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // phân trang
    $row_count=pdo_query("SELECT COUNT(*) AS 'total' FROM products");
    $total_records=$row_count[0]['total'];
    $current_page=isset($_GET['page_control'])?$_GET['page_control']:1;
    $limit=5;
    $total_page=ceil($total_records/$limit);
    if($current_page>$total_page){
      $current_page=$total_page;
    }
    else if($current_page<1){
        $current_page=1;
    }
    $start=($current_page-1)*$limit;
    $objConn=pdo_get_conn();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      try {
        $stmt = $objConn->prepare(" DELETE FROM products WHERE id_product = $id ");
        $stmt->execute();
      } catch (PDOException $e) {
        echo  $e->getMessage();
      }
    }
    if($total_records==0){
      $products=[];
    }
    else{
      try {
        $stmt = $objConn->prepare("SELECT id_product,name_product ,images, sale, price_old, amount,detail,name_category  FROM products 
                                  INNER JOIN category ON products.id_category = category.id_category LIMIT $start,$limit");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $products = $stmt->fetchAll();
      } catch (PDOException $e) {
        die("Lỗi truy vấn cỡ sở dữ liẹu");
      }
    }
    foreach ($products as $product) {
    ?>

      <tr>
        <td><?php echo  $product['id_product'] ?></td>
        <td><?php echo  $product['name_product'] ?></td>
        <td><img src="<?php echo $product['images'];  ?>" style="width:150px;" alt=""></td>
        <td><?php echo  $product['sale'] ?></td>
        <td><?php echo  $product['price_old'] ?></td>
        <td><?php echo  $product['amount'] ?></td>
        <td><?php echo  $product['name_category'] ?></td>
        <td>
          <a href="?page=product&action=update&id=<?php echo $product['id_product']; ?> " class="btn btn-danger">Sửa</a>
          <a href="?page=product&id=<?php echo $product['id_product']; ?>" onclick="return confirm('Đông ý xóa danh mục này không')" class="btn btn-primary">Xóa</a>
        </td>
      </tr>

    <?php
    } ?>
  </tbody>
</table>
<div class="pagination" style="margin:5px;">
  <?php
    if($current_page>1 && $total_page>1){
      echo '<a href="index.php?page=product&page_control='.($current_page-1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Prev</button></a>';
    }
    for($i=1;$i<=$total_page;$i++){
      if($i==$current_page){
          echo "<button type=\"button\" class=\"btn btn-outline-dark\" style=\"margin-right:5px;\">$i</button>";
      }
      else{
          echo '<a href="index.php?page=product&page_control='.$i.'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">'.$i.'</button></a>';
      }
    }
    if ($current_page < $total_page && $total_page > 1){
      echo '<a href="index.php?page=product&page_control='.($current_page+1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Next</button></a>';
    }
  ?>
</div>