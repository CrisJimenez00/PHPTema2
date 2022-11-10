<?php
if (isset($_POST["btnContinuar"])) {
    
    $error_nombre = $_POST["nombre"] == ""|| repetido();
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["usuario"] == "" || filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $error_formulario = $error_nombre || $error_usuario || $error_clave || $error_usuario;
}
if(!$error_formulario){
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Practica 1</title>
</head>

<body>
    <h1>Nuevo usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p><label for="nombre">Nombre:</label><input type="text" name="nombre" id="nombre" value="<?php
                                                                                                    if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>
        <?php
        if (isset($_POST["nombre"]) && $error_nombre) {
            echo "<span='error'>Campo Vacío</span>";
        }
        ?>" maxlength="30"></p>
        <p><label for="usuario">Usuario:</label><input type="text" name="usuario" id="usuario" value="<?php
                                                                                                        if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>
        <?php
        if (isset($_POST["usuario"]) && $error_usuario) {
            echo "<span='error'>Campo Vacío</span>";
        }
        ?>" maxlength="20"></p>
        <p><label for="clave">Contraseña:</label><input type="text" name="clave" id="clave" value="<?php
                                                                                                    if (isset($_POST["clave"])) echo $_POST["clave"]; ?>
        <?php
        if (isset($_POST["clave"]) && $error_clave) {
            echo "<span='error'>Campo Vacío</span>";
        }
        ?>" maxlength="30"></p>
        <p><label for="email">Email:</label><input type="text" name="email" id="email" value="<?php
                                                                                                if (isset($_POST["email"])) echo $_POST["email"]; ?>
        <?php
        if (isset($_POST["email"]) && $error_email) {
            if ($_POST["email"] == "") {
                echo "<span='error'>Campo Vacío</span>";
            } else {
                echo "<span='error'>Email sintácticamente incorrecto</span>";
            }
        }
        ?>" maxlength="50"></p>

        <p><button type="submit" formaction="index.php" name="btnVolver">Volver</button>
            <button type="submit" name="btnContinuar">Continuar</button>
        </p>
    </form>
</body>

</html>