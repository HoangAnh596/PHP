<?php
$objConn = pdo_get_conn();
$id = $_GET['id'];
if (isset($_GET['id'])) {
    try {
        $stmt = $objConn->prepare("SELECT * FROM category  where id_category = $id");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $cate = $stmt->fetch();
    } catch (PDOException $e) {
        die("Lỗi truy vấn cỡ sở dữ liẹu");
    }

    if (isset($_POST['editCate'])) {

        $name_cate =  $_POST['name_cate'];

        $stmt = $objConn->prepare("UPDATE category SET name_category=:name_category WHERE id_category = $id");
        $stmt->bindParam(":name_category", $name_cate);
        $stmt->execute();
        header("Location: ?page=category-product");
    }
}
?>
<h1>Sửa danh mục</h1>
<div style="margin:60px;">
    <form action="" method="post">
        <div class="form-group">
            <label style="font-size:20px;">Sửa danh mục </label>
            <input type="text" name="name_cate" value="<?php echo  $cate['name_category']; ?>" style="width:400px;" class="form-control" placeholder="Tên danh mục" required>
            <br>
            <button type="submit" name="editCate" class="btn btn-primary">Sửa danh mục</button>

        </div>
    </form>
</div>