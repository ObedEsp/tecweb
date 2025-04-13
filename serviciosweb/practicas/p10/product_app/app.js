// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL TÉRMINO DE BÚSQUEDA (PUEDE SER ID, MARCA, NOMBRE O DETALLES)
    var busqueda = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);
            
            // SE VERIFICA SI HAY PRODUCTOS ENCONTRADOS
            if (productos.length > 0) {
                let template = '';
                
                productos.forEach(producto => {
                    let descripcion = `
                        <li>Precio: ${producto.precio}</li>
                        <li>Unidades: ${producto.unidades}</li>
                        <li>Modelo: ${producto.modelo}</li>
                        <li>Marca: ${producto.marca}</li>
                        <li>Detalles: ${producto.detalles}</li>
                    `;

                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.marca}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                // SE INSERTAN LOS PRODUCTOS EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = '<tr><td colspan="4">No se encontraron productos.</td></tr>';
            }
        }
    };
    client.send("busqueda=" + encodeURIComponent(busqueda));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    try {
        // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
        var productoJsonString = document.getElementById('description').value;
        var finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = document.getElementById('name').value;

        // VALIDACIONES
        if (!finalJSON.nombre.trim()) {
            throw new Error("El nombre del producto no puede estar vacío.");
        }
        if (isNaN(finalJSON.precio) || finalJSON.precio < 99) {
            throw new Error("El precio debe ser un número mayor o igual a 99.");
        }
        if (!finalJSON.marca.trim()) {
            throw new Error("La marca del producto no puede estar vacía.");
        }
        if (!finalJSON.detalles.trim()) {
            throw new Error("Los detalles del producto no pueden estar vacíos.");
        }
        if (!Number.isInteger(finalJSON.unidades) || finalJSON.unidades < 1) {
            throw new Error("Las unidades deben ser un número entero positivo.");
        }
        if (!finalJSON.imagen.trim()) {
            finalJSON.imagen = "img/default.png"; // Asignar imagen por defecto
        }

        // SE OBTIENE EL STRING DEL JSON FINAL
        productoJsonString = JSON.stringify(finalJSON, null, 2);

        // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
        var client = getXMLHttpRequest();
        client.open('POST', './backend/create.php', true);
        client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
        client.onreadystatechange = function () {
            if (client.readyState == 4 && client.status == 200) {
                // SE VERIFICA LA RESPUESTA DEL SERVIDOR
                var response = JSON.parse(client.responseText);
                
                // Si la respuesta contiene éxito, mostrar mensaje de éxito
                if (response.success) {
                    window.alert(response.success);
                } else if (response.error) {
                    // Si hay un error, mostrar el mensaje de error
                    window.alert(response.error);
                }
            }
        };
        client.send(productoJsonString);
    } catch (error) {
        alert("Error: " + error.message);
    }
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
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
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}
