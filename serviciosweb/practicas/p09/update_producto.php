<?php
// Conexión a la base de datos
@$link = new mysqli('localhost', 'root', 'CondeGod16a', 'marketzone');

// Verificar conexión
if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error);
}

// Obtener los datos del formulario
$id = intval($_POST['id']);
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = floatval($_POST['precio']);
$unidades = intval($_POST['unidades']);
$detalles = $_POST['detalles'];
$imagen = $_POST['imagen'];

// Consulta SQL para actualizar el producto
$query = "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, unidades = ?, detalles = ?, imagen = ? WHERE id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("sssdissi", $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen, $id);
$stmt->execute();

// Verificar si la actualización fue exitosa
if ($stmt->affected_rows > 0) {
    echo "Producto actualizado correctamente.";
} else {
    echo "No se pudo actualizar el producto.";
}

$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Producto</title>
</head>
<body>
    <br><br>
    <a href="get_productos_xhtml_v2.php">Ver todos los productos</a> | 
    <a href="get_productos_vigentes_v2.php">Ver productos vigentes</a>
</body>
</html>