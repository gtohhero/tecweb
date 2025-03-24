<?php
    class Cuerpo {
        private $cuerpoTexto = [];
        private $i = 0;

        public function insertar_parrafo($text) {
            $this->cuerpoTexto[$this->i++] = $text;
        }

        public function graficar() {
            for($j = 0; $j < $this->i; $j++) {
                echo $this->cuerpoTexto[$j];
            }
        }
    }
?>