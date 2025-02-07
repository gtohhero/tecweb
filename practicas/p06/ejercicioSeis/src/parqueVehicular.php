<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Parque vehicular de una ciudad</title>
    </head>
    <body>
        <?php
        $arregloParqueV=array(
            'XPG2947'=>array(
                'Auto'=>array('Marca'=>'Toyota', 'Modelo (año)'=>'2018', 'Tipo'=>'Sedán'),
                'Propietario'=>array('Nombre'=>'Juan Pérez', 'Ciudad'=>'Guadalajara', 'Dirección'=>'Av. Reforma 123')
            ),
            'MTZ8301'=>array(
                'Auto'=>array('Marca'=>'Honda', 'Modelo (año)'=>'2020', 'Tipo'=>'Hatchback'),
                'Propietario'=>array('Nombre'=>'María López', 'Ciudad'=>'Monterrey', 'Dirección'=>'Calle Juárez 456')
            ),
            'JQR5162'=>array(
                'Auto'=>array('Marca'=>'Ford', 'Modelo (año)'=>'2017', 'Tipo'=>'Camioneta'),
                'Propietario'=>array('Nombre'=>'Carlos Ramírez', 'Ciudad'=>'CDMX', 'Dirección'=>'Av. Insurgentes 789')
            ),
            'LNB7403'=>array(
                'Auto'=>array('Marca'=>'Nissan', 'Modelo (año)'=>'2019', 'Tipo'=>'Sedán'),
                'Propietario'=>array('Nombre'=>'Ana Torres', 'Ciudad'=>'Puebla', 'Dirección'=>'Calle Morelos 321')
            ),
            'ZCY1058'=>array( 
                'Auto'=>array('Marca'=>'Chevrolet', 'Modelo (año)'=>'2016', 'Tipo'=>'Hatchback'),
                'Propietario'=>array('Nombre'=>'Pedro Gómez', 'Ciudad'=>'Toluca', 'Dirección'=>'Av. Hidalgo 654')
            ),
            'VKH3289'=>array( 
                'Auto'=>array('Marca'=>'Mazda', 'Modelo (año)'=>'2021', 'Tipo'=>'Sedán'),
                'Propietario'=>array('Nombre'=>'Laura Fernández', 'Ciudad'=>'Mérida', 'Dirección'=>'Calle 50 No. 987')
            ),
            'WDR6724'=>array( 
                'Auto'=>array('Marca'=>'Volkswagen', 'Modelo (año)'=>'2015', 'Tipo'=>'Camioneta'),
                'Propietario'=>array('Nombre'=>'Jorge Salinas', 'Ciudad'=>'León', 'Dirección'=>'Blvd. Campestre 741')
            ),
            'BXS9012'=>array( 
                'Auto'=>array('Marca'=>'Hyundai', 'Modelo (año)'=>'2022', 'Tipo'=>'Hatchback'),
                'Propietario'=>array('Nombre'=>'Gabriela Chávez', 'Ciudad'=>'Queretaro', 'Dirección'=>'Calle 5 de Mayo 159')
            ),
            'HML4537'=>array( 
                'Auto'=>array('Marca'=>'Kia', 'Modelo (año)'=>'2018', 'Tipo'=>'Sedán'),
                'Propietario'=>array('Nombre'=>'Roberto Medina', 'Ciudad'=>'Morelia', 'Dirección'=>'Av. Camelinas 200')
            ),
            'CFP2176'=>array( 
                'Auto'=>array('Marca'=>'Renault', 'Modelo (año)'=>'2019', 'Tipo'=>'Camioneta'),
                'Propietario'=>array('Nombre'=>'Sofía Estrada', 'Ciudad'=>'Aguascalientes', 'Dirección'=>'Calle Zaragoza 369')
            ),
            'TRZ8890'=>array( 
                'Auto'=>array('Marca'=>'Subaru', 'Modelo (año)'=>'2020', 'Tipo'=>'Hatchback'),
                'Propietario'=>array('Nombre'=>'Daniel Herrera', 'Ciudad'=>'Tijuana', 'Dirección'=>'Av. Revolución 777')
            ),
            'YQN6345'=>array( 
                'Auto'=>array('Marca'=>'BMW', 'Modelo (año)'=>'2021', 'Tipo'=>'Sedán'),
                'Propietario'=>array('Nombre'=>'Patricio Orozco', 'Ciudad'=>'Chihuahua', 'Dirección'=>'Calle Victoria 852')
            ),
            'DJK5028'=>array( 
                'Auto'=>array('Marca'=>'Mercedes-Benz', 'Modelo (año)'=>'2017', 'Tipo'=>'Camioneta'),
                'Propietario'=>array('Nombre'=>'Alejandro Vargas', 'Ciudad'=>'San Luis Potosí', 'Dirección'=>'Calle Carranza 951')
            ),
            'SGM7613'=>array( 
                'Auto'=>array('Marca'=>'Audi', 'Modelo (año)'=>'2022', 'Tipo'=>'Hatchback'),
                'Propietario'=>array('Nombre'=>'Valeria Núñez', 'Ciudad'=>'Saltillo', 'Dirección'=>'Av. Universidad 115')
            ),
            'NFW3481'=>array( 
                'Auto'=>array('Marca'=>'Tesla', 'Modelo (año)'=>'2023', 'Tipo'=>'Sedán'),
                'Propietario'=>array('Nombre'=>'Francisco Ríos', 'Ciudad'=>'Hermosillo', 'Dirección'=>'Calle Reforma 620')
            )
        );

        if(isset($_POST["matricula"])) {
            $matricula=$_POST["matricula"];

            print_r($arregloParqueV[$matricula]);
        }

        if(isset($_POST["verTodos"])) {
            print_r($arregloParqueV);
        }

        echo '<br><br>';
        echo '<a href="../consulta.html">Regresar a formulario</a>';

        ?>
        
    </body>
</html>