<?php
require "src/funciones.php";
require "src/bd_config.php";
if (isset($_POST["usuario_nuevo"])) {
    $mensaje_accion = "Usuario registrado con éxito";
}

if (isset($_POST["btnContinuarEditar"])) {
    $error_img = $_POST["usuario"] == "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Practica 8</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse
        }

        td img {
            height: 75px
        }

        .txt_centrado {
            text-align: center;
        }

        .centrar {
            width: 80%;
            margin: 1em auto;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
    </style>
</head>

<body>
    <h1 class='txt_centrado'>Practica 8</h1>
    <?php
    //Importante porque en caso de que no haga la conexión te saldra un mensaje
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>");
    }

    //Para controlar el error del select
    try {
        $consulta = "select * from usuarios";

        //Te almacena la sentencia de consulta en la base de datos de conexion.
        $resultado = mysqli_query($conexion, $consulta);
        echo "<h3 class='centrar'>Listado de los Usuarios</h3>";

        //Comienzo de la tabla
        echo "<table class='txt_centrado centrar'>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th>Usuario+</th></tr>";

        //Esto es para que todo se vea como celdas de una tabla
        while($tupla=mysqli_fetch_assoc($resultado)){
            echo "<tr>";
            echo "<td>".$tupla["id_usuario"]."</td>";
            echo "<td><img src='img/".$tupla["foto"]."' alt='Foto de perfil' title='foto de perfil'/></td>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td>Borrar - Editar</td>";
            echo "</tr>";
        }

        echo "</table>";
        mysqli_free_result($resultado);
        mysqli_close($conexion);

    } catch (Exception $e) {
        die("<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>");
    }

    ?>
</body>

</html>