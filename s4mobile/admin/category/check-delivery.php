<?php
    $sql="UPDATE orders SET ck_delivery=1 WHERE id_order={$_GET['id']}";
    pdo_execute($sql,'');
    header("Location:?page=order");
?>