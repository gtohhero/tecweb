<?php
    class Cabecera {
        private $text1;

        public function __construct($text1) {
            $this->text1 = $text1;
        }

        public function graficar() {
            echo $this->text1;
        }
    }
?>