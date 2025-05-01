<?php

namespace Backend\Create;
use Backend\Myapi\DataBase; 

class Create extends DataBase{
    private $response = [];

    public function __construct($database = 'marketzone', $user = 'root', $password = 'CondeGod16a') {

        parent::__construct($database, $user, $password);
        $this->response = [];
    }

    public function getData(){
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

    public function addProduct($name, $marca, $modelo, $precio, $detalles, $unidades, $imagen) {
        $this->response = [
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        ];
    
        $sql = "SELECT * FROM productos WHERE nombre = '{$this->conexion->real_escape_string($name)}' AND eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (
                    null,
                    '{$this->conexion->real_escape_string($name)}',
                    '{$this->conexion->real_escape_string($marca)}',
                    '{$this->conexion->real_escape_string($modelo)}',
                    {$precio},
                    '{$this->conexion->real_escape_string($detalles)}',
                    {$unidades},
                    '{$this->conexion->real_escape_string($imagen)}',
                    0
                )";
                if ($this->conexion->query($sql)) {
                    $this->response = [
                        'status'  => 'success',
                        'message' => 'Producto agregado'
                    ];
                } else {
                    $this->response['message'] = "ERROR: No se ejecutó la consulta. " . $this->conexion->error;
                }
            }
            $result->free();
        } else {
            $this->response['message'] = "ERROR en la consulta: " . $this->conexion->error;
        }
        return $this->getData();
    }
}
?>