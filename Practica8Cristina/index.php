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

        img {
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

    if (isset($_POST["btnListar"])) {
        $consulta = "select * from usuarios where id_usuario='" . $_POST["btnListar"] . "'";
        $resultado = mysqli_query($conexion, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            $datos_usuario = mysqli_fetch_assoc($resultado);
            echo "<div class='centrar'>";
            echo "<h2>Datos del usuario</h2>";
            echo "<p>Id Usuario: " . $datos_usuario["id_usuario"] . "</p>";
            echo "<p>Usuario: " . $datos_usuario["usuario"] . "</p>";
            echo "<p>Clave: " . $datos_usuario["clave"] . "</p>";
            echo "<p>Nombre: " . $datos_usuario["nombre"] . "</p>";
            echo "<p>DNI: " . $datos_usuario["dni"] . "</p>";
            echo "<p>Sexo: " . $datos_usuario["sexo"] . "</p>";
            echo "<p>Foto: <img src='img/" . $datos_usuario["foto"] . "' alt='Foto de perfil' title='foto de perfil'/></p>";
            echo "";
        } else {
            echo "El usuario está vacio";
        }
        echo " <form action='index.php' method='post'><p><button type='submit'>Volver</button></p></form></div>";
        mysqli_free_result($resultado);
    }
    $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContinuarBorrar"] . "';";
    $resultado = mysqli_query($conexion, $consulta);

    if (isset($_POST["btnBorrar"])) {

        //Esto es para un mensaje de confirmación
        echo "<div class='centrar'>";
        echo "<h3>Borrado del usuario " . $_POST["btnListar"] . "</h3>";
        echo "<p>¿Estas seguro?</p>";
        echo "<form method='post' action='index.php'>";
        echo "<p><button type='submit'>Volver</button> <button type='submit' value='" . $_POST["btnContinuarBorrar"] . "' name='btnContinuarBorrar'>Continuar</button></p>";
        echo "</form>";
        echo "</div>";
    }


    if (isset($_POST["btnEditar"])) {
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
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $tupla["id_usuario"] . "</td>";
            echo "<td><img src='img/" . $tupla["foto"] . "' alt='Foto de perfil' title='foto de perfil'/></td>";
            echo "<td><form method='post' action='index.php'><button type='submit' value='" . $tupla["id_usuario"] . "' name='btnListar' class='enlace'>" . $tupla["nombre"] . "</button></form></td>";
            echo "<td><form method='post' action='index.php'><button type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar' class='enlace'>Borrar</button></form> - <form method='post' action='index.php'><button type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar' class='enlace'>Editar</button></form></td>";
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