<?php
include_once __DIR__.'/database.php';

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];

    // Consulta para verificar si el nombre del producto ya existe
    $query = "SELECT COUNT(*) as count FROM productos WHERE nombre = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verificar si el nombre del producto ya existe
    if ($row['count'] > 0) {
        echo json_encode(['existe' => true]);
    } else {
        echo json_encode(['existe' => false]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['error' => 'No se proporcionó el nombre del producto.']);
}

?>