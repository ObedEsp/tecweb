<?php
namespace MyAPI;
require_once __DIR__ . "/DataBase.php";

class Products extends DataBase {
    private $data = [];

    public function __construct() {
        parent::__construct(); // Llamar al constructor de DataBase
    }

    //Funcion add
    public function add($product): void {
        $stmt = $this->conexion->prepare("INSERT INTO productos 
            (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
        
        // Asignar valores por defecto si no existen
        $brand = $product['brand'] ?? '';
        $model = $product['model'] ?? '';
        $details = $product['details'] ?? '';
        $image = $product['image'] ?? '';
        
        $stmt->bind_param("sssdiss", $product['name'], $brand, $model, $product['price'],
            $details, $product['units'], $image );
    
        // Ejecutar y manejar resultados
        if ($stmt->execute()) {
            $this->data = [
                'status' => 'success',
                'message' => 'Producto agregado',
                'inserted_id' => $stmt->insert_id  // Opcional: devolver el ID generado
            ];
        } else {
            $this->data = [
                'status' => 'error',
                'message' => 'Error al agregar producto: ' . $stmt->error
            ];
        }
    
        $stmt->close();
    }



    //Funcion list
    public function list() {
        $query = "SELECT * FROM productos WHERE eliminado = 0";
        if ($result = $this->conexion->query($query)) {
            $this->data = $result->fetch_all(MYSQLI_ASSOC) ?: [];
            $result->free();
        }
    }
    
    //Funcion delete
    public function delete($id) {
        $stmt = $this->conexion->prepare("UPDATE productos SET eliminado = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $this->data = [
                'status' => 'success',
                'message' => 'Producto eliminado',
                'affected_rows' => $stmt->affected_rows
            ];
        } else {
            $this->data = [
                'status' => 'error',
                'message' => 'Error al eliminar producto: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }

    //Funcion edit
    public function update($productData) {
        $stmt = $this->conexion->prepare( "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, 
            detalles = ?, unidades = ?, imagen = ? WHERE id = ?");
        
        $stmt->bind_param("sssdsisi", $productData['name'], $productData['brand'], $productData['model'],
            $productData['price'], $productData['details'], $productData['units'], $productData['image'], $productData['id'] );
    
        if ($stmt->execute()) {
            $this->data = [
                'status' => 'success',
                'message' => 'Producto actualizado',
                'affected_rows' => $stmt->affected_rows
            ];
        } else {
            $this->data = [
                'status' => 'error',
                'message' => 'Error al actualizar producto: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }

    //funcion search
    public function search($searchTerm) {
        $searchTerm = "%{$this->conexion->real_escape_string($searchTerm)}%";
        
        $query = "SELECT * FROM productos WHERE (id = ? OR nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) 
                  AND eliminado = 0";
        
        $stmt = $this->conexion->prepare($query);
        
        // Para buscar el ID exacto o texto en otros campos
        $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->data = $result->fetch_all(MYSQLI_ASSOC) ?: [];
        } else {
            $this->data = [
                'status' => 'error',
                'message' => 'Error en la búsqueda: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }

    //funcion single
    public function single($id) {
        $stmt = $this->conexion->prepare(
            "SELECT * FROM productos WHERE id = ? AND eliminado = 0"
        );
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->data = $result->fetch_assoc() ?: [];
            
            if (empty($this->data)) {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Producto no encontrado o eliminado'
                ];
            }
        } else {
            $this->data = [
                'status' => 'error',
                'message' => 'Error en la consulta: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }

    //funcion SingleByName
    public function SingleByName($name): void {
    $stmt = $this->conexion->prepare(
        "SELECT * FROM productos 
         WHERE nombre = ? AND eliminado = 0"
    );
    $stmt->bind_param("s", $name);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if ($product) {
            array_walk($product, function(&$value) {
                if (is_string($value)) {
                    $value = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
                }
            });
            $this->data = $product;
        } else {
            $this->data = ['status' => 'error', 'message' => 'Producto no encontrado'];
        }
    } else {
        $this->data = ['status' => 'error', 'message' => 'Error en la consulta'];
    }
    
    $stmt->close();
}

    //Funcion getData
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>
