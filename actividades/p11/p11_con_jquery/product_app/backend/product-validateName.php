<?php
    include_once __DIR__.'/database.php';

    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(isset($_POST['name'])) {
        $name=$_POST['name'];
        $sql = "SELECT * FROM productos WHERE nombre = '{$name}' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $data['status'] = "success";
            $data['message'] = "Producto disponible para agregar/modificar.";
        }

        $result->free();
        $conexion->close();
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
?>