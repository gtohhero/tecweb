<?php
    include_once __DIR__.'/database.php';
    // SE VERIFICA HABER RECIBIDO EL ID
    $id = $_POST['id'];
    $json = array();

    if( isset($_POST['id']) ) {
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "SELECT * FROM productos WHERE id = {$id}";
        $result= mysqli_query($conexion, $sql);
        if(!$result) {die('Query Failed');}
        while($row = mysqli_fetch_array($result)) {
            $json[] = array (
                'name' => $row['nombre'],
                'marca' => $row['marca'],
                'modelo' => $row['modelo'],
                'precio' => floatval($row['precio']),
                'detalles' => $row['detalles'],
                'unidades' => intval($row['unidades']),
                'imagen' => $row['imagen'],
                'id' => $id
            );
        }
    }
    echo json_encode($json[0]);
?>