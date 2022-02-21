<?php
    $id=$_GET['id'];
    $sql="DELETE FROM slides WHERE id_slide=$id";
    pdo_execute($sql,'');
    header("Location:?page=slide");
?>