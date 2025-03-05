<?php
    include_once __DIR__.'/database.php';
    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        $nombre = trim($jsonOBJ->nombre);
        $precio = floatval($jsonOBJ->precio);
        $marca = trim($jsonOBJ->marca);
        $modelo = trim($jsonOBJ->modelo);
        $detalles = trim($jsonOBJ->detalles);
        $unidades = intval($jsonOBJ->unidades);
        $imagen = trim($jsonOBJ->imagen);
        
        // CONEXIÓN A LA BD (utilizando la conexión incluida en database.php)
        if ($conexion->connect_error) {
            die(json_encode(["error" => "Conexión fallida: " . $conexion->connect_error]));
        }
        // VERIFICAR SI EL PRODUCTO YA EXISTE Y NO ESTÁ ELIMINADO
        $query = "SELECT COUNT(*) AS total FROM productos WHERE eliminado = 0 AND ((nombre = ? AND marca = ?) OR (marca = ? AND modelo = ?))";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssss", $nombre, $marca, $marca, $modelo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row["total"] > 0) {
            echo json_encode(["error" => "El producto ya existe en la base de datos."]);
        } else {
            // INSERTAR EL NUEVO PRODUCTO
            $query = "INSERT INTO productos (nombre, precio, marca, modelo, detalles, unidades, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("sdsssds", $nombre, $precio, $marca, $modelo, $detalles, $unidades, $imagen);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => "Producto agregado correctamente."]);
            } else {
                echo json_encode(["error" => "Error al insertar el producto: " . $stmt->error]);
            }
        }
    }
?>
