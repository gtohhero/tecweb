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
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

$(function () {
    console.log('JQuery is working :>');
    $('#product-result').hide();
    listarProductos();

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
                                    <td class="productId">${producto.id}</td>
                                    <td>${producto.nombre}</td>
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

                if (Object.keys(productos).length > 0) {
                    // SE HACE VISIBLE LA BARRA DE ESTADO
                    $('#product-result').addClass("card my-4 d-block");
                    // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                    $('#container').html(template_bar);
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }
    
    // FUNCIÓN CALLBACK DE BOTÓN "Buscar"
    $('#search').keyup(function() {
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
                        console.log(producto);

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
                                        <td>${producto.nombre}</td>
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

                    if (Object.keys(productos).length > 0) {
                        // SE HACE VISIBLE LA BARRA DE ESTADO
                        $('#product-result').addClass("card my-4 d-block");
                        // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                        $('#container').html(template_bar);
                        // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                        $('#products').html(template);
                    }
                }
            });
        }
        else {
            console.log('No hay resultados sin búsqueda.');
        }
    })

    // FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
    $('#product-form').submit(function(e) {
        e.preventDefault();
        const postData = { //este objeto solo recolecta la información del html. 
            name: $('#name').val(),
            description: $('#description').val() //un string JSON contenido en un objeto que debe luego convertirse en un objeto
        };

        var finalJSON = JSON.parse(postData.description); //finalJSON guarda la transformación de string JSON a objeto de description

        finalJSON['nombre'] = postData.name; //se le agrega el valor de nombre de postData a finalJSON con el índice nombre

        /* ESPECIALMENTE EN ESTE PUNTO PORQUE UNA VEZ CONVERTIDO EN STRING JSON NO ES POSIBLE ACCEDER A LOS VALORES COMO EN UN OBJETO
        * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
        * ...
        * 
        * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
        */
        
        var postDataJSON = JSON.stringify(finalJSON, null, 2); //finalmente se convierte nuevamente en un string JSON para ser enviado al servidor

        $.post('./backend/product-add.php', postDataJSON, function(response){
            listarProductos();
            $('#product-form').trigger('reset');
            init();
            console.log(response);
        })
    })

    // FUNCIÓN CALLBACK DE BOTÓN "Eliminar"
    $(document).on('click', '.product-delete', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        console.log(id);
        
        $.get('./backend/product-delete.php', {id}, function(response) {
            console.log(response);
            listarProductos();
        })
    })
});