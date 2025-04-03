<?php
    //use TECWEB\MYAPI\CREATE;
    require_once __DIR__.'/myapi/Create/Create.php';

    $productos = new Create('bookstore');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>