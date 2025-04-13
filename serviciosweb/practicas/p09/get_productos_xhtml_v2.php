<?php
header("Content-Type: application/xhtml+xml; charset=UTF-8");

// Obtener el parámetro "tope" desde la URL
$tope = isset($_GET['tope']) ? intval($_GET['tope']) : 0;

// Conexión a la base de datos
@$link = new mysqli('localhost', 'root', 'CondeGod16a', 'marketzone');

// Verificar conexión
if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error);
}

// Consulta SQL para obtener productos con unidades menores o iguales al tope
$query = "SELECT * FROM productos WHERE unidades <= ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $tope);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

$stmt->close();
$link->close();

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
</head>
<body>
    <h3 class="text-center">PRODUCTOS</h3>
    <br/>
    
    <?php if (!empty($productos)) : ?>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Detalles</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Modificar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $index => $producto): ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['marca']) ?></td>
                        <td><?= htmlspecialchars($producto['modelo']) ?></td>
                        <td>$<?= htmlspecialchars($producto['precio']) ?></td>
                        <td><?= htmlspecialchars($producto['unidades']) ?></td>
                        <td><?= htmlspecialchars($producto['detalles']) ?></td>
                        <td><img src="<?= htmlspecialchars($producto['imagen']) ?>" width="100" height="auto" alt="<?= htmlspecialchars($producto['nombre']) ?>" /></td>
                        <td>
                        <a href="formulario_productos_v2.php?id=<?= $producto['id'] ?>" class="btn btn-warning btn-sm">✏ Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <script>
            alert('No hay productos con unidades menores o iguales a <?= $tope ?>');
        </script>
    <?php endif; ?>
</body>
</html>
