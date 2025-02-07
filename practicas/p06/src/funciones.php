<?php

// Función para verificar si un número es múltiplo de 5 y 7
function esMultiploDe5y7($numero) {
    return ($numero % 5 == 0 && $numero % 7 == 0);
}

// Función para mostrar el resultado del ejercicio 1
function mostrarResultadoEjercicio1($numero) {
    if (esMultiploDe5y7($numero)) {
        echo '<h3>R= El número ' . $numero . ' SÍ es múltiplo de 5 y 7.</h3>';
    } else {
        echo '<h3>R= El número ' . $numero . ' NO es múltiplo de 5 y 7.</h3>';
    }
}
?>