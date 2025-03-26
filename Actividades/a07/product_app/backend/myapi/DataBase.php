<?php
namespace MyAPI;

abstract class DataBase {
    protected $conexion;

    public function __construct() {
        $host = 'localhost';
        $user = 'root';
        $pass = 'CondeGod16a';
        $db   = 'marketzone';

        // Conectar a la base de datos
        $this->conexion = new \mysqli($host, $user, $pass, $db);

        // Verificar conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        // Establecer el conjunto de caracteres
        $this->conexion->set_charset("utf8");
    }
}
?>
