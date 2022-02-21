<?php
    $sql="DELETE FROM orders WHERE id_order={$_GET['id']}";
    pdo_execute($sql,'');
    header("Location:?page=order");
?>