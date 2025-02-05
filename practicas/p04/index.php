<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        // Declaración de variables
        $_myvar = "valor1";
        $_7var = "valor2";
        //myvar;       // Inválida
        $myvar = "valor3";
        $var7 = "valor4";
        $_element1 = "valor5";
        //$house*5;     // Inválida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dólar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
        unset($_myvar, $_7var, $myvar, $var7, $_element1);

        //Se añadió la declaración XML.
        //Se asignaron valores a las variables para evitar advertencias.
    ?>
<h2>Ejercicio 2</h2>
    <?php
    
    echo '<h4>Respuesta:</h4>';

        // Declaración de variables
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a; // Referencia a $a

        // Mostrar valores iniciales
        echo '<h4>Estado inicial:</h4>';
        echo "<p>a: $a</p>";
        echo "<p>b: $b</p>";
        echo "<p>c: $c</p>";

        // Modificación de valores
        $a = "PHP server";
        $b = &$a; 
        $c = &$a; 

        // Mostrar valores después del cambio
        echo '<h4>Después del cambio:</h4>';
        echo "<p>a: $a</p>";
        echo "<p>b: $b</p>";
        echo "<p>c: $c</p>";

        // Explicación del resultado
        echo '<h4>Explicación:</h4>';
        echo '<p>Inicialmente, $c era una referencia a $a, entonces cualquier cambio en $a también se reflejaba en $c.</p>';
        echo '<p>Luego, cuando se asigna $b = &$a, $b también se convirtió en una referencia a $a. Asi que, ahora tanto $b como $c tienen el mismo valor que $a.</p>';
        unset($a, $b, $c);
    ?>

<h2>Ejercicio 3 </h2>
    <?php
        $a = "PHP5";
        $z[] = &$a;
        $b = "5a version de PHP";
        @$c = $b * 10;
        $a .= $b;
        @$b *= $c;
        $z[0] = "MySQL";

        echo "a: $a <br />";  
        echo "z[0]: $z[0] <br />";  
        echo "b: $b <br />";  
        echo "c: $c <br />";  
        echo "a.: $a <br />"; 
        echo "b: $b <br />";  
        echo "z[0]: $z[0] <br />"; 

        unset($a, $b, $c, $z);
    ?>

<h2>Ejercicio 4 con global</h2>
    <?php
        $a = "PHP5";
        $z[] = &$a;
        $b = "5a version de PHP";
        @$c = 10 * $b;
        $a .= $b;
        @$b *= $c;
        $z[0] = "MySQL";

        function mostrarValoresGlobal() {
            global $a, $b, $c, $z;
            echo "a: $a <br />";  
            echo "z[0]: $z[0] <br />";  
            echo "b: $b <br />";  
            echo "c: $c <br />";  
            echo "a.: $a <br />"; 
            echo "b: $b <br />";  
            echo "z[0]: $z[0] <br />"; 
        }

        mostrarValoresGlobal();

        unset($a, $b, $c, $z);
    ?>

<h2>Ejercicio 5</h2>
    <?php
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo "a: $a <br />";  
        echo "b: $b <br />";  
        echo "c: $c <br />";   

        unset($a, $b, $c);
    ?>

</body>
</html>
