<?php
require "src/bd_config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ejercicio 1</title>
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

        td img {
            height: 75px;
        }

        .centrado {
            text-align: center;
        }
        .centrar{
            width: 80%;
            margin: .5em auto;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar. Error nº: " . mysqli_connect_errno() . ":" . mysqli_connect_error() . " </p>");
    }

    $consulta = "select * from usuarios";
    try {

        $resultado = mysqli_query($conexion, $consulta);
        echo "<table class='centrado centrar'>";
        echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $tupla["nombre"] . "</td>";
            echo "<td><img src='img/borrar.png' alt='Borrar usuario'/></td>";
            echo "<td><img src='img/editar.png' alt='Editar usuario'/></td>";
            echo "</tr>";
        }
        echo "</table>";

        mysqli_free_result($resultado); //Se debe de utilizar siempre, libera espacio
        mysqli_close($conexion);

        echo "<form class='centrar' action='usuario_nuevo.php' method='post'>";
        echo "<button type='submit' name='btnNuevo'>Nuevo Usuario</button>";
        echo "</form>";

    } catch (Exception $e) {
        $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_connect_errno() . ":" . mysqli_connect_error() . " </p>";
        mysqli_close($conexion);
        die($mensaje);
    }
    ?>
    
</body>

</html>