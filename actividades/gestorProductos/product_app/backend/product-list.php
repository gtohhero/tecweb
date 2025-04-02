<?php
    use TECWEB\MYAPI\Controller\ProductsController;
    require_once __DIR__.'/Controller/ProductsController.php';
    
    header('Content-Type: application/json');

    $controller = new ProductsController('bookstore');
    $controller->listar();
    $vista = $controller->getData();
 
    echo $vista;
?>