<?php

namespace Backend\Update;
use Backend\Myapi\DataBase; 

class Update extends DataBase{
    private $response = [];

    public function __construct($database = 'marketzone', $user = 'root', $password = 'CondeGod16a') {

        parent::__construct($database, $user, $password);
        $this->response = [];
    }

    public function getData(){
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

    public function editProduct($id, $name, $brand, $modelo, $precio, $detalles, $unidades, $imagen) {
        $this->response = [
            'status'  => 'error',
            'message' => 'La consulta falló'
        ];
    
        if (!empty($id)) {
            $id = $this->conexion->real_escape_string($id);
            $name = $this->conexion->real_escape_string($name);
            $brand = $this->conexion->real_escape_string($brand);
            $modelo = $this->conexion->real_escape_string($modelo);
            $precio = $this->conexion->real_escape_string($precio);
            $detalles = $this->conexion->real_escape_string($detalles);
            $unidades = $this->conexion->real_escape_string($unidades);
            $imagen = $this->conexion->real_escape_string($imagen);

            $sql = "UPDATE productos SET 
                        nombre='$name', 
                        marca='$brand', 
                        modelo='$modelo', 
                        precio=$precio, 
                        detalles='$detalles', 
                        unidades=$unidades, 
                        imagen='$imagen' 
                    WHERE id=$id";
    
            $this->conexion->set_charset("utf8");
    
            if ($this->conexion->query($sql)) {
                $this->response = [
                    'status'  => 'success',
                    'message' => 'Producto actualizado'
                ];
            } else {
                $this->response['message'] = "Error al actualizar el producto: " . $this->conexion->error;
            }
        } else {
            $this->response['message'] = 'ID inválido o no proporcionado.';
        }

        return $this->getData();
    }
}

?>