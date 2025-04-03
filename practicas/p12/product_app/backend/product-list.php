<?php
    //use TECWEB\MYAPI\READ\Read as Read;
    require_once __DIR__.'/myapi/Read/Read.php';

    $productos = new Read('bookstore');
    $productos->list();
    echo $productos->getData();
?>