<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

$response = ['status' => 'error', 'message' => 'No se recibieron datos del producto'];

// Manejar la solicitud POST sin try-catch
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = !empty($_POST) ? $_POST : (json_decode(file_get_contents('php://input'), true) ?? []);
    
    if (!empty($inputData)) {
        $products = new Products();
        
        // Verificar si ya existe
        $products->singleByName($inputData['nombre'] ?? '');
        $existing = json_decode($products->getData(), true);
        
        if (empty($existing)) {
            $productData = [
                'name' => $inputData['nombre'] ?? '',
                'brand' => $inputData['marca'] ?? '',
                'model' => $inputData['modelo'] ?? '',
                'price' => $inputData['precio'] ?? 0,
                'details' => $inputData['detalles'] ?? '',
                'units' => $inputData['unidades'] ?? 0,
                'image' => $inputData['imagen'] ?? ''
            ];
            
            $products->add($productData);
            $response = json_decode($products->getData(), true);
        } else {
            $response['message'] = 'Ya existe un producto con ese nombre';
        }
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>