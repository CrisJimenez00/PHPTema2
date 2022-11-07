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
        @$conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        if (!$conexion) {
            die("Imposible conectar; Error nº:" . mysqli_connect_errno() . ":" . mysqli_connect_error());
        }
    }
    $consulta = "select * from t_alumnos";
    try {
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        die("Imposible realizar la consulta; Error nº:" . mysqli_connect_errno() . ":" . mysqli_error($conexion));
    }


    ?>
</body>

</html>