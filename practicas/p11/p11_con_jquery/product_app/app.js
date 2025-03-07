// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}

$(function () {
    console.log('JQuery is working :>');
    $('#product-result').hide();
    listarProductos();
    let edit = false;
    let ocultarCuadro = false;

    // FUNCIÓN CALLBACK AL CARGAR LA PÁGINA O AL AGREGAR UN PRODUCTO
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function (response) {
                let productos = JSON.parse(response);
                // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                let template_bar = '';
                productos.forEach(producto => {
                    // SE COMPRUEBA QUE SE OBTIENE UN OBJETO POR ITERACIÓN
                    //console.log(producto);

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
                                    <td>
                                        <a href="#" class="product-item">${producto.nombre}</a>
                                    </td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `; //sin onclick="eliminarProducto() porque estamos trabajando con JQuery

                    template_bar += `
                                <li>${producto.nombre}</li>
                            `;
                });

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                $('#products').html(template);

                if (ocultarCuadro == true) {
                    $('#product-result').removeClass("card my-4 d-block").addClass("card my-4 d-none");
                    ocultarCuadro = false;
                }
            }
        });
    }

    // FUNCIÓN CALLBACK DE BOTÓN "Buscar"
    $('#search').keyup(function () {
        let search = $('#search').val().trim(); //eliminar espacios o puede no mostrar todos los resultados de la búsqueda.
        if (search) {
            console.log(search);
            $.ajax({
                url: './backend/product-search.php',
                type: 'GET',
                data: { search },
                success: function (response) {
                    let productos = JSON.parse(response);
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';
                    let template_bar = '';
                    productos.forEach(producto => {
                        // SE COMPRUEBA QUE SE OBTIENE UN OBJETO POR ITERACIÓN
                        //console.log(producto);

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
                                        <td>
                                            <a href="#" class="product-item">${producto.nombre}</a>
                                        </td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `; //sin onclick="eliminarProducto() porque estamos trabajando con JQuery

                        template_bar += `
                                    <li>${producto.nombre}</li>
                                `;
                    });


                    // SE HACE VISIBLE LA BARRA DE ESTADO
                    $('#product-result').addClass("card my-4 d-block");
                    // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                    $('#container').html(template_bar);
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);

                }
            });
        }
        else {
            console.log('No hay resultados sin búsqueda.');
            ocultarCuadro = true;
            listarProductos();
        }
    })

    // FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
    $('#product-form').submit(function (e) {
        e.preventDefault();
        const postData = { //este objeto solo recolecta la información del html. 
            name: $('#name').val(),
            description: $('#description').val(), //un string JSON contenido en un objeto que debe luego convertirse en un objeto
            id: $('#productId').val()
        };

        var finalJSON = JSON.parse(postData.description); //finalJSON guarda la transformación de string JSON a objeto de description

        finalJSON['nombre'] = postData.name; //se le agrega el valor de nombre de postData a finalJSON con el índice nombre
        finalJSON['id'] = postData.id;

        /* ESPECIALMENTE EN ESTE PUNTO PORQUE UNA VEZ CONVERTIDO EN STRING JSON NO ES POSIBLE ACCEDER A LOS VALORES COMO EN UN OBJETO
        * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
        */
        let hayErrores = false;
        let mensajesErrores = []; // En este arreglo se guardan los mensajes de error que serán impresos al final de las verificaciones.

        if (finalJSON.nombre.trim() === "" || finalJSON.nombre.length > 100) {
            mensajesErrores.push("Nombre supera el límite de caracteres o es vacío.");
            hayErrores = true;
        }

        if (!finalJSON.precio || isNaN(finalJSON.precio) || !/^\d+(\.\d{1,2})?$/.test(finalJSON.precio) || parseFloat(finalJSON.precio) <= 99.99) {
            mensajesErrores.push("Precio es vacío, no supera los 99.99 en valor o tiene más de dos decimales");
            hayErrores = true;
        }

        if (!finalJSON.unidades || isNaN(finalJSON.unidades) || Number(finalJSON.unidades) < 0) {
            mensajesErrores.push("Cantidad es vacía o es menor a 0");
            hayErrores = true;
        }

        if (finalJSON.modelo.trim() === "XX-000" || finalJSON.modelo.length > 25 || !/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ-]+$/.test(finalJSON.modelo)) {
            mensajesErrores.push("Modelo supera el límite de caracteres, es vacío o no es un texto alfanumérico.");
            hayErrores = true;
        }

        if (finalJSON.marca.trim() === "" || finalJSON.marca.trim() === "NA") {
            mensajesErrores.push("Marca es vacía o no válida. Intenta poner algo para que el programa te lance las opciones permitidas");
            hayErrores = true;
        } else {
            let marcasValidas = [
                "Pluma Eterna",
                "Luz y Tinta",
                "Vórtice Literario",
                "Alas de Papel",
                "Sombras y Destello"
            ];

            if (!marcasValidas.includes(finalJSON.marca.trim())) {
                mensajesErrores.push("Marca no encontrada. Posibles marcas: a) Pluma Eterna, b) Luz y Tinta, c) Vórtice Literario, d) Alas de Papel y e) Sombras y Destello");
                hayErrores = true;
            }
        }

        if (finalJSON.detalles.trim() !== "NA" && finalJSON.detalles.trim() !== "") {
            if (finalJSON.detalles.length > 250) {
                mensajesErrores.push("Los detalles superan el límite permitido de caracteres.");
                hayErrores = true;
            }
        } else {
            finalJSON.detalles = "";
        }

        if (finalJSON.imagen.trim() === "") {
            finalJSON.imagen = "img/default.png";
        }

        if (hayErrores) {
            let template_bar = '';
            for (let i = 0; i < mensajesErrores.length; i++) {
                template_bar += `
                <li style="list-style: none;"><span style="color: #B1A293; font-weight: bold;">Error:</span> ${mensajesErrores[i]}</li>
                `;
            }
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').addClass("card my-4 d-block");
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            return;
        }
        /* 
        * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
        */

        listarProductos();

        var postDataJSON = JSON.stringify(finalJSON, null, 2); //finalmente se convierte nuevamente en un string JSON para ser enviado al servidor

        let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

        $.post(url, postDataJSON, function (response) {
            $('#product-form').trigger('reset');
            init();
            console.log(response);
            let respuesta = JSON.parse(response);
            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').addClass("card my-4 d-block");
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            listarProductos();
        })
    })


    // FUNCIÓN CALLBACK DE BOTÓN "Eliminar"
    $(document).on('click', '.product-delete', function () {
        if (confirm('¿Estás seguro de querer eliminar esto?')) {
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId');
            console.log(id);

            $.get('./backend/product-delete.php', { id }, function (response) {
                console.log(response);
                let respuesta = JSON.parse(response);
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').addClass("card my-4 d-block");
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                listarProductos();
            })
        }
    })

    // FUNCIÓN CALLBACK DE BOTÓN "Editar"
    $(document).on('click', '.product-item', function () {
        if (confirm('¿Estás seguro de querer editar esto?')) {
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId');

            $.post('./backend/product-single.php', { id }, function (response) {
                console.log(response);
                const product = JSON.parse(response);
                $('#name').val(product.name);
                $('#productId').val(product.id);

                const description = {
                    "precio": product.precio,
                    "unidades": product.unidades,
                    "modelo": product.modelo,
                    "marca": product.marca,
                    "detalles": product.detalles,
                    "imagen": product.imagen
                };

                $('#description').val(JSON.stringify(description, null, 2));
                edit = true;

                listarProductos();
            })
        }
    })
});