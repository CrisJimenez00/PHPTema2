<?php
//indicamos la conexion, la tabla y el id del usuario que queremos eliminar
function eliminar($conexion, $tabla, $id)
{
    $consulta = "DELETE FROM $tabla WHERE id = $id";
    if (mysqli_query($conexion, $consulta)) {
        return true;
    } else {
        return false;
    }
}

//Controlamos que se haya pulsado el boton
if (isset($_POST['id']) && !empty(trim($_POST['id']))) {

    // Incluir archivo de configuracion (Se puede poner fuera, pero es para optimizacion del codigo)
    require "config.php";
    $id = $_POST['id'];
    if (eliminar($conexion, "usuarios", $id)) {
        header("location: index.php");
        exit();
    } else {
        echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar usuario</title>
    <!--No lo tengo creado, pero bueno, se entiende que es para dar estilo-->
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <h1>Eliminar usuario <?php echo trim($_GET["id"]).PHP_EOL; ?> ?</h1>
        <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
            <h3>Estás seguro de que quieres eliminar este registro?</h3>
            <div class="centrar">
                <div>
                    <input type="submit" value="Si" class="boton">
                    <button type="button" onclick="window.location.href='index.php'">No</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>