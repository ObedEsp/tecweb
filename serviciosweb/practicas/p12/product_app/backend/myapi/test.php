<?php
// Asegúrate de que el archivo autoload.php esté correctamente incluido
require_once __DIR__ . '/vendor/autoload.php'; // Asegúrate de que la ruta sea correcta según tu estructura de directorios

// Usa el namespace y la clase correcta
use TECWEB\MYAPI\Read\Read;

// Instancia la clase y usa los métodos
$read = new Read('marketzone');
$productos = $read->list();
echo json_encode($productos);

?>