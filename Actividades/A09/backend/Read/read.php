<?php

namespace Backend\Read;
use Backend\Myapi\DataBase; 

class Read extends DataBase{
    private $response = [];

    public function __construct($database = 'marketzone', $user = 'root', $password = 'CondeGod16a') {

        parent::__construct($database, $user, $password);
        $this->response = [];
    }

    public function getData(){
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

    public function dataProduct($search) {
        $this->response = [];
        $search = $this->conexion->real_escape_string($search);

        $sql = "SELECT * FROM productos WHERE nombre = '$search' AND eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
    
            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->response[$num][$key] = utf8_encode($value);
                    }
                }
            }
    
            $result->free();
        } else {
            $this->response['error'] = "Query Error: " . $this->conexion->error;
        }
        return $this->getData();
    }

    public function listProduct() {
        $this->response = [];
    
        $sql = "SELECT * FROM productos WHERE eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $num => $row) {
                foreach ($row as $key => $value) {
                    $this->response[$num][$key] = utf8_encode($value);
                }
            }
    
            $result->free(); 
        } else {
            $this->response['error'] = "Query Error: " . $this->conexion->error;
        }
    
        return $this->getData();
    }

    public function searchProduct($search) {
        $this->response = [];
    
        if (!empty($search)) {
            $search = $this->conexion->real_escape_string($search);
            $sql = "SELECT * FROM productos 
                    WHERE (id = '{$search}' 
                        OR nombre LIKE '%{$search}%' 
                        OR marca LIKE '%{$search}%' 
                        OR detalles LIKE '%{$search}%') 
                    AND eliminado = 0";

            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
    
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->response[$num][$key] = utf8_encode($value);
                    }
                }
    
                $result->free();
            } else {
                $this->response['error'] = "Query Error: " . $this->conexion->error;
            }
        } else {
            $this->response['error'] = "El parámetro de búsqueda no puede estar vacío.";
        }
    
        return $this->getData();
    }

    public function singleProduct($id) {
        $this->response = [];

        if (!empty($id)) {
            $id = $this->conexion->real_escape_string($id);
    
            $sql = "SELECT * FROM productos WHERE id = {$id}";
            if ($result = $this->conexion->query($sql)) {
                if ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $this->response[$key] = utf8_encode($value);
                    }
                } else {
                    $this->response['error'] = "No se encontró un producto con el ID proporcionado.";
                }
    
                $result->free();
            } else {
                $this->response['error'] = "Query Error: " . $this->conexion->error;
            }
        } else {
            $this->response['error'] = "El parámetro de ID no puede estar vacío.";
        }
    
        return $this->getData();
    }
}

?>