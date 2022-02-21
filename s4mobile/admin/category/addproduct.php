<?php
$msg = '';
$err = [];
$objConn = pdo_get_conn();
// print_r(__DIR__);

$name_product =  $sale =  $price  =   $amount = $detail =   $describe   = "";

if (isset($_POST['addproduct'])) {
  $name_product = $_POST['name_product'];
  // $img = $_POST['fileToUpload'];
  $sale = $_POST['sale'];
  $price = $_POST['price'];
  $amount = $_POST['amount'];
  $detail = $_POST['detail'];
  $describe = $_POST['describe'];
  $cate = $_POST['cate'];
  if (empty($name_product) || $name_product > 6) {
    $err[] = "Bạn cần nhập tên sản phẩm hoặc nhập tên trên 6 kí tự";
  }
  if (empty($sale)) {
    $err[] = "Bạn cần nhập giá sale";
  }
  if (empty($price)) {
    $err[] = "Bạn cần nhập giá sale";
  }
  if (empty($amount)) {
    $err[] = "Bạn cần nhập số lượng sản phẩm";
  }
  if (empty($detail)) {
    $err[] = "Bạn cần nhập chi tiết";
  }
  if (empty($describe)) {
    $err[] = "Bạn cần nhập mô tả ";
  }
  if (empty($cate)) {
    $err[] = "Bạn cần chọn danh mục cho sản phẩm";
  }

  if (empty($err)) {
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

    try {

      $stmt = $objConn->prepare(" INSERT INTO `products`( `name_product`, `images`, `sale`, `price_old`, `amount`, `detail`, `decribe`,  `id_category`)
                    VALUES (:name_product , :images, :sale ,:price, :amount ,:detail ,:describe ,:id_category )");

      $stmt->bindParam(":name_product", $name_product);
      $stmt->bindParam(":images", $url_img);
      $stmt->bindParam(":sale", $sale);
      $stmt->bindParam(":price", $price);
      $stmt->bindParam(":amount", $amount);
      $stmt->bindParam(":detail", $detail);
      $stmt->bindParam(":describe", $describe);
      $stmt->bindParam(":id_category", $cate);
      $stmt->execute();

      header("Location: ?page=product");
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
    $msg = implode('<br>', $err);
  }
}
?>


<h1>Thêm sản phẩm</h1>
<div style="margin-left:30px;">
  <p style="color:red; font-size:16px;"> <?php echo $msg; ?> </p>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Tên sản phẩm</label>
        <?php if (isset($err['name'])) { ?>
          <p style="color:red"><?php echo $err['name']; ?></p>
        <?php     }  ?>
        <input type="text" class="form-control" value="<?php echo $name_product; ?>" name="name_product" placeholder="Tên sản phẩm">
      </div>
      <div class="form-group col-md-6">
        <label>Ảnh sản phẩm</label>
        <input type="file" name="fileToUpload" class="form-control" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">giá sale</label>
        <input type="number" class="form-control" value="<?php echo $sale; ?>" name="sale" placeholder="giá sale">
      </div>
      <div class="form-group col-md-6">
        <label>giá bán</label>
        <input type="number" class="form-control" value="<?php echo $price; ?>" name="price" placeholder="giá bán">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Danh mục sản phẩm</label>
        <select name="cate" class="custom-select">
          <?php
          try {
            $stmt = $objConn->prepare("SELECT * FROM category ");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $cate = $stmt->fetchAll();
          } catch (PDOException $e) {
            die("Lỗi truy vấn cỡ sở dữ liệu");
          }
          
          foreach ($cate as $cat) { ?>
            <option value="<?php echo $cat['id_category'];  ?>"><?php echo $cat['name_category']; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label>Số lượng</label>
        <input type="number" class="form-control" value="<?php echo $amount; ?>" name="amount" placeholder="Số lượng">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Mô tả</label>
        <textarea class="form-control" value="<?php echo $detail; ?>" name="detail" placeholder="Mô tả" id="detail_ck"></textarea>
      </div>
      <div class="form-group col-md-6">
        <label>Chi tiết</label>
        <textarea class="form-control" value="<?php echo $describe; ?>" id="describe_ck" name="describe" placeholder="Chi tiết">&#10004;</textarea>
      </div>
    </div>


    <button name="addproduct" type="submit" class="btn btn-primary">Thêm sản phẩm</button>
  </form>
</div>
<script>CKEDITOR.replace('detail_ck');
         CKEDITOR.replace('describe_ck'); 
</script>