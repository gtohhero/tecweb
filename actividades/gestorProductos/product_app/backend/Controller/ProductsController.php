<?php
    namespace TECWEB\MYAPI\Controller;

    use TECWEB\MYAPI\Model\ProductsModel;
    use TECWEB\MYAPI\View\ProductsView;

    require_once __DIR__ . '/../Model/ProductsModel.php';
    require_once __DIR__ . '/../View/ProductsView.php';

    class ProductsController {
        private $model;
        private $view;

        private $data;

        public function __construct($db, $user='root', $pass='daSH1NE_Zz!') {
            $this->model = new ProductsModel($db, $user, $pass);
            $this->view = new ProductsView();
        }

        public function agregar($valor) {
            $this->model->add($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->imprimirValidacion($mostrar);
        }

        public function eliminar($valor) {
            $this->model->delete($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->imprimirValidacion($mostrar);
        }

        public function editar($valor) {
            $this->model->edit($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->imprimirValidacion($mostrar);
        }

        public function listar() {
            $this->model->list();
            $mostrar = $this->model->getData();
            $this->data = $this->view->mostrarProductos($mostrar);
        }

        public function buscar($valor) {
            $this->model->search($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->mostrarProductos($mostrar);
        }

        public function porId($valor) {
            $this->model->single($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->porBusqueda($mostrar);
        }

        public function porNombre($valor) {
            $this->model->singleByName($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->porBusqueda($mostrar);
        }

        public function validarNombre($valor) {
            $this->model->validateName($valor);
            $mostrar = $this->model->getData();
            $this->data = $this->view->imprimirValidacion($mostrar);
        }

        public function getData() {
            return json_encode($this->data);
        }
    }
?>