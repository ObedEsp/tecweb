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

    <h2>Ejercicio 3</h2>
    <p>Encontrar el primer número aleatorio múltiplo de un número dado</p>
    <?php
        if (isset($_GET['numeroDado'])) {
            $numeroDado = htmlspecialchars($_GET['numeroDado']);
            $resultadoWhile = encontrarMultiploConWhile($numeroDado);
            echo "<h3>Resultado usando while:</h3>";
            echo "<p>Número encontrado: " . $resultadoWhile['numero'] . "</p>";
            echo "<p>Intentos realizados: " . $resultadoWhile['intentos'] . "</p>";
            echo "<p>Números generados en cada intento: " . implode(", ", $resultadoWhile['numerosGenerados']) . "</p>";
        }
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo con índices de 97 a 122 y valores de 'a' a 'z'</p>
    <?php generarTablaLetras(crearArregloLetras()); ?>

    <h2>Ejemplo de POST</h2>
    <form action="index.php" method="post">
        <label>Name:</label>
        <input type="text" name="name" /><br />
        <label>E-mail:</label>
        <input type="text" name="email" /><br />
        <input type="submit" />
    </form>
    <?php
        if (isset($_POST["name"]) && isset($_POST["email"])) {
            echo htmlspecialchars($_POST["name"]) . "<br />";
            echo htmlspecialchars($_POST["email"]);
        }
    ?>

    <h2>Ejercicio 5</h2>
    <p>Verificar si una persona es de sexo femenino y está en el rango de edad permitido (18-35 años).</p>
    <form action="index.php" method="post">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required="required" /><br /><br />
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required="required">
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select><br /><br />
        <input type="submit" value="Verificar" />
    </form>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edad']) && isset($_POST['sexo'])) {
            $edad = (int) $_POST['edad'];
            $sexo = htmlspecialchars($_POST['sexo']);
            if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
                echo "<p>Bienvenida, usted está en el rango de edad permitido.</p>";
            } else {
                echo "<p>Lo siento, no cumple con los requisitos.</p>";
            }
        }
    ?>

    <h2>Ejercicio 6</h2>
    <form method="post">
        <label>Consultar por matrícula: </label>
        <input type="text" name="matricula" placeholder="Ej: ABC1234" />
        <button type="submit" name="consulta_unica">Consultar</button>
    </form>
    <form method="post">
        <button type="submit" name="mostrar_todos">Mostrar Todos</button>
    </form>
    <div id="resultado">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["consulta_unica"]) && !empty($_POST["matricula"])) {
                    echo consultarVehiculo(htmlspecialchars($_POST["matricula"]));
                } elseif (isset($_POST["mostrar_todos"])) {
                    echo mostrarTodosVehiculos();
                }
            }
        ?>
    </div>
</body>
</html>
