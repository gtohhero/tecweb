<?php
    namespace TECWEB\Controllers;
    use TECWEB\MYAPI\ProductsModel as Products;

    require_once __DIR__ . '/../myapi/Products.php';

    class ProductsController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new ProductModel($db, $user, $pass); //
            $this->view = new ProductView();
        }
    }
?>