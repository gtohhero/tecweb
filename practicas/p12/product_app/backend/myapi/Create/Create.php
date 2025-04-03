<?php
    //namespace TECWEB\MYAPI\CREATE;
    //use TECWEB\MYAPI\DataBase as DataBase;
    require_once __DIR__.'/../DataBase.php';

    Class Create extends DataBase {
        public function __construct($db) {
            $this->data = array();
            parent::__construct($db, 'root', 'daSH1NE_Zz!');
        }

        public function add($Object) {
            $this->data = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            );
            if(isset($Object->nombre)) {
                $sql = "SELECT * FROM productos WHERE nombre = '{$Object->nombre}' AND eliminado = 0";
                $result = $this->conexion->query($sql);
                
                if ($result->num_rows == 0) {
                    $this->conexion->set_charset("utf8");
                    $sql = "INSERT INTO productos VALUES (null, '{$Object->nombre}', '{$Object->marca}', '{$Object->modelo}', {$Object->precio}, '{$Object->detalles}', {$Object->unidades}, '{$Object->imagen}', 0)";
                    if($this->conexion->query($sql)){
                        $this->data['status'] =  "success";
                        $this->data['message'] =  "Producto agregado";
                    } else {
                        $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                    }
                }

                $result->free();
                $this->conexion->close();
            }
        }
    }
?>