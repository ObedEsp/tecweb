$(document).ready(function () {
    let edit = false;
    $('#product-result').hide();
    listarProductos();
    
    function validarNombreProducto() {
        const nombre = $('#name').val().trim();
        const nameInput = $('#name');
        const nameFeedback = $('#name-error');

        // Limpiar clases y mensajes antes de validar
        nameInput.removeClass('is-valid is-invalid');

        // Validación de campo vacío o excede 100 caracteres
        if (nombre === "" || nombre.length > 100) {
            nameInput.addClass('is-invalid');
            nameFeedback.text('El nombre es requerido y debe tener 100 caracteres o menos.');
            return; // Detenemos aquí para que no haga la consulta AJAX
        }

        // Si el campo es válido en cuanto a longitud, verificamos si el nombre ya existe
        $.ajax({
            url: './backend/product-check.php',
            type: 'GET',
            data: { nombre: nombre },
            success: function(response) {
                const resultado = JSON.parse(response);
                if (resultado.existe) {
                    nameInput.addClass('is-invalid');
                    nameFeedback.text('El nombre del producto ya existe.');
                } else {
                    nameInput.addClass('is-valid');
                }
            }
        });
    }

    // Función para actualizar la barra de progreso
    function actualizarProgreso() {
        let totalCampos = 6; // Número total de campos a validar
        let camposValidos = 0;

        if ($('#name').hasClass('is-valid')) camposValidos++;
        if ($('#marca').hasClass('is-valid')) camposValidos++;
        if ($('#modelo').hasClass('is-valid')) camposValidos++;
        if ($('#precio').hasClass('is-valid')) camposValidos++;
        if ($('#detalles').hasClass('is-valid')) camposValidos++;
        if ($('#unidades').hasClass('is-valid')) camposValidos++;

        let porcentaje = (camposValidos / totalCampos) * 100;
        $('#progress-bar').css('width', porcentaje + '%').text(Math.round(porcentaje) + '%');
    }

    // Validación del nombre
    function validarNombre() {
        const nombre = $('#name').val().trim();
        if (nombre === "" || nombre.length > 100) {
            $('#name').addClass('is-invalid').removeClass('is-valid');
            $('#name-error').text('El nombre es requerido y debe tener 100 caracteres o menos.');
            return false;
        } else {
            $('#name').addClass('is-valid').removeClass('is-invalid');
            return true;
        }
    }

    // Validación de la marca
    function validarMarca() {
        const marca = $('#marca').val();
        if (marca === "") {
            $('#marca').addClass('is-invalid').removeClass('is-valid');
            return false;
        } else {
            $('#marca').addClass('is-valid').removeClass('is-invalid');
            return true;
        }
    }

    // Validación del modelo
    function validarModelo() {
        const modelo = $('#modelo').val().trim();
        const alfanumerico = /^[a-zA-Z0-9]+$/;
        if (modelo === "" || modelo.length > 25 || !alfanumerico.test(modelo)) {
            $('#modelo').addClass('is-invalid').removeClass('is-valid');
            return false;
        } else {
            $('#modelo').addClass('is-valid').removeClass('is-invalid');
            return true;
        }
    }

    // Validación del precio
    function validarPrecio() {
        const precio = parseFloat($('#precio').val());
        if (isNaN(precio) || precio <= 99.99) {
            $('#precio').addClass('is-invalid').removeClass('is-valid');
            return false;
        } else {
            $('#precio').addClass('is-valid').removeClass('is-invalid');
            return true;
        }
    }

    // Validación de los detalles
    function validarDetalles() {
        const detalles = $('#detalles').val().trim();
        if (detalles.length > 250) {
            $('#detalles').addClass('is-invalid').removeClass('is-valid');
            return false;
        } else {
            $('#detalles').addClass('is-valid').removeClass('is-invalid');
            return true;
        }
    }

    // Validación de las unidades
    function validarUnidades() {
        const unidades = parseInt($('#unidades').val());
        if (isNaN(unidades) || unidades < 0) {
            $('#unidades').addClass('is-invalid').removeClass('is-valid');
            return false;
        } else {
            $('#unidades').addClass('is-valid').removeClass('is-invalid');
            return true;
        }
    }

    // Eventos de validación
    $('#name').on('blur', function () {
        validarNombreProducto();
        actualizarProgreso();
    });

    $('#marca').on('blur', function () {
        validarMarca();
        actualizarProgreso();
    });
    $('#modelo').on('blur', function () {
        validarModelo();
        actualizarProgreso();
    });
    $('#precio').on('blur', function () {
        validarPrecio();
        actualizarProgreso();
    });
    $('#detalles').on('blur', function () {
        validarDetalles();
        actualizarProgreso();
    });
    $('#unidades').on('blur', function () {
        validarUnidades();
        actualizarProgreso();
    });

    // Función para listar productos
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                const productos = JSON.parse(response);
            
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
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
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

    // Búsqueda de productos
    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        const productos = JSON.parse(response);
                        
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

    // Envío del formulario
    $('#product-form').submit(function (e) {
        e.preventDefault();
    
        const isNombreValido = validarNombre();
        const isMarcaValido = validarMarca();
        const isModeloValido = validarModelo();
        const isPrecioValido = validarPrecio();
        const isDetallesValido = validarDetalles();
        const isUnidadesValido = validarUnidades();
    
        if (isNombreValido && isMarcaValido && isModeloValido && isPrecioValido && isDetallesValido && isUnidadesValido) {
            let postData = {
                nombre: $('#name').val().trim(),
                marca: $('#marca').val(),
                modelo: $('#modelo').val().trim(),
                precio: parseFloat($('#precio').val()),
                detalles: $('#detalles').val().trim(),
                unidades: parseInt($('#unidades').val()),
                imagen: $('#imagen').val().trim(),
                id: $('#productId').val()
            };
    
            console.log("Datos a enviar:", postData);
    
            const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
    
            $.post(url, postData, function (response) {
                console.log("Respuesta del servidor:", response);
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#name').val('');
                $('#marca').val('');
                $('#modelo').val('');
                $('#precio').val('');
                $('#detalles').val('');
                $('#unidades').val('');
                $('#imagen').val('');
                $('#productId').val('');
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
                edit = false;
                $('button.btn-primary').text("Agregar Producto");
            });
        } else {
            alert("Por favor, corrige los errores en el formulario antes de enviar.");
        }
    });

    // Eliminar producto
    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    // Editar producto
    $(document).on('click', '.product-item', function (e) {
        e.preventDefault();
    
        const element = $(this).closest('tr');
        const id = $(element).attr('productId');
    
        $.post('./backend/product-single.php', { id }, function (response) {
            console.log("Respuesta del servidor (editar):", response);
            let product = JSON.parse(response);
    
            $('#name').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#detalles').val(product.detalles);
            $('#unidades').val(product.unidades);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
    
            $('button.btn-primary').text("Modificar Producto");
    
            edit = true;
        });
    });
});