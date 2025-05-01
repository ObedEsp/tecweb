$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: '/tecweb/Actividades/A09/backend/products',  
            type: 'GET',
            success: function(response) {
                const productos = response;
            
                if(Object.keys(productos).length > 0) {
                    let template = '';

                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
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
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/products/'+encodeURIComponent(search), // Cambiado a nuevo endpoint REST
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        const productos = response;
                        
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
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
                            $('#product-result').show();
                            $('#container').html(template_bar);
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

    let validacion = false; 
    $('#name').on('blur', function() {
        var nameValue = $(this).val();
        if (!nameValue) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "nombre" no debe estar vacío.</li>');
            validacion = false; 
        } else if (nameValue.length > 100) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "nombre" no debe superar los 100 caracteres.</li>');
            validacion = false;
        } else {
            $.ajax({
                url: './backend/products/'+encodeURIComponent(nameValue), 
                type: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        $('#product-result').show();
                        $('#container').html('<li style="color: white;">Ya existe un producto con ese nombre.</li>');
                        validacion = false;
                    } else {
                        $('#container').html('');
                        $('#product-result').hide();
                        validacion = true;
                    }
                }
            });
        }
    });
    
    $('#product-form').submit(e => {
        e.preventDefault();
        $('button.btn-primary.btn-block.text-center').text("Agregar Producto");
        let postData = {};
        if(validacion==false){
            alert('No se pudo enviar los datos, verifica que los campos sean llenados correctamente');
            return; 
        }

        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();
        postData['precio'] = $('#cost').val(); 
        postData['unidades'] = $('#unit').val(); 
        postData['modelo'] = $('#model').val(); 
        postData['marca'] = $('#brand').val();
        postData['detalles'] = $('#description').val();  
        postData['imagen'] = $('#image').val(); 

        if (edit === false) {
            $.ajax({
                url: './backend/product',
                type: 'POST',
                data: postData,
                success: function(response) {
                    handleFormResponse(response);
                }
            });
        } else {
            $.ajax({
                url: './backend/product',
                type: 'PUT',
                data: postData,
                success: function(response) {
                    handleFormResponse(response);
                }
            });
        }
    });

    function handleFormResponse(response) {
        let template_bar = '';
        template_bar += `
                    <li style="list-style: none;">status: ${response.status}</li>
                    <li style="list-style: none;">message: ${response.message}</li>
                `;
        $('#name').val('');
        $('#productId').val('');
        $('#cost').val(''); 
        $('#unit').val(''); 
        $('#model').val(''); 
        $('#brand').val('');
        $('#description').val('');  
        $('#image').val('');
        $('#product-result').show();
        $('#container').html(template_bar);
        listarProductos();
        edit = false;
    }

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.ajax({
                url: './backend/product',
                type: 'DELETE',
                data: {id},
                success: function(response) {
                    $('#product-result').hide();
                    listarProductos();
                }
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $('button.btn-primary.btn-block.text-center').text("Modificar Producto");
        $.ajax({
            url: './backend/product/'+id,
            type: 'GET',
            success: function(response) {
                let product = response;
                $('#name').val(product.nombre);
                $('#cost').val(product.precio); 
                $('#unit').val(product.unidades); 
                $('#model').val(product.modelo); 
                $('#brand').val(product.marca);
                $('#description').val(product.detalles);  
                $('#image').val(product.imagen); 
                $('#productId').val(product.id); 
                edit = true;
            }
        });
        e.preventDefault();
    });    
});