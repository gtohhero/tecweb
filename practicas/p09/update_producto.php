<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Productos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                echo "Registro actualizado.<br>";
            } else {
                echo "ERROR: No se ejecuto $sql. " . mysqli_error($link);
            }
            
            // Cierra la conexion
            mysqli_close($link);
        ?>
    </head>
    <body>
        <p>[<a href="get_productos_xhtml_v2.php">Regresar a get_productos_xhtml</a>] - [<a href="get_productos_vigentes_v2.php">Regresar a get_productos_vigentes</a>]</p>
    </body>
</html>    
