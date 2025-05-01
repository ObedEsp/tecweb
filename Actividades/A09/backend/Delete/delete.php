<?php

namespace Backend\Delete;
use Backend\Myapi\DataBase; 

class Delete extends DataBase{
    private $response = [];

    public function __construct($database = 'marketzone', $user = 'root', $password = 'CondeGod16a') {

        parent::__construct($database, $user, $password);
        $this->response = [];
    }

    public function getData(){
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

    public function deleteData($id) {
        $this->response = [
            'status'  => 'error',
            'message' => 'La consulta falló'
        ];
    
        if (!empty($id)) {
            $id = $this->conexion->real_escape_string($id);
            $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
            if ($this->conexion->query($sql)) {
                $this->response = [
                    'status'  => 'success',
                    'message' => 'Producto eliminado'
                ];
            } else {
                $this->response['message'] = "ERROR: No se ejecutó la consulta. " . $this->conexion->error;
            }
        } else {
            $this->response['message'] = 'ID inválido o no proporcionado.';
        }
        return $this->getData();
    }
}
?>