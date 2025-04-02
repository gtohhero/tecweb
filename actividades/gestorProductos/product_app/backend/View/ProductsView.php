<?php
    //namespace TECWEB\View;

    class ProductsView {
        private $consola;
        public function mostrarProductos($jsonProductos) {
            $productos = json_decode($jsonProductos);

            if (count($productos) > 0) {
                $template = '';
                $template_bar = '';
    
                foreach ($productos as $producto) {
                    $descripcion = '';
                    $descripcion .= '<li>Precio: ' . htmlspecialchars($producto->precio) . '</li>';
                    $descripcion .= '<li>Unidades: ' . htmlspecialchars($producto->unidades) . '</li>';
                    $descripcion .= '<li>Modelo: ' . htmlspecialchars($producto->modelo) . '</li>';
                    $descripcion .= '<li>Marca: ' . htmlspecialchars($producto->marca) . '</li>';
                    $descripcion .= '<li>Detalles: ' . htmlspecialchars($producto->detalles) . '</li>';
    
                    $template .= '
                        <tr productId="' . htmlspecialchars($producto->id) . '">
                            <td>' . htmlspecialchars($producto->id) . '</td>
                            <td><a href="#" class="product-item">' . htmlspecialchars($producto->nombre) . '</a></td>
                            <td><ul>' . $descripcion . '</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    ';

                    $template_bar .= '
                        <li>'.htmlspecialchars($producto->nombre).'</il>
                    ';
                }
                $this->consola = 'Éxito en el proceso';
            }
            else {
                $template .= '<tr><td colspan="4">No hay productos disponibles</td></tr>'; 
                $this->consola = 'Error en el proceso';
            }

            return ['contenido' => $template, 'mensaje' => $this->consola, 'estado' => $template_bar];
        }

        public function imprimirValidacion($jsonProductos) {
            $respuesta = json_decode($jsonProductos, true);
            $template_bar = "
                <li style='list-style: none;'>status: " . htmlspecialchars($respuesta['status']) . "</li>
                <li style='list-style: none;'>message: " . htmlspecialchars($respuesta['message']) . "</li>
            ";
            $respuesta['contenido'] = $template_bar;

            return $respuesta;
        }

        public function porBusqueda($jsonProductos) {
            $respuesta = json_decode($jsonProductos);
            return $respuesta;
        }
    }
?>