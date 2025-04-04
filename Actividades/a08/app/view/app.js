// JSON BASE A MOSTRAR EN FORMULARIO
$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: '../public/index.php',
            type: 'GET',
            data: { action: 'list' },
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
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
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: '../public/index.php',
                data: { action: 'searchProduct', search: $('#search').val()},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
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

    let validacion = false; 
    //Validación de datos
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
            // Llamada Ajax para comprobar si el nombre existe en la base de datos
            $.ajax({
                url: '../public/index.php',
                type: 'GET',
                data: { 
                    action: 'dataProduct',
                    search: nameValue },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.length > 0) {
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
    
    

    $('#model').on('blur', function() {
        var modelValue = $(this).val();
        if (!modelValue) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "modelo" no debe estar vacío.</li>');
            validacion = false; 
        } else if (modelValue.length > 25) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "modelo" no debe superar los 25 caracteres.</li>');
            validacion = false; 
        } else {
            $('#container').html('');
            $('#product-result').hide();
            validacion = true; 
        }
    });

    $('#unit').on('blur', function() {
        var unitValue = $(this).val();
        if (!unitValue) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "unidades" no debe estar vacío, coloca un 0 si no hay disponibilidad.</li>');
            validacion = false; 
        } else {
            $('#container').html('');
            $('#product-result').hide();
            validacion = true; 
        }
    });

    $('#cost').on('blur', function() {
        var costValue = $(this).val();
        if (!costValue) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo "Precio" no debe estar vacío.</li>');
            validacion = false; 
        } else if (costValue < 100) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">Recuerda, el Precio debe ser mayor a 99.99.</li>');
           validacion = false; 
        } else {
            $('#container').html('');
            $('#product-result').hide();
            validacion = true; 
        }
    });

    $('#brand').on('blur', function() {
        var brandValue = $(this).val();
        if (!brandValue) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "Marca" no debe estar vacío.</li>');
            validacion = false
        } else if (brandValue.length > 25) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "Marca" no debe superar los 25 caracteres.</li>');
           validacion = false
        } else {
            $('#container').html('');
            $('#product-result').hide();
            validacion = true; 
        }
    });
    
    $('#image').on('blur', function() {
        var imageValue = $(this).val();
        if (!imageValue) {
            $(this).val('img/default.png');
        }
    });

    $('#description').on('blur', function() {
        var descripcionValue = $(this).val();
        if (!descripcionValue) {
            $(this).val('Descripción genérica');
        } else if (descripcionValue.length > 250) {
            $('#product-result').show();
            $('#container').html('<li style="color: white;">El campo de "Descripción" no debe superar los 250 caracteres.</li>');
            validacion = false; 
        } else {
            $('#container').html('');
            $('#product-result').hide();
            validacion = true;
        }
    });
    ////////////FIN DE LA VALIDACIÓN///////////////////

        $('#product-form').submit(e => {
            e.preventDefault();
            $('button.btn-primary.btn-block.text-center').text("Agregar Producto");
            let postData = {};
            if(validacion==false){
                alert('No se pudo enviar los datos, verifica que los campos sean llenados correctamente');
                return; 
            }

            // SE CONVIERTE EL JSON DE STRING A OBJETO
            postData['nombre'] = $('#name').val();
            postData['id'] = $('#productId').val();
            postData['precio'] = $('#cost').val(); 
            postData['unidades'] = $('#unit').val(); 
            postData['modelo'] = $('#model').val(); 
            postData['marca'] = $('#brand').val();
            postData['detalles'] = $('#description').val();  
            postData['imagen'] = $('#image').val(); 
            const url = '../public/index.php?action=' + (edit === false ? 'addProduct' : 'editProduct');
            
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
                $('#productId').val('');
                $('#cost').val(''); 
                $('#unit').val(''); 
                $('#model').val(''); 
                $('#brand').val('');
                $('#description').val('');  
                $('#image').val('');
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
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
    
            $.ajax({
                url: '../public/index.php',
                type: 'POST',
                data: { 
                    action: 'eliminar', 
                    id: id 
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    $('#product-result').hide(); 
                    listarProductos(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error); // Muestra el error en consola
                }
            });
        }
    });



    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $('button.btn-primary.btn-block.text-center').text("Modificar Producto");
        $.post('../public/index.php', {action:'singleProduct', id:id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            $('#cost').val(product.precio); 
            $('#unit').val(product.unidades); 
            $('#model').val(product.modelo); 
            $('#brand').val(product.marca);
            $('#description').val(product.detalles);  
            $('#image').val(product.imagen); 
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id); 
            
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
        });
        e.preventDefault();
    });    
});