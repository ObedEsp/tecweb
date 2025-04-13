<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();

    // SE VERIFICA QUE SE RECIBIÓ UN TÉRMINO DE BÚSQUEDA
    if( isset($_POST['busqueda']) ) {
        $busqueda = $_POST['busqueda'];

        // SE REALIZA LA CONSULTA BUSCANDO POR ID, NOMBRE, MARCA O DETALLES
        if ($result = $conexion->query("SELECT * FROM productos WHERE 
        id LIKE '%{$busqueda}%' 
        OR nombre LIKE '%{$busqueda}%' 
        OR marca LIKE '%{$busqueda}%' 
        OR detalles LIKE '%{$busqueda}%'")) {
            // SE OBTIENEN TODOS LOS RESULTADOS
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row; // Se agregan todos los productos encontrados
            }
            if ($row) {
                // SE ASEGURA QUE EL ID SE INCLUYA
                $data['id'] = $row['id'];
    
                foreach ($row as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    } 

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
