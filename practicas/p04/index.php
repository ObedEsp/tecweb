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
    <p>$_myvar, $_7var, myvar, $myvar, $var7, $_element1, $house*5</p>

    <h4>Respuesta:</h4>
    <ul>
        <li>$_myvar es válida porque inicia con guión bajo.</li>
        <li>$_7var es válida porque inicia con guión bajo.</li>
        <li>myvar es inválida porque no tiene el signo de dólar ($).</li>
        <li>$myvar es válida porque inicia con una letra.</li>
        <li>$var7 es válida porque inicia con una letra.</li>
        <li>$_element1 es válida porque inicia con guión bajo.</li>
        <li>$house*5 es inválida porque el símbolo * no está permitido.</li>
    </ul>

    <h2>Ejercicio 2</h2>
    <h4>Respuesta:</h4>
    <h4>Estado inicial:</h4>
    <p>a: ManejadorSQL</p>
    <p>b: MySQL</p>
    <p>c: ManejadorSQL</p>
    
    <h4>Después del cambio:</h4>
    <p>a: PHP server</p>
    <p>b: PHP server</p>
    <p>c: PHP server</p>

    <h4>Explicación:</h4>
    <p>Inicialmente, $c era una referencia a $a, entonces cualquier cambio en $a también se reflejaba en $c.</p>
    <p>Luego, cuando se asigna $b = &amp;$a, $b también se convirtió en una referencia a $a. Así que, ahora tanto $b como $c tienen el mismo valor que $a.</p>

    <h2>Ejercicio 3</h2>
    <p>a: MySQL <br />z[0]: MySQL <br />b: 250 <br />c: 50 <br />a.: MySQL <br />b: 250 <br />z[0]: MySQL</p>

    <h2>Ejercicio 4 con global</h2>
    <p>a: MySQL <br />z[0]: MySQL <br />b: 250 <br />c: 50 <br />a.: MySQL <br />b: 250 <br />z[0]: MySQL</p>

    <h2>Ejercicio 5</h2>
    <p>a: 9E3 <br />b: 7 <br />c: 9000</p>

    <h2>Ejercicio 6</h2>
    <p>string(1) "0"</p>
    <p>string(4) "TRUE"</p>
    <p>bool(false)</p>
    <p>bool(true)</p>
    <p>bool(false)</p>
    <p>bool(true)</p>

    <h2>Ejercicio 6 con var_export</h2>
    <p>a: 0 <br />b: TRUE <br />c: false <br />d: true <br />e: false <br />f: true</p>
    <p>La función <b>var_export</b> nos da una representación en forma de cadena de una variable, similar al <b>var_dump()</b>, pero aquí devuelve una salida en código PHP que cambia bool a cadena como en este ejemplo.</p>

    <h2>Ejercicio 7</h2>
    <p><b>Versión de Apache y PHP:</b> Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12</p>
    <p><b>Sistema Operativo del Servidor:</b></p>
    <address>Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 82</address>
    <p><b>Idioma del Navegador (Cliente):</b> es,es-ES;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6</p>
    <p>Versión de PHP: 8.2.12</p>

    <div>  <p>
    <p>
  <a href="https://validator.w3.org/check?uri=referer">
    <img src="https://www.w3.org/Icons/valid-html401" alt="¡HTML válido!" style="border:0;width:88px;height:31px">
  </a>
</p>

    </div>

</body>
</html>
