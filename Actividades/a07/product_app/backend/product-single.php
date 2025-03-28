<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Verificar si se recibió el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $products = new Products();
    $products->single($_POST['id']);
    echo $products->getData();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se proporcionó ID del producto'
    ], JSON_PRETTY_PRINT);
}
?>