<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Respuesta por defecto
$response = [
    'status' => 'error',
    'message' => 'Datos incompletos para actualización'
];

// Procesar solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos de entrada (compatible con POST tradicional y JSON)
    $inputData = !empty($_POST) ? $_POST : (json_decode(file_get_contents('php://input'), true) ?? []);
    
    // Verificar datos requeridos
    if (!empty($inputData['id'])) {
        $products = new Products();
        
        // Preparar datos del producto
        $productData = [
            'id' => $inputData['id'],
            'name' => $inputData['nombre'] ?? '',
            'brand' => $inputData['marca'] ?? '',
            'model' => $inputData['modelo'] ?? '',
            'price' => $inputData['precio'] ?? 0,
            'details' => $inputData['detalles'] ?? '',
            'units' => $inputData['unidades'] ?? 0,
            'image' => $inputData['imagen'] ?? ''
        ];
        
        // Llamar al método update
        $products->update($productData);
        $response = json_decode($products->getData(), true);
    }
}

// Devolver respuesta JSON
echo json_encode($response, JSON_PRETTY_PRINT);
?>