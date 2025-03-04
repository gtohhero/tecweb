// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

function buscarProducto(e) {
    e.preventDefault();
    
    var producto = document.getElementById('search').value.trim();

    if(producto !== '') {
        var client = getXMLHttpRequest();
        client.open('POST', './backend/read.php', true);
        client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        client.onreadystatechange = function () {
            if (client.readyState == 4 && client.status == 200) {
                console.log('[CLIENTE]\n'+client.responseText);
                
                let productos = JSON.parse(client.responseText);
            
                if (Object.keys(productos).length > 0) {
                    let template = '';
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                        
                        template += `
                            <tr>
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td><ul>${descripcion}</ul></td>
                            </tr>
                        `;
                    });

                    document.getElementById("productos").innerHTML = template;
                }
            }
            else {
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos</td></tr>';
            }
        };
        client.send("producto=" + producto);
    }
    else {
        document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos</td></tr>';
    }
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;

    // AQUÍ SE HACEN LAS VERIFICACIONES
    let hayErrores = false;
    let mensajesErrores = []; // En este arreglo se guardan los mensajes de error que serán impresos al final de las verificaciones.

    if (finalJSON.nombre.trim() === "" || finalJSON.nombre.length > 100) {
        mensajesErrores.push("Error: Nombre supera el límite de caracteres o es vacío.");
        hayErrores = true;
    }

    if (!finalJSON.precio || isNaN(finalJSON.precio) || parseFloat(finalJSON.precio) <= 99.99) {
        mensajesErrores.push("Error: Precio es vacío o no supera los 99.99 en valor");
        hayErrores = true;
    }

    if (!finalJSON.unidades || isNaN(finalJSON.unidades) || Number(finalJSON.unidades) < 0) {
        mensajesErrores.push("Error: Cantidad es vacía o es menor a 0");
        hayErrores = true;
    }

    if (finalJSON.modelo.trim() === "XX-000" || finalJSON.modelo.length > 25 || !/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ-]+$/.test(finalJSON.modelo)) {
        mensajesErrores.push("Error: Modelo supera el límite de caracteres, es vacío o no es un texto alfanumérico.");
        hayErrores = true;
    }

    if (finalJSON.marca.trim() === "" || finalJSON.marca.trim() === "NA") {
        mensajesErrores.push("Error: Marca es vacía o no válida.");
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
            mensajesErrores.push("Error: Marca no encontrada. Posibles marcas: a) Pluma Eterna, b) Luz y Tinta, c) Vórtice Literario, d) Alas de Papel y e) Sombras y Destello");
            hayErrores = true;
        }
    }

    if (finalJSON.detalles.trim() !== "NA" && finalJSON.detalles.trim() !== "") {
        if (finalJSON.detalles.length > 250) {
            mensajesErrores.push("Error: Los detalles superan el límite permitido de caracteres.");
            hayErrores = true;
        }
    } else {
        finalJSON.detalles = "";
    }

    if (finalJSON.imagen.trim() === "") {
        finalJSON.imagen = "img/default.png";
    }

    if (hayErrores) {
        document.getElementById("errores").innerHTML = "";
        
        // Se va moviendo en el arreglo, evitando hacerlo manualmente
        mensajesErrores.forEach(mensaje => {
            let divError = document.createElement("div");
            divError.textContent = mensaje;
            document.getElementById("errores").appendChild(divError); // se inserta divError en la etiqueta div con id = errores en el HTML.
        });
        return;
    }

    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}