<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__.'/myapi/Products.php';
    
    $prodObj = new Products('bookstore');
    $prodObj->list();

    echo $prodObj->getData();
?>