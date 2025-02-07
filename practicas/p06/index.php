<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        include 'src/funciones.php';
        if (isset($_GET['numero'])) {
            $num = htmlspecialchars($_GET['numero']);
            mostrarResultadoEjercicio1($num);
        }
    ?>

    <h2>Ejercicio 2</h2>
    <p>Generar secuencias de números aleatorios hasta obtener impar, par, impar</p>
    <?php
        $resultado = generarSecuenciaImparParImpar();
        echo "<h3>Secuencias generadas:</h3><pre>";
        foreach ($resultado['matriz'] as $fila) {
            echo implode(", ", $fila) . "\n";
        }
        echo "</pre>";
        echo "<p>Números generados: " . $resultado['numerosGenerados'] . "</p>";
        echo "<p>Iteraciones realizadas: " . $resultado['iteraciones'] . "</p>";
    ?>
</body>
</html>
