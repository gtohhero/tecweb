<?php
    //use TECWEB\MYAPI\READ;
    require_once __DIR__.'/myapi/Read/Read.php';

    $productos = new Read('bookstore');
    $productos->single( $_POST['id'] );
    echo $productos->getData();
?>