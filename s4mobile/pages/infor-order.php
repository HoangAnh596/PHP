<?php
$id_dh = $_GET['id'];
if (isset($id_dh)) {
    $tong = 0;
    $sql_dh = "SELECT ord.customer_name, ord.address, ord.customer_phone FROM orders as ord INNER JOIN user as us
          ON ord.id_user=us.id_user WHERE ord.id_order=$id_dh
    ";
    $sql_ctdh = "SELECT pr.images,pr.name_product,pr.sale,ordt.amount FROM orderdetail as ordt INNER JOIN
                products as pr ON ordt.id_product=pr.id_product WHERE ordt.id_order=$id_dh
    ";
    $infor_product = pdo_query($sql_ctdh);
    $info_user = pdo_query($sql_dh);
} else {
    echo "Không tồn tại đơn hàng";
}
?>
<div class="col-md-9 bor" style="border: none;">
    <section class="box-main1">
        <div class="row">
            <h3 class="text-success">Bạn đã đặt hàng thành công &#x2713;</h3>
        </div>
        <div class="row large" style="box-shadow:0px 0px 2px black;padding:5px;">
            <div class="col">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-3">
                        <h4 style="text-align:center;">Thông tin đơn hàng</h4>
                    </div>
                </div>
                <div class="row" style="width:800px; background-color:blanchedalmond;margin-left:15px; font-size:20px;">
                    <div class="col-3">
                        <h4>Thông tin người nhận</h4>
                    </div>
                    <div class="col-9" style="margin-left:14px;">
                        <div class="row" style="font-size: 14px;">
                            Họ và tên: <?php echo $info_user[0]['customer_name'] ?>
                        </div>
                        <div class="row" style="font-size: 14px;">
                            Địa chỉ nhận hàng: <?php echo $info_user[0]['address'] ?>
                        </div>
                        <div class="row" style="font-size: 14px;">
                            Số điện thoại: <?php echo $info_user[0]['customer_phone'] ?>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin:20px;">
                    <div class="col-3">
                        <h4>Sản phẩm</h4>
                    </div>
                </div>
                <?php foreach ($infor_product as $values) { ?>
                    <div class="row">
                        <div class="col">
                            <div class="row" style="width: 450px; margin-left:20px;">
                                <table class="table table-bordered" style="height:40px;">
                                    <tr>
                                        <td style="width:40px;">
                                            <img src="<?php echo $values['images'] ?>" alt="" width="90">
                                        </td>
                                        <td>
                                            <p>Tên sách: <span style="color: red;"><?php echo $values['name_product'] ?></span></p>
                                            <p>Giá bán: <?php echo $values['sale'] ?> đ</p>
                                            <p>
                                                Số lượng: <span style="margin:10px;"><?php echo $values['amount'] ?></span>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php $tong += $values['amount'] * $values['sale'] ?>
                    </div>
                <?php } ?>
                <div class="col font-italic" style="font-size: 19px;">Tổng số tiền cần thanh toán: <span style="color: green; font-size:20px;"><?php echo number_format($tong) . " đ"; ?></span></div>
            </div>
        </div>
        <div class="row" style="margin-left:16px;margin-top:10px;">
            <a href="?page="><button type="button" class="btn btn-outline-danger">Quay lại trang chủ</button></a>
        </div>
    </section>

</div>