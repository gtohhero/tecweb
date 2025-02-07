<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Mensaje de bienvenida</title>
    </head>
    <body>
        <?php
            if(isset($_POST["edad"]) && isset($_POST["sexo"]))
            {
                $edad=$_POST["edad"];
                $sexo=$_POST["sexo"];

                if($edad >= 18 && $edad <= 35 && $sexo=='femenino') {
                    echo '<h3>Bienvenida, usted está en el rango de edad permitido. Su edad es: '. $edad .'</h3>';
                }
                else {
                    echo '<h3>Lo siento. No cumple con los requisitos.</h3>';
                }
            }
        ?>
    </body>
</html>