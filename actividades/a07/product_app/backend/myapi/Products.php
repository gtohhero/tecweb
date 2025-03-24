<?php
    namespace TECWEB\MYAPI;
    
    use TECWEB\MYAPI\DataBase as DataBase;
    require_once __DIR__.'/DataBase.php';

    class Products extends DataBase {
        private $data = NULL;

        public function __construct($db, $user='root', $pass='12345678a') {
            $this->data = array();
            parent::__construct($db, $user, $pass);
        }
        public function add($Object) {

        }

        public function delete($id) {
            $this->data = array(
                'status'  => 'error',
                'message' => 'La consulta falló'
            );
            if( isset($id) ) {
                $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
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

        }

        public function list() {
            if ( $result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
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
                $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
                if ( $result = $this->conexion->query($sql) ) {
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) { //Aquí puede mejorar.
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
                if ( $result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id} AND eliminado = 0") ) {
                    $row = $result->fetch_assoc();
        
                    if(!is_null($row)) { //Aquí puede mejorar.
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
                $sql = "SELECT * FROM productos WHERE (nombre LIKE '%{$nombre}%' AND eliminado = 0)";
                if ( $result = $this->conexion->query($sql) ) {
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) { //Aquí puede mejorar.
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
    }
?>