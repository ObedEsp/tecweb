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

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

$(document).ready(function () {
    listarProductos();

    // Cargar productos al abrir la página
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            method: 'GET',
            dataType: 'json',
            success: function (productos) {
                let template = '';
                productos.forEach(producto => {
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>`;

                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>`;
                });
                $('#products').html(template);
            }
        });
    }

    // Buscar productos en tiempo real
    $('#search').on('keyup', function () {
        let search = $(this).val();
        $.ajax({
            url: './backend/product-search.php',
            method: 'GET',
            data: { search },
            dataType: 'json',
            success: function (productos) {
                let template = '', template_bar = '';
                productos.forEach(producto => {
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>
                              <ul>
                                <li>Precio: ${producto.precio}</li>
                                <li>Unidades: ${producto.unidades}</li>
                                <li>Modelo: ${producto.modelo}</li>
                                <li>Marca: ${producto.marca}</li>
                                <li>Detalles: ${producto.detalles}</li>
                              </ul>
                            </td>
                            <td><button class="product-delete btn btn-danger">Eliminar</button></td>
                        </tr>`;
                    template_bar += `<li>${producto.nombre}</li>`;
                });
                $('#products').html(template);
                $('#container').html(template_bar);
                $('#product-result').addClass('d-block');
            }
        });
    });

    // Agregar producto
    $('#product-form').submit(function (e) {
        e.preventDefault();
        let productoJsonString = $('#description').val();
        let finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = $('#name').val();
        let data = JSON.stringify(finalJSON);

        $.ajax({
            url: './backend/product-add.php',
            method: 'POST',
            contentType: 'application/json',
            data: data,
            dataType: 'json',
            success: function (respuesta) {
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>`;
                $('#container').html(template_bar);
                $('#product-result').addClass('d-block');
                listarProductos();
            }
        });
    });

    // Eliminar producto
    $(document).on('click', '.product-delete', function () {
        if (confirm("¿De verdad deseas eliminar el producto?")) {
            let id = $(this).closest('tr').attr('productId');
            $.ajax({
                url: './backend/product-delete.php',
                method: 'GET',
                data: { id },
                dataType: 'json',
                success: function (respuesta) {
                    let template_bar = `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>`;
                    $('#container').html(template_bar);
                    $('#product-result').addClass('d-block');
                    listarProductos();
                }
            });
        }
    });
});
