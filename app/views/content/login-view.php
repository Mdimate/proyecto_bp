<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>app/views/css/login.css">
    <title>Login</title>
</head>
<body>

    <section class="login-container"> 
        <form action="" method="POST" >
            <input type="text" name="login_usuario" id="correo" placeholder="Correo" >
            <br><br>
            <input type="password" name="login_clave" id="contraseña" placeholder="Contraseña">
            <br><br>
        <input type="submit" value="Ingresar" id="boton">
        <button type="button" id="boton_registro" onclick="window.location.href='<?php echo APP_URL; ?>registrarse/'">Registrar</button>
        </form>
    </section>

</body>
</html>


