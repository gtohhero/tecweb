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
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';

        unset($_myvar, $_7var, $myvar,  $var7, $_element1);
    ?>
    
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sige:</p>
    <p>
        $a = "ManejadorSQL"; <br>
        $b = 'MySQL'; <br>
        $c = &$a;
    </p>
    
    <?php
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;

        echo '<ol>';
        echo '<li>Ahora muestra el contenido de cada variable</li>';
        echo '<p>Valor de $a es: ' . "$a" . '</p>';
        echo '<p>Valor de $b es: ' . "$b" . '</p>';
        echo '<p>Valor de $c es: ' . "$c" . '</p>';

        echo '<li>Agrega el código actual las siguientes asignaciones:</li>';

        echo '<br><div style="margin-left: -40px;">$a = "PHP server" <br>';
        echo '$b = &$a</div>';

        $a = "PHP server";
        $b = &$a;

        echo '<br><li>Vuelve a mostrar el contenido de cada uno</li>';
        echo '<p>Valor de $a es: ' . "$a" . '</p>';
        echo '<p>Valor de $b es: ' . "$b" . '</p>';
        echo '<p>Valor de $c es: ' . "$c" . '</p>';
        echo '</ol>';

        echo '<h4>Respuesta:</h4>';   
    
        echo '<p>';
        echo 'Tanto $c y $b son referencias a $a, por lo que al momento de imprimir los valores,  las tres varaibles imprimen el mismo contenido';
        echo '</p>';

        unset($a, $b, $c);
    ?>

    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación, verificar la evolución del tipo de estas variables (imprime todos los componentes del arreglo):</p>
    <p>
        $a = "PHP5"; <br>
        $z[] = &$a; <br>
        $b = "5a version de PHP"; <br>
        $c = $b*10; <br>
        $a . = $b; <br>
        $b * = $c; <br>
        $z[0] = "MySQL";
    </p>

    <?php
        $a = "PHP5";
        echo '<ol>';
        echo '<li>Valor de $a es: </li>' . "$a" . "<br>";
        var_dump($a);

        $z[] = &$a;
        echo '<li>Valor de $z[] es: </li>';
        var_dump($z);

        $b = "5a version de PHP";
        echo '<li>Valor de $b es: </li>' . "$b" . "<br>";
        var_dump($b);

        $c = $b * 10;
        echo '<li>Valor de $c es: </li>' . "$c" . "<br>";
        var_dump($c);

        $a .= $b;
        echo '<li>Valor de $a es: </li>' . "$a" . "<br>";
        var_dump($a);

        $b *= $c;
        echo '<li>Valor de $b es: </li>' . "$b" . "<br>";
        var_dump($b);

        $z[0] = "MySQL";
        echo '<li>Valor de $z[0] es: </li>' . "$z[0]" . "<br>";
        var_dump($z[0]);
        echo '</ol>';
    ?>

    <h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de la matriz $GLOBALS o del modificador global de PHP.</p>

    <?php
        global $a, $b, $c, $z;
        
        echo '<ol>';
        echo '<li>Valor de $a es: </li>' . "$a" . "<br>";
        var_dump($a);

        echo '<li>Valor de $z[] es: </li>';
        var_dump($z);

        echo '<li>Valor de $c es: </li>' . "$c" . "<br>";
        var_dump($c);

        echo '<li>Valor de $z[0] es: </li>' . "$z[0]" . "<br>";
        var_dump($z[0]);
        echo '</ol>';

        unset($a, $z, $b, $c);
    ?>

    <h2>Ejercicio 5</h2>    
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <p>
        $a = "7 personas"; <br>
        $b = (integer) $a; <br>
        $a = "9E3"; <br>
        $c = (double) $a; <br>
    </p>

    <?php
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;
    ?>

</body>
</html>