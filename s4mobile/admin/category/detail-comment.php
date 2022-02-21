<?php
    $sql="SELECT cm.id_cmt,us.username,cm.content, cm.create_at 
    FROM comments as cm INNER JOIN user as us ON cm.id_user=us.id_user WHERE id_product={$_GET['id']}";
    $list_detail_comments=pdo_query($sql);
?>
<div class="card-body">
    <h5 class="card-title m-b-0">Bình luận</h5>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Tài khoản bình luận</th>
            <th scope="col">Nội dung bình luận</th>
            <th scope="col">Thời gian bình luận</th>
            <th scope="col">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($list_detail_comments as $row){
        ?>
            <tr>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['content']?></td>
                <td><?php echo $row['create_at']?></td>
                <td><a href="?page=detail-comments&action=delete&id=<?php echo $row['id_cmt']?>"><button type="button" class="btn btn-danger" onclick="return confirm('Bạn có thực sự muốn xóa không!')">Xóa</button></a></td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>
<a href="?page=comments" style="margin-left:10px;margin-top:5px;margin-bottom:20px;"><button type="btn" class="btn btn-success btn-sm" style=" width:100px;height:40px;">Quay lại</button></a>