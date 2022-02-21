<?php
// kiểm tra giỏ hàng ko rỗng mới xử lý tiếp
if (!empty($_SESSION['cart'])) {
    $tong_tien = 0;
    $list_id = "";
    $list_sl = [];
    // giảm số lượng
    if (isset($_POST['btn_re'])) {
        $id_product = $_POST['id_product'];
        $_SESSION['cart'][$id_product]['sl']--;
        header("Location:?page=cart");
        if ($_SESSION['cart'][$id_product]['sl'] == 0) {
            unset($_SESSION['cart'][$id_product]);
            header("Location:?page=cart");
        }
    }
    // tăng số lượng
    if (isset($_POST['btn_in'])) {
        $id_product = $_POST['id_product'];
        $_SESSION['cart'][$id_product]['sl']++;
        header("Location:?page=cart");
    }
    if (isset($_GET['delete'])) {
        $id_delete = $_GET['delete'];
        unset($_SESSION['cart'][$id_delete]);
        header("Location:?page=cart");
    }
    // dùng vòng lặp để chuyển mảng giỏ hàng sang chuỗi
    foreach ($_SESSION['cart'] as $key => $values) {
        // $id_pro=$key;
        $list_id .= "$key,";
        $list_sl[$key] = $values['sl'];
    }
    // print_r($list_sl);
    //loại bỏ dấu , ở cuối khi đã nối chuỗi ở vòng lặp foreach
    $list_id_new = rtrim($list_id, ',');// có được list id sản phẩm 
    $sql = "SELECT id_product,name_product,sale,images,id_category FROM products WHERE id_product IN($list_id_new)";
    $list_cart_items = pdo_query($sql);
    // print_r($list_cart_items);
} else {
    $msg = "Giỏ hàng chưa có sản phẩm nào!";
}
// print_r($_SESSION['cart']);
?>
<h3>Giỏ hàng</h3>
<div class="col-md-9 bor" style="border:none">
    <section class="box-main1">
        <h4 style="color:red; margin-top:10px;"><?php if (isset($msg)) {
                                                    echo $msg;
                                                } ?></h4>
        <div id="jsGrid1" class="jsgrid" style="width:800px">
            <div class="jsgrid-grid-header jsgrid-header-scrollbar" style="width: 800px;">
                <?php 
                if (!empty($_SESSION['cart'])) {
                    foreach ($list_cart_items as $values) {
                ?>
                        <table class="table table-bordered" style="height:40px; padding:10px;">
                            <tr style="font-size: 20px;">
                                <td style="width:40px;">
                                    <img src="<?php echo $values['images'] ?>" alt="" width="150">
                                </td>
                                <td>
                                    <p style="font-size: 15px;">Tên sản phẩm: <a href="?page=detail&id=<?php echo $values['id_product'] ?>"><span style="color: red; font-size: 15px;"><?php echo $values['name_product'] ?></span></a></p>
                                    <p style="font-size: 15px;">Giá bán:<?php echo $values['sale'] ?></p>
                                    <form action="" method="post">
                                        <p style="font-size: 15px;">
                                            Số lượng: <button class="btn btn-light" name="btn_re">-</button><span style="margin:10px; font-size: 15px;"><?php echo $list_sl[$values['id_product']]; ?></span><button class="btn btn-light" name="btn_in">+</button>
                                            <input type="hidden" name="id_product" value="<?php echo $values['id_product'] ?>">
                                        </p>
                                    </form>
                                </td>
                                <td>
                                    <a href="?page=cart&delete=<?php echo $values['id_product'] ?>">Xóa sản phẩm</a>
                                </td>
                            </tr>
                    <?php
                        $tong_tien += $values['sale'] * $list_sl[$values['id_product']];
                    ?>
                    <?php }}?>
                        </table>
                        <?php if (!empty($_SESSION['cart'])) { ?>
                            <div class="row">
                                <div class="col">
                                    <div class="col font-italic" style="font-size: 19px;">Tổng số tiền cần thanh toán: <span style="color: green; font-size:20px;"><?php  $_SESSION['total']=$tong_tien;echo number_format($tong_tien) . " đ"; ?></span></div>
                                </div>
                            </div>
                            <div class="row" style="margin-left:15px;margin-top:10px;">
                                <a href="?page=info-take-items"><button type="button" class="btn btn-outline-success" style="width:150px;height:45px;">Mua hàng</button></a>
                            </div>
                        <?php } ?>
            </div>
        </div>
    </section>
</div>