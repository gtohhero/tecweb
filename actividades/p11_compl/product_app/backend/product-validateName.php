<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(isset($_POST['name'])) {
        // SE TRANSFORMA EL POST A UN STRING EN JSON, Y LUEGO A OBJETO
        $name=$_POST['name'];
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '{$name}' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        // Es parecido al archivo de add, pero se excluye la adición.
        if ($result->num_rows == 0) {
            $data['status'] = "success";
            $data['message'] = "Producto disponible para agregar/modificar.";
        }

        $result->free();
        // Cierra la conexion
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>