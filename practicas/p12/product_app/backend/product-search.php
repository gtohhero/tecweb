<?php
    use Backend\MyApi\Read\Read as Read;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new Read('bookstore');
    $productos->search( $_GET['search'] );
    echo $productos->getData();
?>