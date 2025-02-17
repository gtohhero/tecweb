<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>PRODUCTO</h3>
    <br/>

    <?php
        if(isset($_GET['tope']))
        {
            $tope = $_GET['tope'];
        }
        else
        {
            die('Parámetro "tope" no detectado...');
        }

        /** SE CREA EL OBJETO DE CONEXION */
        $link = new mysqli('localhost', 'root', 'daSH1NE_Zz!', 'marketzone');

        if ($link->connect_errno) {
            die('<script>alert("Falló la conexión: ' . $link->connect_error . '");</script>');
        }

        $stmt = $link->prepare("SELECT * FROM productos WHERE unidades <= ?");
        $stmt->bind_param("i", $tope);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Unidades</th>
                            <th scope="col">Detalles</th>
                            <th scope="col">Imagen</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <th scope="row">' . htmlspecialchars($row['id']) . '</th>
                        <td>' . htmlspecialchars($row['nombre']) . '</td>
                        <td>' . htmlspecialchars($row['marca']) . '</td>
                        <td>' . htmlspecialchars($row['modelo']) . '</td>
                        <td>' . htmlspecialchars($row['precio']) . '</td>
                        <td>' . htmlspecialchars($row['unidades']) . '</td>
                        <td>' . htmlspecialchars($row['detalles']) . '</td>
                        <td><img src="'. htmlspecialchars($row['imagen']) .'" width="100"></td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<script>alert("No hay productos con stock menor o igual a '. $tope .'");</script>';
        }

        $stmt->close();
        $link->close();
    ?>
</body>
</html>
