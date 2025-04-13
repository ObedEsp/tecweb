<?php
include_once __DIR__.'/database.php';

// Establecer cabecera JSON
header('Content-Type: application/json');

// Leer datos enviados por el cliente
$producto = file_get_contents('php://input');
$data = array('status' => 'error', 'message' => 'No se pudo actualizar el producto');

if (!empty($producto)) {
    $jsonOBJ = json_decode($producto);

    if ($jsonOBJ === null) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'JSON inválido'], JSON_PRETTY_PRINT);
        exit;
    }

    // Actualizar producto en la base de datos
    $sql = "UPDATE productos SET 
                nombre = '{$jsonOBJ->nombre}',
                marca = '{$jsonOBJ->marca}',
                modelo = '{$jsonOBJ->modelo}',
                precio = {$jsonOBJ->precio},
                detalles = '{$jsonOBJ->detalles}',
                unidades = {$jsonOBJ->unidades},
                imagen = '{$jsonOBJ->imagen}'
            WHERE id = {$jsonOBJ->id}";

    if ($conexion->query($sql)) {
        $data['status'] = "success";
        $data['message'] = "Producto actualizado correctamente";
    } else {
        http_response_code(500);
        $data['message'] = "Error al actualizar: " . $conexion->error;
    }

    $conexion->close();
}

// Devolver JSON con resultado
echo json_encode($data, JSON_PRETTY_PRINT);
?>
