<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Registro en la Base de Datos Completado</title>
		<style type="text/css">
			body {margin: 20px; 
			background-color: #C4DF9B;
			font-family: Verdana, Helvetica, sans-serif;
			font-size: 90%;}
			h1 {color: #005825;
			border-bottom: 1px solid #005825;}
		</style>
	</head>
	<body>
		<h1>Aquí se muestran los datos agregados para la inserción del producto (en caso de éxito): </h1>

        <?php
        $nombre = $_POST['name'];
        $marca  = $_POST['brand'];
        $modelo = $_POST['model'];
        $precio = $_POST['price'];
        $detalles = $_POST['details'];
        $unidades = $_POST['quantity'];
        $imagen = $_POST['img'];

        if (empty($imagen)) {
            $imagen = 'img/imagen.png';
        }
        else {
            $imagen = "img/".$_POST['img'].".png";
        }

        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', 'daSH1NE_Zz!', 'marketzone');	

        /** comprobar la conexión */
        if ($link->connect_errno) 
        {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
            /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
        }

        /* Aquí se le asigna a variables la búsqueda de datos repetidos. */

        $nomRep = $link->prepare("SELECT * FROM productos WHERE nombre='{$nombre}'");
        $marRep = $link->prepare("SELECT * FROM productos WHERE marca='{$marca}'");
        $modRep = $link->prepare("SELECT * FROM productos WHERE modelo='{$modelo}'");
        
        // Aquí es necesario el uso de 3 variables más para el guardado de los resultados, debido a un error de sincronización.
        $nomRep->execute(); $nomResultado=$nomRep->get_result(); 
        $marRep->execute(); $marcaResultado=$marRep->get_result();
        $modRep->execute(); $modeloResultado=$modRep->get_result();

        // Si encontró anteriormente repetidos, pasa por este if. :<
        if($nomResultado->num_rows == 0 && $marcaResultado->num_rows == 0 && $modeloResultado->num_rows == 0) {
            /** Crear una tabla que no devuelve un conjunto de resultados */
            //$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, 'img/{$imagen}.png', 0)";
            
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen)
                    VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";

            if ( $link->query($sql) ) 
            {
                echo 'Producto insertado con ID: '.$link->insert_id;
                echo    '<ul>
                            <li><strong>Nombre:</strong> <em>'. $_POST['name'] .'. </em></li>
                            <li><strong>Marca:</strong> <em>'. $_POST['brand'] .'</em></li>
                            <li><strong>Modelo:</strong> <em>'. $_POST['model'] .'</em></li>
                            <li><strong>Precio:</strong> <em>'. $_POST['price'] .'</em></li>
                            <li><strong>Detalles:</strong> <em>'. $_POST['details'] .'</em></li>
                            <li><strong>Unidades:</strong> <em>'. $_POST['quantity'] .'</em></li>
                        </ul>';
            }
            else
            {
                echo 'El Producto no pudo ser insertado =(';
            }
        }
        else
        {
            if($nomResultado->num_rows != 0) {
                echo 'Nombre repetido: <em>' . $nombre . '</em> existe en la base de datos. <br>';
            }
            if($marcaResultado->num_rows != 0) {
                echo 'Marca repetida: <em>' . $marca . '</em> existe en la base de datos. <br>';
            }
            if($modeloResultado->num_rows != 0) {
                echo 'Modelo repetido: <em>' . $modelo . '</em> existe en la base de datos. <br>';
            }
        }
        $link->close();
        ?>
    </body>
</html>