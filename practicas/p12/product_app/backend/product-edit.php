<?php
    //use TECWEB\MYAPI\UPDATE;
    require_once __DIR__.'/myapi/Update/Update.php';

    $productos = new Update('bookstore');
    $productos->edit( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>