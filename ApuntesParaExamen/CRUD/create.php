<?php
//Cogemos el fichero de configuracion donde estara elementos como la contraseña, el servidor, etc
require "config.php";

// Insertar datos variables en la tabla designada. Sacar los nombres de las columnas de la tabla para que el codigo sea reutilizable y procese cualquier tabla.
function insertar($link, $tabla, ...$args)
{
    //1º Te enseña las columnas de la tabla
    $sql = "SHOW COLUMNS FROM $tabla";
    $columnas = mysqli_query($link, $sql);

    //Aquí empieza la consulta de sql
    $sql = "INSERT INTO $tabla (";
    //salta la primera columna que es el id
    $columnas->fetch_assoc();

    //Te concatena cada columna en una linea y te la separa por comas
    while ($columna = $columnas->fetch_assoc()) {
        $sql .= $columna['Field'] . ",";
    }

    $sql = substr($sql, 0, -1) . ") VALUES (";
    foreach ($args as $arg) {
        $sql .= "'$arg',";
    }
    //Aqui hacemos que al final haya un parentesis
    $sql = substr($sql, 0, -1) . ")";

    //Si se ha hecho devuelve true y si no, false
    if (mysqli_query($link, $sql)) {
        return true;
    } else {
        return false;
    }
}

//Comprobar elementos como el nombre, el email o la clave
function comprobarNombre($nombre)
{
    if (strlen($nombre) < 3 || strlen($nombre) > 20) {
        return false;
    }
    return true;
}

function comprobarEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 30) {
        return true;
    }
    return false;
}

function comprobarClave($clave)
{
    if (strlen($clave) < 8) {
        return false;
    }
    return true;
}

function comprobarUsuario($link, $usuario)
{
    if (strlen($usuario) < 3 || strlen($usuario) > 20) {
        return false;
    }
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            mysqli_free_result($result);
            return false;
        }
        mysqli_free_result($result);
        return true;
    }
    return false;
}

//Comprobamos los errores 
$error_nombre = $error_email = $error_clave = $error_usuario = $error_insercion = false;
$nombre = $email = $clave = $usuario = "";

//--------------CREAR-------------------
//Cuando se pulsa el boton empieza la chicha
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $usuario = $_POST['usuario'];
    if (!comprobarNombre($nombre)) {
        $error_nombre = true;
    }
    if (!comprobarEmail($email)) {
        $error_email = true;
    }
    if (!comprobarClave($clave)) {
        $error_clave = true;
    }
    if (!comprobarUsuario($link, $usuario)) {
        $error_usuario = true;
    }
    if (!$error_nombre && !$error_email && !$error_clave && !$error_usuario) {
        $clave = md5($clave);
        if (insertar($link, "usuarios", $nombre, $email, $usuario, $clave)) {
            header("location: index.php");
        } else {
            $error_insercion = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <header>
            <h1>Crear usuario</h1>
        </header>
        <main>
            <?php
            if ($error_insercion) {
                echo "<span style='color:red;font-style: italic;'>Error al insertar los datos, vuleve a intentarlo más tarde</span>";
            }
            ?>
            <form action="create.php" method="post" class="centrar">

                <!--Nombre-->
                <?php if ($error_nombre) { ?>
                    <span style="color:red;font-style: italic;">El nombre no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                </div>

                <!--Email-->
                <?php if ($error_email) { ?>
                    <span style="color:red;font-style: italic;">El email no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
                </div>

                <!--Usuario-->
                <?php if ($error_usuario) { ?>
                    <span style="color:red;font-style: italic;">El usuario ya existe o no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                </div>

                <!--Clave-->
                <?php if ($error_clave) { ?>
                    <span style="color:red;font-style: italic;">La clave debe tener al menos 8 caracteres.</span>
                <?php } ?>
                <div class="input">
                    <label for="clave">Clave</label>
                    <input type="password" name="clave" id="clave">
                </div>

                <!--Botones-->
                <div>
                    <input type="submit" name="crear" value="Crear" class="boton">
                    <input type="submit" formaction="index.php" value="Volver" class="boton">
                </div>

            </form>
        </main>
    </div>
</body>

</html>