<?php
    $sql="SELECT id_slide,name_slide,image,link FROM slides";
    $list_slide=pdo_query($sql);
?>
<div class="card-body">
    <h5 class="card-title m-b-0">Slide</h5>
</div>
<div>
    <a href="?page=slide&action=add"><button type="button" class="btn btn-outline-success" style="width:120px; height:40px; margin-left:10px;margin-bottom:10px;">Thêm slide</button></a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên slide</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Link của ảnh</th>
            <th scope="col">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($list_slide as $row){
        ?>
            <tr>
                <td><?php echo $row['id_slide']?></td>
                <td><?php echo $row['name_slide']?></td>
                <td><img src="<?php echo $row['image']?>" alt="" width="150"></td>
                <td><?php echo $row['link']?></td>
                <td>
                    <a href="?page=slide&action=delete&id=<?php echo $row['id_slide']?>"><button class="btn btn-danger" type="button" onclick="return confirm('Bạn có thực sự muốn xóa không?')">Xóa</button></a>
                    <a href="?page=slide&action=update&id=<?php echo $row['id_slide']?>"><button class="btn btn-warning" type="button">Sửa</button></a>
                </td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>