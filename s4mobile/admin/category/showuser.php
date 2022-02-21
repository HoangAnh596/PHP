<h3>Trang hiển thị user</h3>


<a href="?page=user&action=add" class="btn btn-primary">Thêm tài khoản</a>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID </th>
      <th scope="col">Tên đăng nhập</th>
      <th scope="col">Ảnh tv</th>
      <th scope="col">Email</th>
      <th scope="col">Địa chỉ</th>
      <th scope="col">Số điện thoại </th>
      <th scope="col">Quyền truy cập</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $objConn = pdo_get_conn();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      try {
        $stmt = $objConn->prepare(" DELETE FROM user WHERE id_user = $id ");
        $stmt->execute();
      } catch (PDOException $e) {
        echo  $e->getMessage();
      }
    }
    // phân trang
    $row_count = pdo_query("SELECT COUNT(*) AS 'total' FROM user");
    $total_records = $row_count[0]['total'];
    $current_page = isset($_GET['page_control']) ? $_GET['page_control'] : 1;
    $limit = 5;
    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page) {
      $current_page = $total_page;
    } else if ($current_page < 1) {
      $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if($total_records==0){
      $users=[];
    }
    else{
      try {
        $stmt = $objConn->prepare("SELECT *  FROM user LIMIT $start,$limit");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $users = $stmt->fetchAll();
      } catch (PDOException $e) {
        die("Lỗi truy vấn cỡ sở dữ liẹu");
      }
    }

    foreach ($users as $user) {
    ?>

      <tr>
        <td><?php echo  $user['id_user'] ?></td>
        <td><?php echo  $user['username'] ?></td>
        <td><img style="width:150px;" src="<?php echo  $user['image'] ?>" alt=""></td>
        <td><?php echo  $user['email'] ?></td>
        <td><?php echo  $user['address'] ?></td>
        <td><?php echo  $user['phone'] ?></td>
        <td><?php echo ($user['pemission'] == 0) ? "Khách hàng" : "Admin";  ?></td>
        <td>
          <a href="?page=user&action=update&id=<?php echo $user['id_user']; ?> " class="btn btn-danger">Sửa</a>
          <a href="?page=user&id=<?php echo $user['id_user']; ?>" onclick="return confirm('Bạn có đồng ý xóa tài khoản này không?')" class="btn btn-primary">Xóa</a>
        </td>
      </tr>

    <?php
    } ?>


  </tbody>
</table>
<div class="pagination" style="margin:5px;">
  <?php
    if($current_page>1 && $total_page>1){
      echo '<a href="index.php?page=user&page_control='.($current_page-1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Prev</button></a>';
    }
    for($i=1;$i<=$total_page;$i++){
      if($i==$current_page){
          echo "<button type=\"button\" class=\"btn btn-outline-dark\" style=\"margin-right:5px;\">$i</button>";
      }
      else{
          echo '<a href="index.php?page=user&page_control='.$i.'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">'.$i.'</button></a>';
      }
    }
    if ($current_page < $total_page && $total_page > 1){
      echo '<a href="index.php?page=user&page_control='.($current_page+1).'"><button type="button" class="btn btn-outline-info" style="margin-right:5px;">Next</button></a>';
    }
  ?>
</div>