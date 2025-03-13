<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        '12345678a',
        'bookstore'
    );

    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>