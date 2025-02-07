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

// Función para encontrar un número aleatorio múltiplo de un número dado (usando while)
function encontrarMultiploConWhile($numeroDado) {
    $intentos = 0; // Contador de intentos
    $numerosGenerados = []; // Arreglo para almacenar los números generados

    while (true) {
        $intentos++;
        $numeroAleatorio = rand(1, 1000); // Generar un número aleatorio entre 1 y 1000
        $numerosGenerados[] = $numeroAleatorio; // Almacenar el número generado

        if ($numeroAleatorio % $numeroDado == 0) {
            return [
                'numero' => $numeroAleatorio,
                'intentos' => $intentos,
                'numerosGenerados' => $numerosGenerados
            ];
        }
    }
}

// Función para encontrar un número aleatorio múltiplo de un número dado (usando do-while)
function encontrarMultiploConDoWhile($numeroDado) {
    $intentos = 0; // Contador de intentos
    $numerosGenerados = []; // Arreglo para almacenar los números generados

    do {
        $intentos++;
        $numeroAleatorio = rand(1, 1000); // Generar un número aleatorio entre 1 y 1000
        $numerosGenerados[] = $numeroAleatorio; // Almacenar el número generado
    } while ($numeroAleatorio % $numeroDado != 0);

    return [
        'numero' => $numeroAleatorio,
        'intentos' => $intentos,
        'numerosGenerados' => $numerosGenerados
    ];
}

// Función para crear un arreglo con índices de 97 a 122 y valores de 'a' a 'z'
function crearArregloLetras() {
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i); // Usar chr() para obtener el carácter ASCII
    }
    return $arreglo;
}

// Función para generar una tabla XHTML a partir del arreglo de letras
function generarTablaLetras($arreglo) {
    echo '<table border="1">';
    echo '<tr><th>Índice</th><th>Letra</th></tr>';
    foreach ($arreglo as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>";
    }
    echo '</table>';
}
?>