<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
    </style>
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

        //te devuelve un array repetido, uno que es por indice y otro que es por el nombre de la columna
        $tupla = mysqli_fetch_array($resultado);
        var_dump($tupla);
        echo "<p><strong>Nombre: </strong> " . $tupla["nombre"] . "</p>";

        //Para cuando veamos objetos(lo veremos en el tema 5)
        $tupla = mysqli_fetch_object($resultado);
        var_dump($tupla);
        //Para acceder al objeto se pone ->
        echo "<p><strong>Nombre: </strong> " . $tupla->nombre . "</p>";

        //Para moverte entre tuplas
        mysqli_data_seek($resultado, 0);

        //para saber el numero de duplas obtenidas(nos sirve para for incluso y todo)
        mysqli_num_rows($resultado);

        echo "<table>";
        echo "<tr><th>Codigo Alumno</th><th>Nombre</th><th>Telefono</th><th>Codigo Postal</th></tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr>";
            echo "<td>" . $tupla["cod_alu"] . "</td>";
            echo "<td>" . $tupla["nombre"] . "</td>";
            echo "<td>" . $tupla["telefono"] . "</td>";
            echo "<td>" . $tupla["cp"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        mysqli_free_result($resultado); //Se debe de utilizar siempre, libera espacio
        mysqli_close($conexion); //Siempre hay que cerrar 

        //Para que salga bien el tipo de error es obligatorio poner esto
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta; Error nº:" . mysqli_connect_errno() . ":" . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }


    ?>
</body>

</html>