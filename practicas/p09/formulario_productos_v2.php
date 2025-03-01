<?php
// Conexión a la base de datos
@$link = new mysqli('localhost', 'root', 'CondeGod16a', 'marketzone');

// Verificar conexión
if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error);
}

// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta SQL para obtener los datos del producto
$query = "SELECT * FROM productos WHERE id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Obtener los datos del producto
$producto = $result->fetch_assoc();

$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        ol, ul {
            list-style-type: none;
        }
    </style>
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    
    <form id="formProducto" action="update_producto.php" method="post">
        <fieldset>
            <legend>Actualiza los datos del producto:</legend>
            <ul>
                <li><label>Nombre:</label> <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required></li>
                <li><label>Marca:</label> <input type="text" name="marca" value="<?= htmlspecialchars($producto['marca']) ?>" required></li>
                <li><label>Modelo:</label> <input type="text" name="modelo" value="<?= htmlspecialchars($producto['modelo']) ?>" required></li>
                <li><label>Precio:</label> <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required></li>
                <li><label>Unidades:</label> <input type="number" name="unidades" value="<?= htmlspecialchars($producto['unidades']) ?>" required></li>
                <li><label>Detalles:</label> <textarea name="detalles" required><?= htmlspecialchars($producto['detalles']) ?></textarea></li>
                <li><label>Imagen URL:</label> <input type="text" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>"></li>
            </ul>
        </fieldset>
        <p>
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
            <input type="submit" value="Guardar Cambios">
        </p>
    </form>
</body>
</html>