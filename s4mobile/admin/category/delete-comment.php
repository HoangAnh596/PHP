<?php
    $sql="DELETE FROM comments WHERE id_cmt={$_GET['id']}";
    pdo_execute($sql,'');
    echo "xóa thành công";
    header("Location:?page=comments");
?>