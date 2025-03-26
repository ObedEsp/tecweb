<?php
namespace MyAPI;
require_once __DIR__ . '/myapi/Products.php';

// Crear instancia de Products y obtener datos
$products = new Products();
$products->list();

// Devolver respuesta JSON
echo $products->getData();
?>