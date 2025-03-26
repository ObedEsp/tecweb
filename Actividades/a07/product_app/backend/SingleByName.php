<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Verificar si se recibió el parámetro nombre
if (isset($_GET['name'])) {
    $products = new Products();
    $products->SingleByName($_GET['name']);
    echo $products->getData();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se proporcionó nombre del producto'
    ], JSON_PRETTY_PRINT);
}
?>