<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Respuesta por defecto
$response = [
    'status' => 'error',
    'message' => 'No se proporcionó ID del producto'
];

// Verificar si se recibió el ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $products = new Products();
    
    // Obtener datos del input (puede ser POST tradicional o JSON)
    $inputData = !empty($_POST) ? $_POST : (json_decode(file_get_contents('php://input'), true) ?? []);
    
    // Llamar al método delete (deberás implementarlo en Products.php)
    $products->delete($inputData['id']);
    $response = json_decode($products->getData(), true);
}

// Devolver respuesta JSON
echo json_encode($response, JSON_PRETTY_PRINT);
?>