<h3>Trang hiển thị danh mục sản phẩm</h3>
<?php
$msg ="";
$err = [];

$objConn=pdo_get_conn();
 if(isset($_GET['id'])){
    $id =$_GET['id'];
    try{
        $stmt = $objConn ->prepare(" DELETE FROM category WHERE id_category = $id ");
        $stmt -> execute();
        }catch(PDOException $e){
           echo  $e->getMessage(); 
        }
}

    if(isset($_POST['addCate'])){
        $nameCate = $_POST['name_cate'];

        $check = "SELECT * FROM category WHERE name_category='$nameCate'";
        $cout = $objConn->prepare($check);
        $cout->execute();

        if ($cout->rowCount() > 0) {
        echo  "<p style='color:red;'> Danh mục đã tồn tại </p>";
        } else {
            if($nameCate==""){
            $err[]= "Danh mục ko được để trống!";
            }
            if(empty($err)){
                try{
                    $stmt = $objConn->prepare("INSERT INTO category(name_category) VALUES(:name_category)");
                    $stmt->bindParam(":name_category",$nameCate);
                    $stmt->execute();
                }catch(PDOException $e){
                    die("Lỗi truy vấn" . $e->getMessage());
                }
            }else{
                $msg = implode("<br>" ,$err);

            }
        }

    }


?>


<div class ="danhsach" style = "width: 600px; float:left;"> 
<table class="table" style= "width:550px; margin-left:20px;">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Tên danh mục</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        try{
            $stmt = $objConn->prepare("SELECT * FROM category ");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC) ;
             $danhmuc = $stmt->fetchAll() ;
        }catch(PDOException $e){
            die("Lỗi truy vấn cỡ sở dữ liẹu");
        }
      $index=1;
        foreach($danhmuc as $cate){
    ?>
    <tr>
            <td><?php echo $index ++; ?> </td>
            <td><?php echo $cate['name_category']; ?> </td>
            <td>
            <a href="?page=category-product&action=update&id=<?php echo $cate['id_category']; ?> " class="btn btn-danger">Sửa</a>
            <a href="?page=category-product&id=<?php echo $cate['id_category']; ?>"  onclick="return confirm('Đông ý xóa danh mục này không')" class="btn btn-primary" >Xóa</a>
            </td>
    </tr>
        <?php } ?>
  </tbody>
</table>

</div>

<br>
<div>
    <form action="" method="post">
        <div class="form-group">
            <label >Thêm mới danh mục </label>
         <p style="color:red;"><?php echo $msg; ?></p>   
            <input type="text" name="name_cate" style= "width:400px;" class="form-control"  placeholder="Tên danh mục">
                <br>
            <button type="submit" name= "addCate" class="btn btn-primary">Thêm danh mục</button>
            
        </div>
    </form>
</div>