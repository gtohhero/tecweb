<?php
    include_once __DIR__.'/database.php'; 

    $data = array(
        'status'  => 'error',
        'message' => 'Producto no agregado'
    );
    if(isset($_POST['nombre'])) {
        $jsonOBJ = json_decode( json_encode($_POST) );
        
        $conexion->set_charset("utf8");
        $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
        if($conexion->query($sql)){
            $data['status'] =  "success";
            $data['message'] =  "Producto agregado";
        } else {
            $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
        }

        $conexion->close();
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
?>
