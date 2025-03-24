<?php
    class Pie {
        private $text2;

        public function __construct($text2) {
            $this->text2 = $text2;
        }

        public function graficar() {
            echo $this->text2;
        }
    }
?>