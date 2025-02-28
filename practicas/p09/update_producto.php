<?php
    /* MySQL Conexion*/
    $link = mysqli_connect("localhost", "root", "daSH1NE_Zz!", "bookstore");
    
    // Chequea coneccion
    if($link === false){
        die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
    }

    // Obtén los datos enviados desde el formulario
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $details = $_POST['details'];
    $img = $_POST['img'];
    $id = $_POST['id'];

    // Consulta SQL para actualizar el producto en la base de datos
    $sql = "UPDATE productos SET 
                nombre = '$name', 
                marca = '$brand', 
                modelo = '$model', 
                precio = $price, 
                detalles = '$details',
                unidades = $quantity, 
                imagen = '$img' 
            WHERE id = {$id}";

    // Ejecutar la consulta
    if(mysqli_query($link, $sql)){
        echo "Registro actualizado.";
    } else {
        echo "ERROR: No se ejecuto $sql. " . mysqli_error($link);
    }
    
    // Cierra la conexion
    mysqli_close($link);
?>
