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

// Función para generar una secuencia de números aleatorios hasta obtener impar, par, impar
function generarSecuenciaImparParImpar() {
    $matriz = []; // Matriz para almacenar las secuencias
    $iteraciones = 0; // Contador de iteraciones
    $numerosGenerados = 0; // Contador de números generados

    while (true) {
        $secuencia = []; // Array para almacenar la secuencia actual
        $iteraciones++;

        // Generar 3 números aleatorios
        for ($i = 0; $i < 3; $i++) {
            $numero = rand(1, 1000); // Número aleatorio entre 1 y 1000
            $secuencia[] = $numero;
            $numerosGenerados++;
        }

        // Verificar si la secuencia cumple con impar, par, impar
        if ($secuencia[0] % 2 != 0 && $secuencia[1] % 2 == 0 && $secuencia[2] % 2 != 0) {
            $matriz[] = $secuencia; // Almacenar la secuencia en la matriz
            break; // Salir del bucle
        } else {
            $matriz[] = $secuencia; // Almacenar la secuencia en la matriz
        }
    }

    // Devolver la matriz, el número de iteraciones y la cantidad de números generados
    return [
        'matriz' => $matriz,
        'iteraciones' => $iteraciones,
        'numerosGenerados' => $numerosGenerados
    ];
}
?>