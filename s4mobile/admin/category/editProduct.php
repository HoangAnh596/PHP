<?php 
$objConn = pdo_get_conn();
try{
  $stmt = $objConn->prepare("SELECT * FROM category") ;
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC) ;
  $category = $stmt->fetchAll() ;
}catch(Exception $e){
  echo "lỗi truy vấn".$e->getMessage();
}

$id = $_GET['id'];

try{
    $stmt= $objConn->prepare("SELECT * FROM products WHERE id_product = $id ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $product = $stmt->fetch() ;

}catch(Exception $e){
    echo "Lỗi truy vấn CSDL".$e->getMessage();
}
    if(isset($_POST['btnEdit'])){

      

      $name = $_POST['name_product'];
      // $img = $_POST['fileToUpload'];
      $sale = $_POST['sale'];
      $price = $_POST['price'];
      $cate = $_POST['cate'];
      $name = $_POST['name_product'];
      $amount = $_POST['amount'];
      $detail = $_POST['detail'];
      $describe = $_POST['describe'];

      if (isset($_FILES['fileToUpload'])) {
        $img = $_FILES['fileToUpload'];
        $Maxsize = 20000000;
        $arr_low_type =  ['image/jpeg', 'image/jpg', 'image/png'];
        if ($img['size'] < $Maxsize) {
  
          if (in_array($img['type'], $arr_low_type)) {
            $msg = 'File hợps lệs';
            $file_save = '/images/product/' . $img['name'];
            $file_full =  APP_PATH .'/../'. $file_save;
  
            $url_img =   BASE_URL . $file_save;
  
            if (move_uploaded_file($img['tmp_name'], $file_full)) {
              //  echo  "Upload file thành công" ;
              echo  "<img src = '$url_img' width='200px'/>";
            } else {
              echo   "Lỗi upload ảnh";
            }
          } else {
            echo "bạn cần up đúng  là file ảnh có đuổi là jpg và png";
          }
        } else {
          echo " ảnh chỉ 2  mb thôi";
        }
      }
      try{
        $sql = " UPDATE products SET name_product=:name_product , sale=:sale, price_old=:price 
        , amount=:amount , detail=:detail ,decribe=:describe ,id_category=:id_category ";

        if(!empty($url_img)){
          $sql .= "  ,images=:images";
        }
        $sql .= " WHERE id_product = $id";
        $stmt = $objConn->prepare($sql);

        if(!empty($url_img)){
          $stmt->bindParam(":images",$url_img);
        }
        $stmt->bindParam(":name_product",$name);
        $stmt->bindParam(":sale",$sale);
        $stmt->bindParam(":price",$price);
        $stmt->bindParam(":amount",$amount);
        $stmt->bindParam(":detail",$detail);
        $stmt->bindParam(":describe",$describe);
        $stmt->bindParam(":id_category",$cate);
        $stmt->execute();

        header("Location: ?page=product");


      } catch (PDOException $e) {
        echo $e->getMessage();
    }

    }  

   
?>

<h1>Thêm sản phẩm</h1>
<div style = "margin-left:30px;">

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="">Tên sản phẩm</label>
      <input type="text" class="form-control" value ="<?php echo $product['name_product']; ?>" name= "name_product"  placeholder="Tên sản phẩm">
    </div>
    <div class="form-group col-md-6">
      <label>Ảnh sản phẩm</label>
      <input type="file" name="fileToUpload" class="form-control">
      <img width="200px;" height="100px" src="<?php echo $product['images']; ?>" alt="">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">giá sale</label>
      <input type="number" class="form-control" value ="<?php echo $product['sale']; ?>" name = "sale"  placeholder="giá sale">
    </div>
    <div class="form-group col-md-6">
      <label>giá bán</label>
      <input type="number" class="form-control" value ="<?php echo $product['price']; ?>" name="price" placeholder="giá bán">
    </div>
  </div>

  <div class="form-row">
  <div class="form-group col-md-6" >
  <label>Danh mục sản phẩm</label>
    <select  name = "cate" class="custom-select">

    <?php  foreach($category as $cat){ 
      $selectdCat = ($product['id_category']== $cat['id_category']) ? "selected" : "";

      ?>
      <option <?php echo $selectdCat;  ?>  value="<?php echo $cat['id_category'];  ?>"><?php echo $cat['name_category']; ?></option>
    <?php } ?>
    </select>
  </div>
    <div class="form-group col-md-6">
        <label>Số lượng</label>
        <input type="number" class="form-control" value ="<?php echo $product['amount']; ?>" name="amount" placeholder="Số lượng">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="">Mô tả</label>
        <textarea class="form-control" name="detail" placeholder="Mô tả" id="detail_ck"><?php echo $product['detail']; ?></textarea>
      </div>
      <div class="form-group col-md-6">
        <label>Chi tiết</label>
        <textarea class="form-control" id="describe_ck" name="describe" placeholder="Chi tiết"><?php echo $product['decribe']; ?></textarea>
      </div>
  </div>
   
  <button name="btnEdit" type="submit" class="btn btn-primary">Sửa sản phẩm</button>
</form>
</div>
<script>CKEDITOR.replace('detail_ck');
         CKEDITOR.replace('describe_ck'); 
</script>