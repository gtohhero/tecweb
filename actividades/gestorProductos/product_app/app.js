$(document).ready(function () {
    let edit = false;
    let nombreRepetido = true;
    let mensajesErrores = [];

    function reiniciarValores() {
        $('#name').val('');
        $('#price').val('0.0');
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
            dataType: 'json',
            success: function (response) {
                console.log(response.mensaje)
                $('#products').html(response.contenido);
            }
        });
    }

    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + $('#search').val(),
                data: { search },
                dataType: 'json',
                type: 'GET',
                success: function (response) {
                    console.log(response.mensaje)
                    $('#product-result').show();
                    $('#container').html(response.estado);
                    $('#products').html(response.contenido);
                }
            });
        }
        else {
            $('#product-result').hide();
            listarProductos();
        }
    });

    $('#name').keyup(function () {
        let name = $('#name').val().trim();
        $.ajax({
            url: './backend/product-validateName.php',
            dataType: 'json',
            type: 'POST',
            data: { name },
            success: function (response) {
                if (response.status === "success") { 
                    nombreRepetido = false;
                }
                else {
                    nombreRepetido = true;
                }

                $('#product-result').show();
                $('#container').html(response.contenido);

                console.log(response.message)
            }
        });
    });

    function validarNombre() {
        let valor = $('#name').val().trim();
        let mensaje = '';
        if (valor === "" || nombreRepetido || valor.length > 100) {
            mensaje='Nombre del producto no es válido, supera el límite de caracteres o ya está en uso.';
            mostrarError(mensaje);
            mensajesErrores.push(mensaje);
        }
        else {
            $('#product-result').hide();
        }
    }
    $('#name').blur(validarNombre);

    function validarPrecio() {
        let valor = $('#price').val();
        let mensaje = '';
        if (!valor || isNaN(valor) || !/^\d+(\.\d{1,2})?$/.test(valor) || parseFloat(valor) <= 99.99) {
            mensaje='Precio es vacío, no supera los 99.99 en valor o tiene más de dos decimales.';
            mostrarError(mensaje);
            mensajesErrores.push(mensaje);
        }
        else {
            mostrarExito(valor+'] cumple con el precio');
        }
    }
    $('#price').blur(validarPrecio);

    function validarCantidad() {
        let valor = $('#quantity').val();
        let mensaje = '';
        if (!valor || isNaN(valor) || Number(valor) < 0) {
            mensaje='Cantidad es vacía o es menor a 0.';
            mostrarError(mensaje);
            mensajesErrores.push(mensaje);
        }
        else {
            mostrarExito(valor+'] cumple con la cantidad');
        }
    }
    $('#quantity').blur(validarCantidad);

    function validarModelo() {
        let valor = $('#model').val().trim();
        let mensaje = '';
        if (valor === "XX-000" || valor.length > 25 || !/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ-]+$/.test(valor)) {
            mensaje='Modelo supera el límite de caracteres, es vacío o no es un texto alfanumérico.';
            mostrarError(mensaje);
            mensajesErrores.push(mensaje);
        }
        else {
            mostrarExito(valor+'] cumple con el modelo');
        }
    }
    $('#model').blur(validarModelo);

    function validarMarca() {
        let valor = $('#brand option:selected').text();
        let mensaje = '';
        if (valor === "NA") {
            mensaje='Marca no fue seleccionada.';
            mostrarError(mensaje);
            mensajesErrores.push(mensaje);
        }
        else {
            mostrarExito(valor+'] cumple con la marca');
        }
    }
    $('#brand').blur(validarMarca);

    function validarDetalles() {
        let valor = $('#description').val().trim();
        let mensaje = '';
        if (valor.length > 250) {
            mensaje='Los detalles superan el límite permitido de caracteres.';
            mostrarError(mensaje);
            mensajesErrores.push(mensaje);
        }
        else {
            mostrarExito(valor+'] cumple con la descripción');
        }
    }
    $('#description').blur(validarDetalles);

    function validarImagen() {
        let valor = $('#image').val().trim();
        if (valor === "") {
            $('#image').val("img/default.png");
        }
        mostrarExito(valor+'] cumple con la imagen');
    }
    $('#image').blur(validarImagen);

    function mostrarError(mensaje) { // Estas son las validaciones. Forman parte del cliente.
        let template_bar = '';
        template_bar += `
                <li style="list-style: none;">
                    <span style="color: #B1A293; font-weight: bold;">Error:</span> ${mensaje}
                </li>
            `;
        $('#product-result').show();
        $('#container').html(template_bar);
    }

    function mostrarExito(mensaje) {
        let template_bar = '';
        template_bar += `
                <li style="list-style: none;">
                    El valor insertado [${mensaje}
                </li>
            `;
        $('#product-result').show();
        $('#container').html(template_bar);
    }

    $('#product-form').submit(e => {
        e.preventDefault();

        mensajesErrores = [];

        validarNombre();
        validarPrecio();
        validarCantidad();
        validarModelo();
        validarMarca();
        validarDetalles();

        if (mensajesErrores.length > 0) {
            let template_bar = '';
            for (let i = 0; i < mensajesErrores.length; i++) {
                template_bar += `
                    <li style="list-style: none;">
                        <span style="color: #B1A293; font-weight: bold;">Error:</span> ${mensajesErrores[i]}
                    </li>
                    `;
            }
            $('#product-result').show();
            $('#container').html(template_bar);
            return;
        }

        const postData = {
            nombre: $('#name').val().trim(),
            id: $('#productId').val(),
            precio: $('#price').val(),
            unidades: $('#quantity').val(),
            modelo: $('#model').val().trim(),
            marca: $('#brand option:selected').text(),
            detalles: $('#description').val().trim(),
            imagen: $('#image').val().trim()
        };

        $('button.btn-primary').text("Agregar Producto");
        nombreRepetido = true;
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

        $.post(url, postData, (response) => {
            reiniciarValores();
            $('#product-result').show();
            $('#container').html(response.contenido);
            listarProductos();
            edit = false;
            console.log(response.message)
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', { id }, (response) => {
                $('#product-result').addClass("card my-4 d-block");
                $('#container').html(response.contenido);
                listarProductos();
                console.log(response.message)
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', { id }, (response) => {
            $('#name').val(response.nombre);
            $('#price').val(response.precio);
            $('#quantity').val(response.unidades);
            $('#model').val(response.modelo);

            let marca = response.marca;
            if (marca == 'Pluma Eterna')
                marca = 'plumaEterna';
            else if (marca == 'Luz y Tinta')
                marca = 'luzTinta';
            else if (marca == 'Vortice Literario')
                marca = 'vorticeLiterario';
            else if (marca == 'Alas de Papel')
                marca = 'alasPapel';
            else
                marca = 'sombrasDestello';

            $('#brand').val(marca);
            $('#description').val(response.detalles);
            $('#image').val(response.imagen);
            $('#productId').val(response.id);
            edit = true;
        });
        e.preventDefault();
        $('button.btn-primary').text("Modificar Producto");
    });
});