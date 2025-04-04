<?php
    use Backend\MyApi\Delete\Delete as Delete;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new Delete('bookstore');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>