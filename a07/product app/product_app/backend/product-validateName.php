<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__.'/myapi/Products.php';
    
    $prodObj = new Products('marketzone');
    $prodObj->validateName($_POST['name']);
    
    echo $prodObj->getData();
 ?>