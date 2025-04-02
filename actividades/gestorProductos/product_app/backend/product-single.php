<?php
    //use TECWEB\ProductsController as Controllers;
    require_once __DIR__.'/Controller/ProductsController.php';
    
    header('Content-Type: application/json');

    $controller = new ProductsController('bookstore');
    $controller->porId($_POST['id']);
    $vista = $controller->getData();
 
    echo $vista;
?>