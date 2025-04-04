<?php
    use Backend\MyApi\Create\Create as Create;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new Create('bookstore');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>