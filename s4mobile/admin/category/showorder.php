<?php
// phân trang
    $row_count = pdo_query_one("SELECT COUNT(*) AS 'total' FROM orders");
    $total_records = $row_count['total'];
    $current_page = isset($_GET['page_control']) ? $_GET['page_control'] : 1;
    $limit = 6;
    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if($total_records==0){
        $list_orders=[];
    }
    else{
        $sql = "SELECT * FROM orders LIMIT $start,$limit";
        $list_orders = pdo_query($sql);
    }
// print_r($list_orders);
?>
<div class="card-body">
    <h5 class="card-title m-b-0">Đơn hàng</h5>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Mã đơn hàng</th>
            <th scope="col">Tên khách hàng</th>
            <th scope="col">Số điện thoại</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Ngày đặt hàng</th>
            <th scope="col">Xem chi tiết</th>
            <th scope="col">Xác nhận</th>
            <th scope="col">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_orders as $row) { ?>
            <tr>
                <td><?php echo $row['id_order'] ?></td>
                <td><?php echo $row['customer_name'] ?></td>
                <td><?php echo $row['customer_phone'] ?></td>
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
                <td>
                    <a href="?page=order&action=detail&id=<?php echo $row['id_order'] ?>">Xem chi tiết đơn hàng</a>
                </td>
                <td>
                    <?php
                    if ($row['ck_delivery']) {
                        echo "Đã giao hàng";
                    } else {
                        echo "<a href=\"?page=order&action=check-delivery&id={$row['id_order']}\" onClick=\"return(confirm('Xác nhận đơn hàng đã được giao!'))\">Xác nhận giao hàng</a>";
                    }
                    ?>
                </td>
                <td><a href="?page=order&action=delete&id=<?php echo $row['id_order'] ?>"><button class="btn btn-outline-danger" type="button" onClick="return(confirm('Bạn có thực sự muốn xóa không'))">Xóa</button></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="pagination" style="margin:5px;">
  <?php
    if($current_page>1 && $total_page>1){
      echo '<a href="index.php?page=order&page_control='.($current_page-1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Prev</button></a>';
    }
    for($i=1;$i<=$total_page;$i++){
      if($i==$current_page){
          echo "<button type=\"button\" class=\"btn btn-outline-dark\" style=\"margin-right:5px;\">$i</button>";
      }
      else{
          echo '<a href="index.php?page=order&page_control='.$i.'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">'.$i.'</button></a>';
      }
    }
    if ($current_page < $total_page && $total_page > 1){
      echo '<a href="index.php?page=order&page_control='.($current_page+1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Next</button></a>';
    }
  ?>
</div>