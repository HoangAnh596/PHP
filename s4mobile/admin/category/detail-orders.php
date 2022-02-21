<?php
    $sql="SELECT pr.name_product, pr.sale,odt.amount FROM orderdetail as odt INNER JOIN products as 
    pr ON odt.id_product=pr.id_product WHERE id_order={$_GET['id']}";
    $list_detail_orders=pdo_query($sql);
    $total_price=0;
?>
<div class="card-body">
    <h5 class="card-title m-b-0">Đơn hàng</h5>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_detail_orders as $row){?>
            <tr>
                <td><?php echo $row['name_product']?></td>
                <td><?php echo $row['amount']?></td>
                <?php $total_price+=$row['sale']*$row['amount']?>
            </tr>
        <?php }?>
    </tbody>
</table>
<p style="color: red;">Tổng tiền đơn hàng: <?php echo number_format($total_price)." vnd";?></p>
<a href="?page=order" style="margin-left:10px;margin-top:5px;margin-bottom:20px;"><button type="btn" class="btn btn-success btn-sm" style=" width:100px;height:40px;">Quay lại</button></a>