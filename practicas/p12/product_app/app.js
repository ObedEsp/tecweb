// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

  $(document).ready(function() {
    let edit = false;

    const JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/myapi/Read/Read.php?action=list',
            type: 'GET',
            success: function(response) {
                console.log(response);
                const productos = JSON.parse(response);
                if (productos.length > 0) {
                    let template = '';
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += `<li>precio: ${producto.precio}</li>`;
                        descripcion += `<li>unidades: ${producto.unidades}</li>`;
                        descripcion += `<li>modelo: ${producto.modelo}</li>`;
                        descripcion += `<li>marca: ${producto.marca}</li>`;
                        descripcion += `<li>detalles: ${producto.detalles}</li>`;
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/myapi/Read/Read.php?action=search&query=' + search,
                type: 'GET',
                success: function(response) {
                    const productos = JSON.parse(response);
                    let template = '';
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += `<li>precio: ${producto.precio}</li>`;
                        descripcion += `<li>unidades: ${producto.unidades}</li>`;
                        descripcion += `<li>modelo: ${producto.modelo}</li>`;
                        descripcion += `<li>marca: ${producto.marca}</li>`;
                        descripcion += `<li>detalles: ${producto.detalles}</li>`;
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            });
        } else {
            listarProductos();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        let postData = JSON.parse( $('#description').val() );
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        /**
         * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
         * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
         **/

        const url = edit === false ? './backend/myapi/Create/Create.php' : './backend/myapi/Update/Update.php';
        
        $.post(url, postData, (response) => {
            console.log(response);
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let respuesta = JSON.parse(response);
            // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
            // SE REINICIA EL FORMULARIO
            $('#name').val('');
            $('#description').val(JsonString);
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').show();
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
            // SE REGRESA LA BANDERA DE EDICIÓN A false
            edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/myapi/Delete/Delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });
//search
$(document).on('click', '.product-item', function(e) {
    const id = $(this).closest('tr').attr('productId');
    $.ajax({
        url: './backend/myapi/Read/Read.php?action=single',
        type: 'POST',
        data: {id},
        success: function(response) {
            const product = JSON.parse(response);
            $('#name').val(product.nombre);
            $('#productId').val(product.id);
            delete(product.nombre);
            delete(product.eliminado);
            delete(product.id);
            let JsonString = JSON.stringify(product, null, 2);
            $('#description').val(JsonString);
            edit = true;
        }
    });
    e.preventDefault();
});
});