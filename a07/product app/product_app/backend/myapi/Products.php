<?php
    namespace TECWEB\MYAPI;
    
    use TECWEB\MYAPI\DataBase as DataBase;
    require_once __DIR__.'/DataBase.php';

    class Products extends DataBase {
        private $data = NULL;

        public function __construct($db, $user='root', $pass='daSH1NE_Zz!') {
            $this->data = array();
            parent::__construct($db, $user, $pass);
        }

        public function add($Object) {
            $this->data = array(
                'status'  => 'error',
                'message' => 'Producto no agregado'
            );
            if(isset($Object['nombre'])) {
                $jsonOBJ = json_decode( json_encode($Object) );
                
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos1 VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if($this->conexion->query($sql)){
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }

                $this->conexion->close();
            }
        }

        public function delete($id) {
            $this->data = array(
                'status'  => 'error',
                'message' => 'La consulta falló'
            );
            if( isset($id) ) {
                $sql = "UPDATE productos1 SET eliminado=1 WHERE id = {$id}";
                if ( $this->conexion->query($sql) ) {
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto eliminado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
                $this->conexion->close();
            }
        }

        public function edit($Object) {
            $this->data = array(
                'status'  => 'error',
                'message' => 'La consulta falló'
            );
            if( isset($Object['id']) ) {
                $jsonOBJ = json_decode( json_encode($Object) );
                $sql =  "UPDATE productos1 SET nombre='{$jsonOBJ->nombre}', marca='{$jsonOBJ->marca}',";
                $sql .= "modelo='{$jsonOBJ->modelo}', precio={$jsonOBJ->precio}, detalles='{$jsonOBJ->detalles}',"; 
                $sql .= "unidades={$jsonOBJ->unidades}, imagen='{$jsonOBJ->imagen}' WHERE id={$jsonOBJ->id}";
                $this->conexion->set_charset("utf8");
                if ( $this->conexion->query($sql) ) {
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto actualizado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
                $this->conexion->close();
            } 
        }

        public function list() {
            if ( $result = $this->conexion->query("SELECT * FROM productos1 WHERE eliminado = 0") ) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                if(!is_null($rows)) {
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }

        public function search($search) {
            if( isset($search) ) {
                $sql = "SELECT * FROM productos1 WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
                if ( $result = $this->conexion->query($sql) ) {
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) {
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this->data[$num][$key] = utf8_encode($value);
                            }
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this->conexion));
                }
                $this->conexion->close();
            }
        }

        public function single($id) {
            if( isset($id) ) {
                if ( $result = $this->conexion->query("SELECT * FROM productos1 WHERE id = {$id} AND eliminado = 0") ) {
                    $row = $result->fetch_assoc();
        
                    if(!is_null($row)) {
                        foreach($row as $key => $value) {
                            $this->data[$key] = utf8_encode($value);
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this->conexion));
                }
                $this->conexion->close();
            }
        }

        public function singleByName($nombre) {
            if( isset($nombre) ) {
                $sql = "SELECT * FROM productos1 WHERE (nombre LIKE '%{$nombre}%' AND eliminado = 0)";
                if ( $result = $this->conexion->query($sql) ) {
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) {
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this->data[$num][$key] = utf8_encode($value);
                            }
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this->conexion));
                }
                $this->conexion->close();
            }
        }

        public function getData() {
            return json_encode($this->data, JSON_PRETTY_PRINT);
        }

        public function validateName($nombre) {
            $this->data = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre o es vacío'
            );
            if(isset($nombre) && $nombre!="") {
                $nombre = $this->conexion->real_escape_string($nombre); 
                $sql = "SELECT * FROM productos1 WHERE nombre = '{$nombre}' AND eliminado = 0";
                $result = $this->conexion->query($sql);
                
                if ($result->num_rows == 0) {
                    $this->data['status'] = "success";
                    $this->data['message'] = "Producto disponible [".$nombre."] para agregar/modificar.";
                }
        
                $result->free();
                $this->conexion->close();
            }
        }
    }
?>