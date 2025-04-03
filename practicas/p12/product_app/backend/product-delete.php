<?php
    //use TECWEB\MYAPI\DELETE;
    require_once __DIR__.'/myapi/Delete/Delete.php';

    $productos = new Delete('bookstore');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>