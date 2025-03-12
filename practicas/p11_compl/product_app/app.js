$(document).ready(function () {
    let edit = false;
    let nombreRepetido = true;

    function reiniciarValores() { // Más adelante será muy necesario reiniciar los campos.
        $('#name').val('');
        $('#price').val('0.0'); // Este valor numérico pero lo dejó en un string por mera estética, al final, las verificaciones se encargan de no aceptar un valor así.
        $('#quantity').val(0);
        $('#model').val('XX-000');
        $('#description').val('NA');
        $('#image').val('img/default.png');
        $('#brand').val('NA');
    }

    $('#product-result').hide();
    reiniciarValores();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function (response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);

                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if (Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + $('#search').val(),
                data: { search },
                type: 'GET',
                success: function (response) {
                    if (!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);

                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if (Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: ' + producto.precio + '</li>';
                                descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                                descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                                descripcion += '<li>marca: ' + producto.marca + '</li>';
                                descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#name').keyup(function () {
        if ($('#name').val().trim() !== '') {
            let name = $('#name').val();
            $.ajax({
                url: './backend/product-validateName.php',
                type: 'POST',
                data: { name },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    let template_bar = '';
                    if(respuesta.status === "success") {
                        nombreRepetido=false;
                    }
                    else {
                        nombreRepetido=true;
                    }

                    template_bar += `
                                <li style="list-style: none;">status: ${respuesta.status}</li>
                                <li style="list-style: none;">message: ${respuesta.message}</li>
                            `;

                    $('#product-result').show();
                    $('#container').html(template_bar);
                }
            });
        }
        else {
            $('#product-result').hide();
            nombreRepetido=true;
        }
    });

    $('#product-form').submit(e => { // esto es equivalente al form.addEventListener("submit", function(event) {...} de la práctica 9
        e.preventDefault();

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        //        let postData = JSON.parse( $('#description').val() ); No hay más JSON, por ende, esta línea queda inválida.
        const postData = { // Aún es necesario un objeto que contenga la información del formulario. :<
            nombre: $('#name').val().trim(),
            id: $('#productId').val(),
            precio: $('#price').val(),
            unidades: $('#quantity').val(),
            modelo: $('#model').val().trim(),
            marca: $('#brand option:selected').text(),
            detalles: $('#description').val().trim(),
            imagen: $('#image').val().trim()
        };

        /**
         * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL OBJETO
         * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
         **/
        let hayErrores = false;
        let mensajesErrores = [];

        if (postData.nombre === "" || postData.nombre.length > 100) {
            mensajesErrores.push("Nombre supera el límite de caracteres o es vacío.");
            hayErrores = true;
        }

        if (!postData.precio || isNaN(postData.precio) || !/^\d+(\.\d{1,2})?$/.test(postData.precio) || parseFloat(postData.precio) <= 99.99) {
            mensajesErrores.push("Precio es vacío, no supera los 99.99 en valor o tiene más de dos decimales");
            hayErrores = true;
        }


        if (!postData.unidades || isNaN(postData.unidades) || Number(postData.unidades) < 0) {
            mensajesErrores.push("Cantidad es vacía o es menor a 0");
            hayErrores = true;
        }

        if (postData.modelo === "XX-000" || postData.modelo.length > 25 || !/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ-]+$/.test(postData.modelo)) {
            mensajesErrores.push("Modelo supera el límite de caracteres, es vacío o no es un texto alfanumérico.");
            hayErrores = true;
        }

        if (postData.marca === "NA") {
            mensajesErrores.push("Marca no fue seleccionada.");
            hayErrores = true;
        }

        if (postData.detalles !== "NA" && postData.detalles !== "") {
            if (postData.detalles.length > 250) {
                mensajesErrores.push("Los detalles superan el límite permitido de caracteres.");
                hayErrores = true;
            }
        }
        else {
            postData.detalles = "";
        }

        if (postData.imagen === "") {
            postData.imagen = "img/default.png";
        }

        if (hayErrores) {
            let template_bar = '';
            for (let i = 0; i < mensajesErrores.length; i++) {
                template_bar += `
                <li style="list-style: none;">
                    <span style="color: #B1A293; font-weight: bold;">Error:</span> ${mensajesErrores[i]}
                </li>
                `;
            }
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').show();
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            return;
        }
        /**/

        if(nombreRepetido===false) {
            $('button.btn-primary').text("Agregar Producto");
            nombreRepetido=true;
            const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

            $.post(url, postData, (response) => {
                //console.log(response);
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                let respuesta = JSON.parse(response);
                // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
                let template_bar = '';
                template_bar += `
                            <li style="list-style: none;">status: ${respuesta.status}</li>
                            <li style="list-style: none;">message: ${respuesta.message}</li>
                        `;
                // SE REINICIA EL FORMULARIO
                reiniciarValores();
                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').show();
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
                // SE REGRESA LA BANDERA DE EDICIÓN A false
                edit = false;
            });
        }
        else {
            $('#product-result').show();
            $('#container').html('<li style="list-style: none;">El nombre del producto ya está en uso. Por favor, elige otro nombre.</li>');
            listarProductos();
            return;
        }
    });

    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', { id }, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', { id }, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response); // Esta es la única línea en donde sí usamos el JSON (obtenido del backend) porque es como lo envía el .php y de este se extraen los datos.
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            $('#price').val(product.precio);
            $('#quantity').val(product.unidades);
            $('#model').val(product.modelo);

            let marca = product.marca; // el valor de marca es el nombre de la marca, pero no coincide con los values que hay en el formulario, es por ello que se le asigna dependiendo del nombre de marca.
            if (marca == 'Pluma Eterna')
                marca = 'plumaEterna';
            else if (marca == 'Luz y Tinta')
                marca = 'luzTinta';
            else if (marca == 'Vortice Literario') // Ã³ = ó. Esto podría ser una futura actualización debido a los caracteres como acentos y la ñ que no se imprimen en el resultado final.
                marca = 'vorticeLiterario';
            else if (marca == 'Alas de Papel')
                marca = 'alasPapel';
            else
                marca = 'sombrasDestello';

            $('#brand').val(marca);
            $('#description').val(product.detalles);
            $('#image').val(product.imagen);
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id);
            // SE ELIMINA nombre, eliminado E id PARA PODER MOSTRAR EL JSON EN EL <textarea>
            //            delete(product.nombre); No hacen faltan más estas 3 líneas porque no se imprimirá después un JSON, sino que se agregan los valores a los campos en el formulario.
            //            delete(product.eliminado);
            //            delete(product.id);
            // SE CONVIERTE EL OBJETO JSON EN STRING
            //            let JsonString = JSON.stringify(product,null,2); No más JSON. Grrr
            // SE MUESTRA STRING EN EL <textarea>
            //            $('#description').val(JsonString); No JSON.

            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
        });
        e.preventDefault();
        $('button.btn-primary').text("Modificar Producto");
    });
});