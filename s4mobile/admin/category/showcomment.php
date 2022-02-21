<?php
    // phân trang
    $row_count = pdo_query_one("SELECT COUNT(id_cmt) AS 'total' FROM comments");
    $total_records = $row_count['total'];
    $current_page = isset($_GET['page_control']) ? $_GET['page_control'] : 1;
    $limit = 8;
    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if($total_records==0){
        $list_comments=[];
    }
    else{
        $sql = "SELECT cm.id_product,pr.name_product, COUNT(*) as 'sl' FROM comments as cm INNER JOIN products AS pr 
        ON cm.id_product=pr.id_product GROUP BY cm.id_product LIMIT $start,$limit";
        $list_comments = pdo_query($sql);
    }
?>
<div class="card-body">
    <h5 class="card-title m-b-0">Bình luận</h5>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên sản phẩm bình luận</th>
            <th scope="col">Số lượng bình luận</th>
            <th scope="col">Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($list_comments as $row) {
        ?>
            <tr>
                <td><?php echo $row['id_product'] ?></td>
                <td><?php echo $row['name_product'] ?></td>
                <td><?php echo $row['sl'] ?></td>
                <td><a href="?page=detail-comments&id=<?php echo $row['id_product'] ?>">Xem chi tiết</a></td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>
<div class="pagination" style="margin:5px;">
  <?php
    if($current_page>1 && $total_page>1){
      echo '<a href="index.php?page=comments&page_control='.($current_page-1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Prev</button></a>';
    }
    for($i=1;$i<=$total_page;$i++){
      if($i==$current_page){
          echo "<button type=\"button\" class=\"btn btn-outline-dark\" style=\"margin-right:5px;\">$i</button>";
      }
      else{
          echo '<a href="index.php?page=comments&page_control='.$i.'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">'.$i.'</button></a>';
      }
    }
    if ($current_page < $total_page && $total_page > 1){
      echo '<a href="index.php?page=comments&page_control='.($current_page+1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Next</button></a>';
    }
  ?>
</div>