<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Respuesta por defecto
$response = ['error' => 'No se proporcionó el nombre del producto'];

// Verificar si se recibió el parámetro nombre
if (isset($_GET['nombre'])) {
    $products = new Products();
    $products->singleByName($_GET['nombre']);
    $result = json_decode($products->getData(), true);
    
    $response = ['existe' => !empty($result)];
}

// Devolver respuesta JSON
echo json_encode($response, JSON_PRETTY_PRINT);

?>