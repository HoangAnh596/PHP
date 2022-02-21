<?php
    $sql="SELECT * FROM information";
    $list_infor_web=pdo_query($sql);
?>
<div class="card-body">
    <h5 class="card-title m-b-0">Thông tin website</h5>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Tên website</th>
            <th scope="col">Logo</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($list_infor_web as $row){
        ?>
            <tr>
                <td><?php echo $row['name_website']?></td>
                <td><img src="<?php echo $row['logo']?>" alt="lỗi ảnh" width="150"></td>
                <td><?php echo $row['address']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['phone']?></td>
                <td><a href="?page=infor-web&action=update"><button type="button" class="btn btn-outline-warning">Sửa</button></a></td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>