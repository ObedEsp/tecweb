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
//Funcion para consultar los vehiculos
function consultarVehiculo($matricula) {
    $vehiculos = obtenerVehiculos(); // Función que devuelve los datos
    if (array_key_exists($matricula, $vehiculos)) {
        $info = $vehiculos[$matricula];
        $propietario = $info["Propietario"];
        return "<div class='result'>
            <strong>Matrícula:</strong> $matricula<br>
            <strong>Marca:</strong> {$info['Marca']}<br>
            <strong>Modelo:</strong> {$info['Modelo']}<br>
            <strong>Año:</strong> {$info['Año']}<br>
            <strong>Color:</strong> {$info['Color']}<br>
            <strong>Propietario:</strong> {$propietario['Nombre']}<br>
            <strong>Ciudad:</strong> {$propietario['Ciudad']}<br>
            <strong>Dirección:</strong> {$propietario['Dirección']}
        </div>";
    } else {
        return "<div class='result'>No se encontró un vehículo con la matrícula '$matricula'.</div>";
    }
}

function mostrarTodosVehiculos() {
    $vehiculos = obtenerVehiculos(); // Se obtiene la lista de vehículos

    $output = "<div class='result'>";
    foreach ($vehiculos as $matricula => $info) {
        $propietario = $info["Propietario"];
        $output .= "<strong>Matrícula:</strong> $matricula<br>
                    <strong>Marca:</strong> {$info['Marca']}<br>
                    <strong>Modelo:</strong> {$info['Modelo']}<br>
                    <strong>Año:</strong> {$info['Año']}<br>
                    <strong>Color:</strong> {$info['Color']}<br>
                    <strong>Propietario:</strong> {$propietario['Nombre']}<br>
                    <strong>Ciudad:</strong> {$propietario['Ciudad']}<br>
                    <strong>Dirección:</strong> {$propietario['Dirección']}<br><br>";
    }
    $output .= "</div>";

    return $output;
}

// Nueva función que devuelve la lista de vehículos
function obtenerVehiculos() {
    return [
        "ABC1234" => ["Marca" => "Toyota", "Modelo" => "Corolla", "Año" => 2020, "Color" => "Rojo", "Propietario" => ["Nombre" => "Juan Pérez", "Ciudad" => "Puebla", "Dirección" => "Av. Reforma 123"]],
        "XYZ5678" => ["Marca" => "Honda", "Modelo" => "Civic", "Año" => 2019, "Color" => "Azul", "Propietario" => ["Nombre" => "María López", "Ciudad" => "Puebla", "Dirección" => "Calle 5 de Mayo 456"]],
        "LMN3456" => ["Marca" => "Ford", "Modelo" => "Focus", "Año" => 2018, "Color" => "Negro", "Propietario" => ["Nombre" => "Carlos Sánchez", "Ciudad" => "Puebla", "Dirección" => "Blvd. Hermanos Serdán 789"]],
        "DEF7890" => ["Marca" => "Chevrolet", "Modelo" => "Malibu", "Año" => 2021, "Color" => "Blanco", "Propietario" => ["Nombre" => "Ana Rodríguez", "Ciudad" => "Puebla", "Dirección" => "Calle Zaragoza 321"]],
        "GHI2345" => ["Marca" => "Nissan", "Modelo" => "Sentra", "Año" => 2022, "Color" => "Gris", "Propietario" => ["Nombre" => "Luis Gómez", "Ciudad" => "Puebla", "Dirección" => "Av. Juárez 654"]],
        "JKL6789" => ["Marca" => "Mazda", "Modelo" => "Mazda3", "Año" => 2020, "Color" => "Plateado", "Propietario" => ["Nombre" => "Pedro Ramírez", "Ciudad" => "Puebla", "Dirección" => "Col. La Paz 987"]],
        "PQR1122" => ["Marca" => "Volkswagen", "Modelo" => "Jetta", "Año" => 2017, "Color" => "Verde", "Propietario" => ["Nombre" => "Laura Torres", "Ciudad" => "Puebla", "Dirección" => "Calle Independencia 741"]],
        "STU3344" => ["Marca" => "Hyundai", "Modelo" => "Elantra", "Año" => 2019, "Color" => "Negro", "Propietario" => ["Nombre" => "Ricardo Mendoza", "Ciudad" => "Puebla", "Dirección" => "Av. Las Torres 159"]],
        "VWX5566" => ["Marca" => "Kia", "Modelo" => "Forte", "Año" => 2021, "Color" => "Azul", "Propietario" => ["Nombre" => "Gabriela Flores", "Ciudad" => "Puebla", "Dirección" => "Calle Hidalgo 753"]],
        "YZA7788" => ["Marca" => "Tesla", "Modelo" => "Model 3", "Año" => 2022, "Color" => "Blanco", "Propietario" => ["Nombre" => "Fernando Castillo", "Ciudad" => "Puebla", "Dirección" => "Blvd. Atlixcayotl 852"]]
    ];
}
?>