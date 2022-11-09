<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría acceso a BD</title>
</head>

<body>
    <?php
    try {
        //Parte que hace falta para conectarlo a la base de datos
        @$conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");

        //Si no esta te pueden salir errores en la base de datos
        mysqli_set_charset($conexion, "utf8");

    } catch (Exception $e) {

        if (!$conexion) {

            //Con errno nos sale el número del error y con connect error te dice el nombre del fallo(te aparece el fallo en si)
            die("Imposible conectar; Error nº:" . mysqli_connect_errno() . ":" . mysqli_connect_error()); //El error es opcional en el examen, en el ejercicio es obligatorio
        }
    }

    //Esta es la consulta que usaremos en este caso
    $consulta = "select * from t_alumnos";

    try {
        $resultado = mysqli_query($conexion, $consulta);
        //Con esto creamos un array donde en cada posicion de guarda un dato de un elemento
        $tupla = mysqli_fetch_row($resultado); //esto no se usa tanto
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong> " . $tupla[1] . "</p>";

        //El que se usa siempre y te devuelve un array asociativo
        $tupla = mysqli_fetch_assoc($resultado);
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong> " . $tupla["nombre"] . "</p>"; //Asi se piden los datos


        $tupla = mysqli_fetch_array($resultado);
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong> " . $tupla["nombre"] . "</p>";

        mysqli_free_result($resultado);//Se debe de utilizar siempre, libera espacio
        mysqli_close($conexion);//Siempre hay que cerrar 

        //Para que salga bien el tipo de error es obligatorio poner esto
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta; Error nº:" . mysqli_connect_errno() . ":" . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }


    ?>
</body>

</html>