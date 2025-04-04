<?php
    use Backend\MyApi\Update\Update as Update;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new Update('bookstore');
    $productos->edit( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>