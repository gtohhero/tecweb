<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'daSH1NE_Zz!',
        'bookstore'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>