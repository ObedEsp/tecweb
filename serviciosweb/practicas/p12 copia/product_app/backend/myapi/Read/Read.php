<?php
namespace TECWEB\MYAPI\Read;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Read extends DataBase {
    
    public function __construct($db, $user='root', $pass='CondeGod16a') {
        $this->data = array();
        parent::__construct($db, $user, $pass);
    }

    // Método para listar todos los productos
    public function list() {
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "SELECT * FROM productos WHERE eliminado = 0";
        $result = $this->conexion->query($sql);
        $productos = [];
    
        if ($result) {
            // SE OBTIENEN LOS RESULTADOS
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    
        return $productos;
    }

    // Método para buscar productos por nombre
    public function search($search) {
        // SE VERIFICA HABER RECIBIDO EL TÉRMINO DE BÚSQUEDA
        if (isset($search)) {
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql = "SELECT * FROM productos WHERE (id = ? OR nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) AND eliminado = 0";
            $stmt = $this->conexion->prepare($sql);
            $searchTerm = "%" . $search . "%";
            $stmt->bind_param("ssss", $search, $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            $productos = [];
    
            if ($result) {
                // SE OBTIENEN LOS RESULTADOS
                while ($row = $result->fetch_assoc()) {
                    $productos[] = $row;
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
    
            return $productos;
        }
    }

    // Método para obtener un solo producto por su ID
    public function single($id) {
        // SE VERIFICA HABER RECIBIDO EL ID
        if (isset($id)) {
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql = "SELECT * FROM productos WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $producto = null;
    
            if ($result) {
                // SE OBTIENE EL RESULTADO
                $producto = $result->fetch_assoc();
                if ($producto) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach ($producto as $key => $value) {
                        $this->data[$key] = $value;
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
    
            return $producto;
        }
    }
}

$read = new Read('marketzone');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'list') {
        echo json_encode($read->list());
    } elseif ($action == 'search' && isset($_GET['query'])) {
        echo json_encode($read->search($_GET['query']));
    } elseif ($action == 'single' && isset($_POST['id'])) {
        echo json_encode($read->single($_POST['id']));
    }
}
?>
