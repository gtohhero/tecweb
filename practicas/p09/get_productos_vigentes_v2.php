<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
        @$link = new mysqli('localhost', 'root', 'daSH1NE_Zz!', 'bookstore');

        if ($link->connect_errno) {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
        }

        if ($result = $link->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $productos = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        }

        $link->close();
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Productos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
        <script>
            function show() {
            var rowId = event.target.parentNode.parentNode.id;
            var data = document.getElementById(rowId).querySelectorAll(".row-data");

            var name = data[0].innerHTML;
            var brand = data[1].innerHTML;
            var model = data[2].innerHTML;
            var price = data[3].innerHTML;
            var quantity = data[4].innerHTML;
            var details = data[5].innerHTML;
            var image = data[6].firstChild.getAttribute('src');

            alert("Nombre: " + name + "\nMarca: " + brand + "\nModelo: " + model + "\nPrecio: " + price + "\nCantidad: " + quantity + "\nDetalles: " + details + "\nRuta de imagen: " + image);
            send2form(name, brand, model, price, quantity, details, image, rowId);
        }
        </script>
    </head>
    <body>
        <h3>PRODUCTOS</h3>
        <br/>
        <?php if (!empty($productos)) : ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Submit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                        <tr id="<?= $producto['id']?>">
                        <th scope="row"><?= $producto['id'] ?></th>
                            <td class="row-data"><?= $producto['nombre']?></td>
                            <td class="row-data"><?= $producto['marca']?></td>
                            <td class="row-data"><?= $producto['modelo']?></td>
                            <td class="row-data"><?= $producto['precio']?></td>
                            <td class="row-data"><?= $producto['unidades']?></td>
                            <td class="row-data"><?= $producto['detalles']?></td>
                            <td class="row-data"><img src="<?=$producto['imagen']?>"/></td>
                            <td><input type="button" value="submit" onclick="show()"/></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <script>
                alert('No hay productos con unidades <?= $tope ?>');
            </script>
        <?php endif; ?>
    
        <script>
            function send2form(name, brand, model, price, quantity, details, image, id) {
                var form = document.createElement("form");

                var nombreIn = document.createElement("input");
                nombreIn.type = 'hidden';
                nombreIn.name = 'nombre';
                nombreIn.value = name;
                form.appendChild(nombreIn);
                
                /*var marcaSe = document.createElement("select");
                marcaSe.name = 'marca';
                var option = document.createElement("option");
                option.value = brand;
                option.text = brand;
                marcaSe.appendChild(option);*/

                var modeloIn = document.createElement("input");
                modeloIn.type = 'hidden';
                modeloIn.name = 'modelo';
                modeloIn.value = model;
                form.appendChild(modeloIn);

                var priceIn = document.createElement("input");
                priceIn.type = 'hidden';
                priceIn.name = 'precio';
                priceIn.value = price;
                form.appendChild(priceIn);

                var cantidadIn = document.createElement("input");
                cantidadIn.type = 'hidden';
                cantidadIn.name = 'unidades';
                cantidadIn.value = quantity;
                form.appendChild(cantidadIn);

                var detallesTA = document.createElement("textarea");
                detallesTA.name = 'detalles';
                detallesTA.value = details;
                detallesTA.hidden = true;
                form.appendChild(detallesTA);

                var imageIn = document.createElement("input");
                imageIn.type = 'hidden';
                imageIn.name = 'imagen';
                imageIn.value = image;
                form.appendChild(imageIn);

                var idIn = document.createElement("input");
                idIn.type = 'hidden';
                idIn.name = 'id';
                idIn.value = id;
                form.appendChild(idIn);

                console.log(form);

                form.method = 'POST';
                form.action = 'formulario_productos_v2.php';  

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    </body>
</html>
