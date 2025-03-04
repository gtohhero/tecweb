<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL PRODUCTO
    if( isset($_POST['producto']) ) {
        $producto = $_POST['producto'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '%{$producto}%' OR marca LIKE '%{$producto}%' OR detalles LIKE '%{$producto}%'") ) {
            // SE OBTIENEN LOS RESULTADOS MEDIANTE RECORRIDOS
			while ($row = $result->fetch_array()) {
               $data[] = $row;
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>