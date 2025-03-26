<?php
   namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Verificar si se recibió el parámetro de búsqueda
if (isset($_GET['search'])) {
    $products = new Products();
    $products->search($_GET['search']);
    echo $products->getData();
} else {
    echo json_encode([], JSON_PRETTY_PRINT);
}
?>